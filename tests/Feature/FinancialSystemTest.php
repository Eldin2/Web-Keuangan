<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Siswa;
use App\Models\KategoriTagihan;
use App\Models\Tagihan;
use App\Models\Transaksi;
use App\Models\Keuangan;
use App\Models\Guru;
use App\Models\GajiGuru;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FinancialSystemTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $orangTua;
    protected $kepalaSekolah;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        $this->orangTua = User::factory()->create([
            'name' => 'Wali Murid',
            'email' => 'ortu@example.com',
            'role' => 'orang_tua',
        ]);

        $this->kepalaSekolah = User::factory()->create([
            'name' => 'Kepala Sekolah',
            'email' => 'kepsek@example.com',
            'role' => 'kepala_sekolah',
        ]);
    }

    public function test_dashboard_redirection_by_role()
    {
        $response = $this->actingAs($this->admin)->get('/dashboard');
        $response->assertRedirect(route('admin.dashboard'));

        $response = $this->actingAs($this->orangTua)->get('/dashboard');
        $response->assertRedirect(route('orangtua.dashboard'));

        $response = $this->actingAs($this->kepalaSekolah)->get('/dashboard');
        $response->assertRedirect(route('kepsek.dashboard'));
    }

    public function test_admin_dashboard_and_siswa_management()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));
        $response->assertStatus(200);

        // Store Siswa with parent
        $response = $this->actingAs($this->admin)->post(route('admin.siswa.store'), [
            'nis' => '12345',
            'nama_siswa' => 'Budi Santoso',
            'kelas' => 'TK A',
            'user_id' => $this->orangTua->id,
        ]);
        $response->assertRedirect(route('admin.siswa'));

        // Store Siswa without parent (null user_id)
        $response = $this->actingAs($this->admin)->post(route('admin.siswa.store'), [
            'nis' => '002',
            'nama_siswa' => 'Zilong',
            'kelas' => 'TK B',
            'user_id' => '',
        ]);
        $response->assertRedirect(route('admin.siswa'));

        $this->assertDatabaseHas('siswas', [
            'nis' => '002',
            'nama_siswa' => 'Zilong',
            'user_id' => null,
        ]);

        $siswa = Siswa::where('nis', '12345')->first();

        // Update Siswa
        $response = $this->actingAs($this->admin)->put(route('admin.siswa.update', $siswa->id), [
            'nis' => '12345',
            'nama_siswa' => 'Budi Santoso Edit',
            'kelas' => 'TK B',
            'user_id' => $this->orangTua->id,
        ]);
        $response->assertRedirect(route('admin.siswa'));

        $this->assertDatabaseHas('siswas', [
            'nama_siswa' => 'Budi Santoso Edit',
        ]);
    }

    public function test_admin_tagihan_and_cash_payment()
    {
        $siswa = Siswa::create([
            'user_id' => $this->orangTua->id,
            'nis' => '55555',
            'nama_siswa' => 'Siti Aminah',
            'kelas' => 'TK B',
        ]);

        // Create Tagihan
        $response = $this->actingAs($this->admin)->post(route('admin.tagihan.store'), [
            'siswa_id' => $siswa->id,
            'nama_kategori' => 'SPP Bulan Ini',
            'nominal' => 150000,
        ]);
        $response->assertRedirect(route('admin.tagihan'));

        $tagihan = Tagihan::first();
        $this->assertEquals('belum_bayar', $tagihan->status);

        // Pay Cash
        $response = $this->actingAs($this->admin)->post(route('admin.tagihan.cash', $tagihan->id));
        $response->assertRedirect(route('admin.tagihan'));

        $tagihan->refresh();
        $this->assertEquals('lunas', $tagihan->status);
    }

    public function test_orang_tua_flow_and_admin_verification()
    {
        Storage::fake('public');

        $siswa = Siswa::create([
            'user_id' => $this->orangTua->id,
            'nis' => '77777',
            'nama_siswa' => 'Anak Ortu',
            'kelas' => 'TK A',
        ]);

        // Ortu creates tagihan mandiri
        $response = $this->actingAs($this->orangTua)->post(route('orangtua.tagihan_mandiri.simpan'), [
            'tagihan' => [
                [
                    'siswa_id' => $siswa->id,
                    'nama_kategori' => 'Uang Gedung',
                    'nominal' => 500000,
                ]
            ]
        ]);
        $response->assertRedirect(route('orangtua.tagihan'));

        $tagihan = Tagihan::where('siswa_id', $siswa->id)->first();
        $this->assertNotNull($tagihan);

        // Ortu uploads payment proof
        $file = UploadedFile::fake()->image('bukti.jpg');
        $response = $this->actingAs($this->orangTua)->post(route('orangtua.bayar'), [
            'tagihan_id' => [$tagihan->id],
            'nominal_bayar' => 500000,
            'bukti_bayar' => $file,
        ]);
        $response->assertRedirect(route('orangtua.tagihan'));

        $tagihan->refresh();
        $this->assertEquals('proses_verifikasi', $tagihan->status);

        // Admin approves verification
        $response = $this->actingAs($this->admin)->post(route('admin.verifikasi.setuju', $tagihan->id));
        $response->assertRedirect();

        $tagihan->refresh();
        $this->assertEquals('lunas', $tagihan->status);
    }

    public function test_guru_and_gaji_management()
    {
        // Add Guru
        $response = $this->actingAs($this->admin)->post(route('admin.guru.store'), [
            'nama_guru' => 'Bu Guru Ani',
            'nip' => '19900101',
            'status' => 'Tetap',
            'jabatan' => 'Wali Kelas TK A',
            'gaji_bulanan' => 3000000,
        ]);
        $response->assertRedirect(route('admin.guru.index'));

        $guru = Guru::first();
        $this->assertNotNull($guru);

        // Create Gaji Slip
        $response = $this->actingAs($this->admin)->post(route('admin.gaji.store'), [
            'guru_id' => $guru->id,
            'bulan' => 9,
            'tahun' => 2026,
            'nominal_gaji' => 3000000,
            'potongan' => 100000,
            'tanggal_dibayar' => '2026-09-03',
            'status_pembayaran' => 'dibayar',
        ]);
        $response->assertRedirect(route('admin.gaji.index'));

        $gaji = GajiGuru::first();
        $this->assertEquals(2900000, $gaji->total_gaji);

        // Expense logged in Keuangan
        $this->assertDatabaseHas('keuangans', [
            'tipe' => 'keluar',
            'kategori' => 'Gaji Guru',
            'nominal' => 2900000,
        ]);
    }

    public function test_kepala_sekolah_reports_and_validation()
    {
        $siswa = Siswa::create([
            'user_id' => $this->orangTua->id,
            'nis' => '99999',
            'nama_siswa' => 'Siswa Kepsek',
            'kelas' => 'TK B',
        ]);

        $kategori = KategoriTagihan::create(['nama_kategori' => 'SPP']);
        $tagihan = Tagihan::create([
            'siswa_id' => $siswa->id,
            'kategori_id' => $kategori->id,
            'nominal' => 200000,
            'status' => 'lunas',
        ]);

        $transaksi = Transaksi::create([
            'tagihan_id' => $tagihan->id,
            'bukti_bayar' => 'Pembayaran Tunai',
            'metode' => 'cash',
            'nominal_bayar' => 200000,
            'tanggal_bayar' => now(),
            'is_valid_kepala_sekolah' => false,
        ]);

        // Kepsek views dashboard & laporan
        $response = $this->actingAs($this->kepalaSekolah)->get(route('kepsek.dashboard'));
        $response->assertStatus(200);

        $response = $this->actingAs($this->kepalaSekolah)->get(route('kepsek.laporan'));
        $response->assertStatus(200);

        // Kepsek validates transaction
        $response = $this->actingAs($this->kepalaSekolah)->post(route('kepsek.validasi', $transaksi->id));
        $response->assertRedirect();

        $transaksi->refresh();
        $this->assertTrue((bool)$transaksi->is_valid_kepala_sekolah);
    }
}

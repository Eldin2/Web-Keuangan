<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Siswa;
use App\Models\KategoriTagihan;
use App\Models\Tagihan;
use App\Models\Transaksi;
use App\Models\Keuangan;
use App\Models\Guru;
use App\Models\GajiGuru;
use App\Models\Setting;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 1. Akun Pengguna (Users)
        $admin = User::firstOrCreate(
            ['email' => 'admin@tkit.com'],
            [
                'name' => 'Admin Sekolah',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        $adminAlt = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator Utama',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        $kepsek = User::firstOrCreate(
            ['email' => 'kepsek@tkit.com'],
            [
                'name' => 'Hj. Aminah, M.Pd.',
                'password' => Hash::make('kepsek123'),
                'role' => 'kepala_sekolah',
            ]
        );

        $ortu1 = User::firstOrCreate(
            ['email' => 'ortu@tkit.com'],
            [
                'name' => 'Budi Santoso (Wali Ahmad)',
                'password' => Hash::make('ortu123'),
                'role' => 'orang_tua',
            ]
        );

        $ortu2 = User::firstOrCreate(
            ['email' => 'budi@tkit.com'],
            [
                'name' => 'Bambang Pratama (Wali Aisyah)',
                'password' => Hash::make('budi123'),
                'role' => 'orang_tua',
            ]
        );

        $ortu3 = User::firstOrCreate(
            ['email' => 'siti@tkit.com'],
            [
                'name' => 'Siti Rahma (Wali Rizky)',
                'password' => Hash::make('siti123'),
                'role' => 'orang_tua',
            ]
        );

        $ortu4 = User::firstOrCreate(
            ['email' => 'nabila_ortu@tkit.com'],
            [
                'name' => 'Dewi Safitri (Wali Nabila)',
                'password' => Hash::make('ortu123'),
                'role' => 'orang_tua',
            ]
        );

        // 2. Data Siswa
        $siswa1 = Siswa::firstOrCreate(
            ['nis' => '2026001'],
            [
                'user_id' => $ortu1->id,
                'nama_siswa' => 'Ahmad Fauzi',
                'kelas' => 'TK A',
            ]
        );

        $siswa2 = Siswa::firstOrCreate(
            ['nis' => '2026002'],
            [
                'user_id' => $ortu2->id,
                'nama_siswa' => 'Aisyah Az-Zahra',
                'kelas' => 'TK B',
            ]
        );

        $siswa3 = Siswa::firstOrCreate(
            ['nis' => '2026003'],
            [
                'user_id' => $ortu3->id,
                'nama_siswa' => 'Rizky Pratama',
                'kelas' => 'TK A',
            ]
        );

        $siswa4 = Siswa::firstOrCreate(
            ['nis' => '2026004'],
            [
                'user_id' => $ortu4->id,
                'nama_siswa' => 'Nabila Putri',
                'kelas' => 'TK B',
            ]
        );

        // 3. Kategori Tagihan
        $katSpp = KategoriTagihan::firstOrCreate(['nama_kategori' => 'SPP Bulanan']);
        $katGedung = KategoriTagihan::firstOrCreate(['nama_kategori' => 'Uang Gedung & Pendaftaran']);
        $katExtra = KategoriTagihan::firstOrCreate(['nama_kategori' => 'Extrakulikuler & Outing Class']);
        $katSeragam = KategoriTagihan::firstOrCreate(['nama_kategori' => 'Seragam Sekolah']);

        // 4. Data Tagihan & Transaksi
        // Tagihan 1: Ahmad Fauzi - SPP (Lunas Cash)
        $t1 = Tagihan::create([
            'siswa_id' => $siswa1->id,
            'kategori_id' => $katSpp->id,
            'nominal' => 150000,
            'status' => 'lunas',
            'created_at' => now()->subDays(10),
        ]);
        Transaksi::create([
            'tagihan_id' => $t1->id,
            'bukti_bayar' => 'Bayar Tunai di Loket',
            'metode' => 'cash',
            'nominal_bayar' => 150000,
            'tanggal_bayar' => now()->subDays(10),
            'is_valid_kepala_sekolah' => true,
        ]);

        // Tagihan 2: Ahmad Fauzi - Uang Gedung (Proses Verifikasi)
        $t2 = Tagihan::create([
            'siswa_id' => $siswa1->id,
            'kategori_id' => $katGedung->id,
            'nominal' => 500000,
            'status' => 'proses_verifikasi',
            'created_at' => now()->subDays(2),
        ]);
        Transaksi::create([
            'tagihan_id' => $t2->id,
            'bukti_bayar' => 'bukti_bayar/sample.jpg',
            'metode' => 'online',
            'nominal_bayar' => 500000,
            'tanggal_bayar' => now()->subDays(2),
            'is_valid_kepala_sekolah' => false,
        ]);

        // Tagihan 3: Aisyah Az-Zahra - SPP (Lunas Online)
        $t3 = Tagihan::create([
            'siswa_id' => $siswa2->id,
            'kategori_id' => $katSpp->id,
            'nominal' => 150000,
            'status' => 'lunas',
            'created_at' => now()->subDays(5),
        ]);
        Transaksi::create([
            'tagihan_id' => $t3->id,
            'bukti_bayar' => 'bukti_bayar/sample2.jpg',
            'metode' => 'online',
            'nominal_bayar' => 150000,
            'tanggal_bayar' => now()->subDays(5),
            'is_valid_kepala_sekolah' => true,
        ]);

        // Tagihan 4: Aisyah Az-Zahra - Extra (Belum Bayar)
        Tagihan::create([
            'siswa_id' => $siswa2->id,
            'kategori_id' => $katExtra->id,
            'nominal' => 100000,
            'status' => 'belum_bayar',
            'created_at' => now()->subDays(1),
        ]);

        // Tagihan 5: Rizky Pratama - SPP (Salah Nominal)
        Tagihan::create([
            'siswa_id' => $siswa3->id,
            'kategori_id' => $katSpp->id,
            'nominal' => 150000,
            'status' => 'salah_nominal',
            'created_at' => now()->subDays(3),
        ]);

        // Tagihan 6: Nabila Putri - Seragam (Belum Bayar)
        Tagihan::create([
            'siswa_id' => $siswa4->id,
            'kategori_id' => $katSeragam->id,
            'nominal' => 250000,
            'status' => 'belum_bayar',
            'created_at' => now()->subDays(4),
        ]);

        // 5. Data Keuangan (Buku Kas Umum)
        Keuangan::create([
            'tipe' => 'masuk',
            'kategori' => 'Penerimaan SPP',
            'nominal' => 150000,
            'tanggal' => now()->subDays(10)->format('Y-m-d'),
            'keterangan' => 'Pembayaran SPP Ahmad Fauzi (Tunai)',
        ]);

        Keuangan::create([
            'tipe' => 'masuk',
            'kategori' => 'Penerimaan SPP',
            'nominal' => 150000,
            'tanggal' => now()->subDays(5)->format('Y-m-d'),
            'keterangan' => 'Pembayaran SPP Aisyah Az-Zahra (Transfer)',
        ]);

        Keuangan::create([
            'tipe' => 'masuk',
            'kategori' => 'Bantuan Operasional',
            'nominal' => 5000000,
            'tanggal' => now()->subDays(15)->format('Y-m-d'),
            'keterangan' => 'Penerimaan Dana BOS Tahap II',
        ]);

        Keuangan::create([
            'tipe' => 'keluar',
            'kategori' => 'Perlengkapan Belajar',
            'nominal' => 750000,
            'tanggal' => now()->subDays(8)->format('Y-m-d'),
            'keterangan' => 'Pembelian Modul & Alat Mewarnai Siswa',
        ]);

        Keuangan::create([
            'tipe' => 'keluar',
            'kategori' => 'Pemeliharaan Gedung',
            'nominal' => 500000,
            'tanggal' => now()->subDays(6)->format('Y-m-d'),
            'keterangan' => 'Perbaikan Sanitasi & Kebersihan Lingkungan Sekolah',
        ]);

        // 6. Data Guru
        $guru1 = Guru::firstOrCreate(
            ['nip' => '19850101'],
            [
                'nama_guru' => 'Siti Maryam, S.Pd.',
                'status' => 'Tetap',
                'jabatan' => 'Wali Kelas TK A',
                'gaji_bulanan' => 3500000,
            ]
        );

        $guru2 = Guru::firstOrCreate(
            ['nip' => '19900315'],
            [
                'nama_guru' => 'Dewi Lestari, S.Pd.',
                'status' => 'Tetap',
                'jabatan' => 'Wali Kelas TK B',
                'gaji_bulanan' => 3200000,
            ]
        );

        $guru3 = Guru::firstOrCreate(
            ['nip' => '19950720'],
            [
                'nama_guru' => 'Ahmad Hidayat, S.Pd.I',
                'status' => 'Honorer',
                'jabatan' => 'Guru Agama & Mengaji',
                'gaji_bulanan' => 2800000,
            ]
        );

        // 7. Data Gaji Guru
        $gaji1 = GajiGuru::create([
            'guru_id' => $guru1->id,
            'bulan' => 8,
            'tahun' => 2026,
            'nominal_gaji' => 3500000,
            'potongan' => 100000,
            'total_gaji' => 3400000,
            'keterangan' => 'Gaji Bulan Agustus 2026',
            'tanggal_dibayar' => '2026-08-28',
            'status_pembayaran' => 'dibayar',
        ]);

        Keuangan::create([
            'tipe' => 'keluar',
            'kategori' => 'Gaji Guru',
            'nominal' => 3400000,
            'tanggal' => '2026-08-28',
            'keterangan' => "[Gaji Guru] ID Slip: {$gaji1->id} - {$guru1->nama_guru} (Agustus 2026)",
        ]);

        GajiGuru::create([
            'guru_id' => $guru2->id,
            'bulan' => 8,
            'tahun' => 2026,
            'nominal_gaji' => 3200000,
            'potongan' => 0,
            'total_gaji' => 3200000,
            'keterangan' => 'Gaji Bulan Agustus 2026',
            'tanggal_dibayar' => '2026-08-28',
            'status_pembayaran' => 'pending',
        ]);

        // 8. Setting Rekening
        Setting::set('norek_bank_name', 'BRI');
        Setting::set('norek_number', '111 111 1111');
        Setting::set('norek_owner', 'TK IT INSAN CENDIKIA');
    }
}

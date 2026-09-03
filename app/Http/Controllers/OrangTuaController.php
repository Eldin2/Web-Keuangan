<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tagihan;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class OrangTuaController extends Controller
{
    // Halaman Utama Dashboard Orang Tua
    public function dashboard()
    {
        $user_id = Auth::id();

        // 1. Data Anak dari Wali Murid ini
        $anak_list = \App\Models\Siswa::where('user_id', $user_id)->get();

        // 2. Tagihan Belum Dibayar & Salah Nominal
        $tagihan_belum_bayar = Tagihan::with(['siswa', 'kategori'])
            ->whereHas('siswa', function($q) use ($user_id) {
                $q->where('user_id', $user_id);
            })
            ->whereIn('status', ['belum_bayar', 'salah_nominal'])
            ->get();

        // 3. Tagihan Dalam Proses Verifikasi
        $tagihan_verifikasi = Tagihan::with(['siswa', 'kategori'])
            ->whereHas('siswa', function($q) use ($user_id) {
                $q->where('user_id', $user_id);
            })
            ->where('status', 'proses_verifikasi')
            ->get();

        // 4. Tagihan Lunas
        $tagihan_lunas = Tagihan::with(['siswa', 'kategori'])
            ->whereHas('siswa', function($q) use ($user_id) {
                $q->where('user_id', $user_id);
            })
            ->where('status', 'lunas')
            ->get();

        $stats = [
            'total_belum_bayar_count' => $tagihan_belum_bayar->count(),
            'total_belum_bayar_nominal' => $tagihan_belum_bayar->sum('nominal'),
            'total_verifikasi_count' => $tagihan_verifikasi->count(),
            'total_lunas_count' => $tagihan_lunas->count(),
            'total_lunas_nominal' => $tagihan_lunas->sum('nominal'),
        ];

        $recent_tagihan = Tagihan::with(['siswa', 'kategori'])
            ->whereHas('siswa', function($q) use ($user_id) {
                $q->where('user_id', $user_id);
            })
            ->latest()
            ->take(5)
            ->get();

        return view('orang_tua.dashboard', compact('anak_list', 'stats', 'recent_tagihan'));
    }

    public function index()
    {
        return $this->dashboard();
    }

    // Halaman Khusus Menu "Tagihan Saya" (Tujuan Transfer, Upload Bukti Bayar, Tagihan Berjalan & Riwayat)
    public function tagihanSaya()
    {
        $user_id = Auth::id();

        // 1. Tagihan yang Belum Lunas (Perlu dibayar, salah nominal, atau sedang diverifikasi)
        $tagihan_aktif = Tagihan::with(['siswa', 'kategori'])
            ->whereHas('siswa', function($q) use ($user_id) {
                $q->where('user_id', $user_id);
            })
            ->whereIn('status', ['belum_bayar', 'proses_verifikasi', 'salah_nominal'])
            ->get();

        // 2. Riwayat Pembayaran (Hanya yang sudah Lunas)
        $riwayat = Tagihan::with(['siswa', 'kategori', 'transaksi'])
            ->whereHas('siswa', function($q) use ($user_id) {
                $q->where('user_id', $user_id);
            })
            ->where('status', 'lunas')
            ->get();

        return view('orang_tua.tagihan', compact('tagihan_aktif', 'riwayat'));
    }

    public function prosesBayar(Request $request)
    {
        $request->validate([
            'tagihan_id' => 'required|array|min:1',
            'tagihan_id.*' => 'exists:tagihans,id',
            'nominal_bayar' => 'required|numeric',
            'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $path = $request->file('bukti_bayar')->store('bukti_bayar', 'public');

        $tagihans = Tagihan::whereIn('id', $request->tagihan_id)->get();

        foreach ($tagihans as $tagihan) {
            Transaksi::create([
                'tagihan_id' => $tagihan->id,
                'bukti_bayar' => $path,
                'metode' => 'online',
                'nominal_bayar' => $tagihan->nominal,
                'tanggal_bayar' => now(),
            ]);

            $tagihan->update(['status' => 'proses_verifikasi']);
        }

        return redirect()->route('orangtua.tagihan')->with('success', 'Bukti pembayaran untuk tagihan terpilih berhasil dikirim dan sedang menunggu verifikasi Admin!');
    }

    // Fungsi Cetak Struk khusus Orang Tua
    public function cetakBukti($id)
    {
        $user_id = Auth::id();
        
        $tagihan = Tagihan::with(['siswa', 'kategori'])
            ->whereHas('siswa', function($q) use ($user_id) {
                $q->where('user_id', $user_id);
            })
            ->findOrFail($id);
            
        $transaksi = Transaksi::where('tagihan_id', $id)->first();

        return view('admin.cetak_struk', compact('tagihan', 'transaksi'));
    }

    // Halaman Pembuatan Tagihan Mandiri oleh Orang Tua
    public function tagihanMandiri()
    {
        $user_id = Auth::id();
        $anak = \App\Models\Siswa::where('user_id', $user_id)->get();
        $kategori_list = \App\Models\KategoriTagihan::all();

        return view('orang_tua.tagihan_mandiri', compact('anak', 'kategori_list'));
    }

    // Fungsi membuat tagihan mandiri oleh Orang Tua (Bayar Awal)
    public function buatTagihanMandiri(Request $request)
    {
        $request->validate([
            'tagihan' => 'required|array|min:1',
            'tagihan.*.siswa_id' => 'required|exists:siswas,id',
            'tagihan.*.nama_kategori' => 'required|string|max:100',
            'tagihan.*.nominal' => 'required|numeric|min:1000'
        ]);

        $user_id = Auth::id();

        foreach ($request->tagihan as $item) {
            $siswa = \App\Models\Siswa::where('id', $item['siswa_id'])
                ->where('user_id', $user_id)
                ->firstOrFail();

            $kategori = \App\Models\KategoriTagihan::firstOrCreate([
                'nama_kategori' => trim($item['nama_kategori'])
            ]);

            Tagihan::create([
                'siswa_id' => $siswa->id,
                'kategori_id' => $kategori->id,
                'nominal' => $item['nominal'],
                'status' => 'belum_bayar'
            ]);
        }

        return redirect()->route('orangtua.tagihan')->with('success', 'Tagihan mandiri berhasil dibuat! Silakan pilih tagihan tersebut di bawah untuk melakukan pembayaran.');
    }
}
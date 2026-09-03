<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\KategoriTagihan;

class KepalaSekolahController extends Controller
{
    // Menampilkan halaman utama Dashboard Kepala Sekolah
    public function dashboard()
    {
        $transaksis = Transaksi::with(['tagihan.siswa', 'tagihan.kategori'])
            ->whereHas('tagihan', function($query) {
                $query->where('status', 'lunas');
            })
            ->latest('tanggal_bayar')
            ->get();

        $totalTransaksi = $transaksis->count();
        $totalNominal = $transaksis->sum('nominal_bayar');
        $menungguValidasi = $transaksis->where('is_valid_kepala_sekolah', false)->count();
        $sudahValidasi = $transaksis->where('is_valid_kepala_sekolah', true)->count();
        $recentTransaksis = $transaksis->take(5);

        return view('kepala_sekolah.dashboard', compact(
            'totalTransaksi', 
            'totalNominal', 
            'menungguValidasi', 
            'sudahValidasi',
            'recentTransaksis'
        ));
    }

    public function index()
    {
        return $this->dashboard();
    }

    // Menampilkan halaman Laporan Transaksi dengan Filter
    public function laporan(Request $request)
    {
        $query = Transaksi::with(['tagihan.siswa', 'tagihan.kategori'])
            ->whereHas('tagihan', function($q) {
                $q->where('status', 'lunas');
            });

        // Filter berdasarkan Bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_bayar', $request->bulan);
        }

        // Filter berdasarkan Tahun
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_bayar', $request->tahun);
        }

        // Filter berdasarkan Jenis Laporan / Kategori Tagihan
        if ($request->filled('kategori_id')) {
            $query->whereHas('tagihan', function($q) use ($request) {
                $q->where('kategori_id', $request->kategori_id);
            });
        }

        // Filter berdasarkan Status Validasi
        if ($request->filled('status_validasi')) {
            if ($request->status_validasi == 'valid') {
                $query->where('is_valid_kepala_sekolah', true);
            } elseif ($request->status_validasi == 'menunggu') {
                $query->where('is_valid_kepala_sekolah', false);
            }
        }

        $transaksis = $query->latest('tanggal_bayar')->get();
        
        // Data untuk pilihan dropdown filter
        $kategoriList = KategoriTagihan::all();
        
        // Mengambil daftar tahun unik dari data transaksi (DB Agnostic)
        $tahunList = Transaksi::whereNotNull('tanggal_bayar')
            ->get()
            ->map(function($t) {
                return (int)\Carbon\Carbon::parse($t->tanggal_bayar)->year;
            })
            ->unique()
            ->sortDesc()
            ->values()
            ->toArray();
            
        if (empty($tahunList)) {
            $tahunList = [(int)date('Y')];
        }

        return view('kepala_sekolah.laporan', compact(
            'transaksis', 
            'kategoriList', 
            'tahunList'
        ));
    }

    // Cetak / Download PDF Laporan Transaksi
    public function laporanPdf(Request $request)
    {
        $query = Transaksi::with(['tagihan.siswa', 'tagihan.kategori'])
            ->whereHas('tagihan', function($q) {
                $q->where('status', 'lunas');
            });

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_bayar', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_bayar', $request->tahun);
        }

        if ($request->filled('kategori_id')) {
            $query->whereHas('tagihan', function($q) use ($request) {
                $q->where('kategori_id', $request->kategori_id);
            });
        }

        if ($request->filled('status_validasi')) {
            if ($request->status_validasi == 'valid') {
                $query->where('is_valid_kepala_sekolah', true);
            } elseif ($request->status_validasi == 'menunggu') {
                $query->where('is_valid_kepala_sekolah', false);
            }
        }

        $transaksis = $query->latest('tanggal_bayar')->get();

        $namaBulan = [
            '01'=>'Januari', '02'=>'Februari', '03'=>'Maret', '04'=>'April',
            '05'=>'Mei', '06'=>'Juni', '07'=>'Juli', '08'=>'Agustus',
            '09'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember'
        ];

        $periode = 'Semua Waktu';
        if ($request->filled('bulan') && $request->filled('tahun')) {
            $periode = ($namaBulan[$request->bulan] ?? $request->bulan) . ' ' . $request->tahun;
        } elseif ($request->filled('bulan')) {
            $periode = 'Bulan ' . ($namaBulan[$request->bulan] ?? $request->bulan);
        } elseif ($request->filled('tahun')) {
            $periode = 'Tahun ' . $request->tahun;
        }

        $totalNominal = $transaksis->sum('nominal_bayar');
        $totalTransaksi = $transaksis->count();

        return view('kepala_sekolah.laporan_pdf', compact('transaksis', 'periode', 'totalNominal', 'totalTransaksi'));
    }

    // Memproses tombol validasi
    public function validasi($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        
        // Mengubah status menjadi valid (Arsip Digital)
        $transaksi->update(['is_valid_kepala_sekolah' => true]);

        return redirect()->back()->with('success', 'Laporan transaksi berhasil divalidasi dan tersimpan di arsip digital.');
    }
}
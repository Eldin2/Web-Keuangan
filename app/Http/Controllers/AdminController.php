<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\KategoriTagihan;
use App\Models\Tagihan;
use App\Models\Keuangan;
use App\Models\Transaksi;
use App\Models\User; // Memanggil model transaksi

class AdminController extends Controller
{
    // --- FITUR KELOLA SISWA ---
    public function index()
    {
        // Hitung Statistik
        $stats = [
            'total_siswa' => Siswa::count(),
            'total_masuk' => Transaksi::whereHas('tagihan', function($q){ $q->where('status', 'lunas'); })->sum('nominal_bayar') 
                            + Keuangan::where('tipe', 'masuk')->sum('nominal'),
            'total_keluar' => Keuangan::where('tipe', 'keluar')->sum('nominal'),
            'pending' => Tagihan::where('status', 'proses_verifikasi')->count(),
            'belum_bayar' => Tagihan::where('status', 'belum_bayar')->count(),
        ];

        $siswas = Siswa::all();
        
        $pending_payments = Tagihan::with(['siswa', 'kategori', 'transaksi'])
                                   ->where('status', 'proses_verifikasi')
                                   ->latest()
                                   ->take(4)
                                   ->get();

        $recent_transactions = Transaksi::with(['tagihan.siswa', 'tagihan.kategori'])
                                       ->latest()
                                       ->take(4)
                                       ->get();

        return view('admin.dashboard', compact('siswas', 'stats', 'pending_payments', 'recent_transactions'));
    }

    // --- FITUR BARU: HALAMAN KHUSUS KELOLA SISWA ---
    public function kelolaSiswa(Request $request)
{
    $query = Siswa::query();

    // Fitur pencarian berdasarkan nama siswa atau NIS
    if ($request->has('search') && $request->search != '') {
        $query->where('nama_siswa', 'like', '%' . $request->search . '%')
              ->orWhere('nis', 'like', '%' . $request->search . '%');
    }

    $siswas = $query->with('user')->latest()->get();
    
    // Ambil semua akun yang jabatannya sebagai 'orang_tua'
    $orangtuas = User::where('role', 'orang_tua')->get(); 

    return view('admin.siswa', compact('siswas', 'orangtuas'));
}

    // --- FITUR BARU: DAFTAR AKUN SISWA DAN ORANG TUA ---
    public function akunSiswa(Request $request)
    {
        $query = Siswa::with('user');

        if ($request->has('search') && $request->search != '') {
            $query->where('nama_siswa', 'like', '%' . $request->search . '%')
                  ->orWhere('nis', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
        }

        $siswas = $query->latest()->get();

        return view('admin.akun_siswa', compact('siswas'));
    }

    // Menampilkan halaman Edit Akun Siswa & Wali
    public function editAkunSiswa($id)
    {
        $siswa = Siswa::with('user')->findOrFail($id);
        $orangtuas = User::where('role', 'orang_tua')->get();
        return view('admin.akun_siswa_edit', compact('siswa', 'orangtuas'));
    }

    // Menyimpan perubahan Akun Siswa & Wali
    public function updateAkunSiswa(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $rules = [
            'nis' => 'required|unique:siswas,nis,' . $id,
            'nama_siswa' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'parent_action' => 'required|in:keep,edit,link_existing,create_new,unlink',
        ];

        if ($request->parent_action == 'edit') {
            $rules['parent_id'] = 'required|exists:users,id';
            $rules['parent_name'] = 'required|string|max:255';
            $rules['parent_email'] = 'required|email|unique:users,email,' . $request->parent_id;
            $rules['parent_password'] = 'nullable|min:8';
        } elseif ($request->parent_action == 'link_existing') {
            $rules['existing_user_id'] = 'required|exists:users,id';
        } elseif ($request->parent_action == 'create_new') {
            $rules['new_parent_name'] = 'required|string|max:255';
            $rules['new_parent_email'] = 'required|email|unique:users,email';
            $rules['new_parent_password'] = 'required|min:8';
        }

        $request->validate($rules);

        // 1. Update data Siswa
        $siswa->nis = $request->nis;
        $siswa->nama_siswa = $request->nama_siswa;
        $siswa->kelas = $request->kelas;

        // 2. Handle Akun Orang Tua
        if ($request->parent_action == 'unlink') {
            $siswa->user_id = null;
        } elseif ($request->parent_action == 'link_existing') {
            $siswa->user_id = $request->existing_user_id;
        } elseif ($request->parent_action == 'create_new') {
            $newParent = User::create([
                'name' => $request->new_parent_name,
                'email' => $request->new_parent_email,
                'password' => \Illuminate\Support\Facades\Hash::make($request->new_parent_password),
                'role' => 'orang_tua',
            ]);
            $siswa->user_id = $newParent->id;
        } elseif ($request->parent_action == 'edit') {
            $parent = User::findOrFail($request->parent_id);
            $parent->name = $request->parent_name;
            $parent->email = $request->parent_email;
            if ($request->filled('parent_password')) {
                $parent->password = \Illuminate\Support\Facades\Hash::make($request->parent_password);
            }
            $parent->save();
            $siswa->user_id = $parent->id;
        }

        $siswa->save();

        return redirect()->route('admin.akun_siswa')->with('success', 'Akun siswa dan data orang tua berhasil diperbarui!');
    }

    // Menghapus data Siswa
    public function destroySiswa($id)
    {
        $siswa = Siswa::findOrFail($id);
        $nama = $siswa->nama_siswa;
        $siswa->delete();

        return redirect()->back()->with('success', 'Data siswa ' . $nama . ' berhasil dihapus!');
    }


// --- FITUR BUKU KAS (DENGAN FILTER) ---
    public function bukuKas(Request $request)
    {
        $query = Keuangan::query();

        // Jika Admin memilih bulan tertentu
        if ($request->has('bulan') && $request->bulan != '') {
            $query->whereMonth('tanggal', $request->bulan);
        }
        // Jika Admin memilih tahun tertentu
        if ($request->has('tahun') && $request->tahun != '') {
            $query->whereYear('tanggal', $request->tahun);
        }

        $catatans = $query->orderBy('tanggal', 'desc')->get();
        
        return view('admin.keuangan', compact('catatans'));
    }

public function simpanKas(Request $request)
{
    $request->validate([
        'tipe' => 'required',
        'kategori' => 'required|string',
        'nominal' => 'required|numeric',
        'tanggal' => 'required|date',
    ]);

    Keuangan::create($request->all());
    return redirect()->back()->with('success', 'Catatan keuangan berhasil disimpan');
}

public function bukuKasPdf(Request $request)
{
    $request->validate([
        'bulan_mulai' => 'required|numeric|min:1|max:12',
        'bulan_selesai' => 'required|numeric|min:1|max:12|gte:bulan_mulai',
        'tahun' => 'required|numeric',
    ]);

    $bulan_mulai = $request->bulan_mulai;
    $bulan_selesai = $request->bulan_selesai;
    $tahun = $request->tahun;

    $catatans = Keuangan::whereYear('tanggal', $tahun)
        ->whereMonth('tanggal', '>=', $bulan_mulai)
        ->whereMonth('tanggal', '<=', $bulan_selesai)
        ->orderBy('tanggal', 'asc')
        ->get();

    $namaBulan = [
        1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 
        5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus', 
        9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'
    ];

    $periode = $namaBulan[(int)$bulan_mulai] . ' - ' . $namaBulan[(int)$bulan_selesai] . ' ' . $tahun;

    $total_masuk = $catatans->where('tipe', 'masuk')->sum('nominal');
    $total_keluar = $catatans->where('tipe', 'keluar')->sum('nominal');
    $saldo_akhir = $total_masuk - $total_keluar;

    return view('admin.keuangan_pdf', compact('catatans', 'periode', 'total_masuk', 'total_keluar', 'saldo_akhir'));
}

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:siswas,nis',
            'nama_siswa' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'user_id' => 'nullable'
        ]);

        Siswa::create([
            'user_id' => $request->user_id ?: null,
            'nis' => $request->nis,
            'nama_siswa' => $request->nama_siswa,
            'kelas' => $request->kelas,
        ]);

        return redirect()->route('admin.siswa')->with('success', 'Data siswa baru (' . $request->nama_siswa . ') berhasil ditambahkan!');
    }

    // Menampilkan halaman Edit Siswa
    public function editSiswa($id)
    {
        $siswa = Siswa::findOrFail($id);
        $orangtuas = User::where('role', 'orang_tua')->get(); // Panggil data orang tua untuk pilihan
        
        return view('admin.siswa_edit', compact('siswa', 'orangtuas'));
    }

    // Menyimpan perubahan data Siswa
    public function updateSiswa(Request $request, $id)
    {
        // Validasi, perhatikan pengecekan unique NIS mengecualikan NIS siswa yang sedang diedit
        $request->validate([
            'nis' => 'required|unique:siswas,nis,'.$id, 
            'nama_siswa' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'user_id' => 'nullable'
        ]);

        $siswa = Siswa::findOrFail($id);
        $siswa->update([
            'user_id' => $request->user_id ?: null,
            'nis' => $request->nis,
            'nama_siswa' => $request->nama_siswa,
            'kelas' => $request->kelas,
        ]);

        return redirect()->route('admin.siswa');
    }

    // --- FITUR KELOLA TAGIHAN (DENGAN FILTER) ---
    public function kelolaTagihan(Request $request)
    {
        $siswas = Siswa::all();
        
        // Membangun query dasar
        $query = Tagihan::with(['siswa', 'kategori']);

        // Jika Admin memilih nama siswa tertentu
        if ($request->has('siswa_id') && $request->siswa_id != '') {
            $query->where('siswa_id', $request->siswa_id);
        }
        // Jika Admin memilih bulan tertentu
        if ($request->has('bulan') && $request->bulan != '') {
            $query->whereMonth('created_at', $request->bulan);
        }
        // Jika Admin memilih tahun tertentu
        if ($request->has('tahun') && $request->tahun != '') {
            $query->whereYear('created_at', $request->tahun);
        }

        $tagihans = $query->latest()->get(); // Ambil data sesuai filter

        return view('admin.tagihan', compact('siswas', 'tagihans'));
    }

    public function simpanTagihan(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required',
            'nama_kategori' => 'required|string',
            'nominal' => 'required|numeric'
        ]);

        $kategori = KategoriTagihan::firstOrCreate(['nama_kategori' => $request->nama_kategori]);

        if ($request->siswa_id === 'semua') {
            $siswas = \App\Models\Siswa::all();
            foreach ($siswas as $siswa) {
                Tagihan::create([
                    'siswa_id' => $siswa->id,
                    'kategori_id' => $kategori->id,
                    'nominal' => $request->nominal,
                    'status' => 'belum_bayar'
                ]);
            }
        } else {
            Tagihan::create([
                'siswa_id' => $request->siswa_id,
                'kategori_id' => $kategori->id,
                'nominal' => $request->nominal,
                'status' => 'belum_bayar'
            ]);
        }

        return redirect()->route('admin.tagihan')->with('success', 'Tagihan berhasil dibuat!');
    }

    // Menghapus data Tagihan
    public function destroyTagihan($id)
    {
        $tagihan = Tagihan::findOrFail($id);

        if ($tagihan->transaksi) {
            $tagihan->transaksi->delete();
        }

        $tagihan->delete();

        return redirect()->route('admin.tagihan')->with('success', 'Data tagihan berhasil dihapus!');
    }

    // --- FITUR VERIFIKASI PEMBAYARAN ---
    public function verifikasi(Request $request)
    {
        $query = Tagihan::with(['siswa', 'kategori', 'transaksi'])
            ->whereIn('status', ['proses_verifikasi', 'lunas', 'salah_nominal']);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $tagihans = $query->latest()->get();

        return view('admin.verifikasi', compact('tagihans'));
    }

    public function konfirmasi(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        
        // Ubah status tagihan menjadi Lunas
        $transaksi->tagihan->update(['status' => 'lunas']);

        return redirect()->route('admin.verifikasi')->with('success', 'Pembayaran berhasil dikonfirmasi lunas!');
    }
    // --- FITUR PEMBAYARAN CASH (OFFLINE) ---
    public function bayarCash($id)
    {
        $tagihan = Tagihan::findOrFail($id);

        // Langsung catat transaksi sebagai metode cash
        Transaksi::create([
            'tagihan_id' => $tagihan->id,
            'bukti_bayar' => 'Pembayaran Tunai di Sekolah', // Tanpa file foto
            'metode' => 'cash',
            'nominal_bayar' => $tagihan->nominal,
            'tanggal_bayar' => now(),
        ]);

        // Karena Admin yang menerima uang langsung, status otomatis Lunas
        $tagihan->update(['status' => 'lunas']);

        return redirect()->route('admin.tagihan');
    }
    // --- FITUR CETAK STRUK ---
    // Fungsi untuk memuat halaman Cetak Struk
    public function cetakStruk($id)
    {
        $tagihan = Tagihan::with(['siswa', 'kategori'])->findOrFail($id);
        
        // Ambil data transaksi jika ada
        $transaksi = \App\Models\Transaksi::where('tagihan_id', $id)->first();
        
        return view('admin.cetak_struk', compact('tagihan', 'transaksi'));
    }
    public function setujuVerifikasi($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        
        // Ubah status tagihan menjadi lunas
        $tagihan->update([
            'status' => 'lunas'
        ]);

        return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi lunas!');
    }

    public function tolakVerifikasi($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        
        // Ubah status tagihan menjadi salah_nominal
        $tagihan->update([
            'status' => 'salah_nominal'
        ]);

        return redirect()->back()->with('success', 'Pembayaran ditolak. Status tagihan diubah menjadi Salah Nominal!');
    }
    // Fungsi khusus untuk Kasir / Pembayaran Tunai (Offline)
    public function bayarOffline($id)
    {
        // Cari data tagihan berdasarkan ID
        $tagihan = \App\Models\Tagihan::findOrFail($id);

        // Otomatis buatkan data transaksi tanpa butuh foto struk
        \App\Models\Transaksi::create([
            'tagihan_id' => $tagihan->id,
            'bukti_bayar' => 'Bayar Tunai di Loket', // Keterangan pengganti foto
            'metode' => 'offline',
            'nominal_bayar' => $tagihan->nominal,
            'tanggal_bayar' => now(),
        ]);

        // Langsung ubah status tagihan menjadi lunas
        $tagihan->update(['status' => 'lunas']);

        return redirect()->back()->with('success', 'Pembayaran tunai berhasil diterima dan dicatat!');
    }
    
    // --- FITUR REKAPITULASI ---
    public function rekapitulasi(Request $request)
    {
        $query = \App\Models\Transaksi::with(['tagihan.siswa', 'tagihan.kategori']);
        
        // Filter by bulan
        if ($request->has('bulan') && $request->bulan != '') {
            $query->whereMonth('tanggal_bayar', $request->bulan);
        }
        // Filter by tahun
        if ($request->has('tahun') && $request->tahun != '') {
            $query->whereYear('tanggal_bayar', $request->tahun);
        }

        $transaksis = $query->latest('tanggal_bayar')->get();
        
        // Membedakan metode online dan cash (offline)
        $online = $transaksis->where('metode', 'online');
        $cash = $transaksis->whereIn('metode', ['cash', 'offline']);
        
        return view('admin.rekapitulasi', compact('online', 'cash'));
    }

    public function rekapitulasiPdf(Request $request)
    {
        $query = \App\Models\Transaksi::with(['tagihan.siswa', 'tagihan.kategori']);
        
        // Filter by bulan
        if ($request->has('bulan') && $request->bulan != '') {
            $query->whereMonth('tanggal_bayar', $request->bulan);
        }
        // Filter by tahun
        if ($request->has('tahun') && $request->tahun != '') {
            $query->whereYear('tanggal_bayar', $request->tahun);
        }

        $transaksis = $query->latest('tanggal_bayar')->get();
        
        // Membedakan metode online dan cash (offline)
        $online = $transaksis->where('metode', 'online');
        $cash = $transaksis->whereIn('metode', ['cash', 'offline']);
        
        // Tentukan teks periode
        $namaBulan = ['01'=>'Januari', '02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni', '07'=>'Juli', '08'=>'Agustus', '09'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember'];
        $periode = 'Semua Waktu';
        if ($request->bulan && $request->tahun) {
            $periode = $namaBulan[$request->bulan] . ' ' . $request->tahun;
        } elseif ($request->bulan) {
            $periode = 'Bulan ' . $namaBulan[$request->bulan];
        } elseif ($request->tahun) {
            $periode = 'Tahun ' . $request->tahun;
        }
        
        return view('admin.rekapitulasi_pdf', compact('online', 'cash', 'periode'));
    }

    // --- FITUR PENGATURAN REKENING SEKOLAH ---
    public function editRekening()
    {
        $bank_name = \App\Models\Setting::get('norek_bank_name', 'BRI');
        $norek_number = \App\Models\Setting::get('norek_number', '111 111 1111');
        $norek_owner = \App\Models\Setting::get('norek_owner', 'TK IT INSAN CENDIKIA');

        return view('admin.rekening', compact('bank_name', 'norek_number', 'norek_owner'));
    }

    public function updateRekening(Request $request)
    {
        $request->validate([
            'norek_bank_name' => 'required|string|max:50',
            'norek_number' => 'required|string|max:50',
            'norek_owner' => 'required|string|max:100',
        ]);

        \App\Models\Setting::set('norek_bank_name', $request->norek_bank_name);
        \App\Models\Setting::set('norek_number', $request->norek_number);
        \App\Models\Setting::set('norek_owner', $request->norek_owner);

        return redirect()->back()->with('success', 'Nomor rekening transfer berhasil diperbarui untuk semua akun orang tua!');
    }
}
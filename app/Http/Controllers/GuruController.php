<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\GajiGuru;
use App\Models\Keuangan;
use Carbon\Carbon;

class GuruController extends Controller
{
    // List all teachers
    public function index()
    {
        $gurus = Guru::latest()->get();
        
        // Calculate statistics
        $totalGuru = Guru::count();
        $totalGajiTerbayar = GajiGuru::where('status_pembayaran', 'dibayar')->sum('total_gaji');
        $gajiBulanIni = GajiGuru::where('status_pembayaran', 'dibayar')
            ->whereMonth('tanggal_dibayar', Carbon::now()->month)
            ->whereYear('tanggal_dibayar', Carbon::now()->year)
            ->sum('total_gaji');

        return view('admin.guru.index', compact('gurus', 'totalGuru', 'totalGajiTerbayar', 'gajiBulanIni'));
    }

    // Save a new teacher profile
    public function store(Request $request)
    {
        $request->validate([
            'nama_guru' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50|unique:gurus,nip',
            'status' => 'required|string|max:100',
            'jabatan' => 'required|string|max:255',
            'gaji_bulanan' => 'required|numeric|min:0',
        ]);

        Guru::create($request->all());

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil ditambahkan!');
    }

    // Edit teacher profile view
    public function edit($id)
    {
        $guru = Guru::findOrFail($id);
        return view('admin.guru.edit', compact('guru'));
    }

    // Update teacher profile
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_guru' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50|unique:gurus,nip,' . $id,
            'status' => 'required|string|max:100',
            'jabatan' => 'required|string|max:255',
            'gaji_bulanan' => 'required|numeric|min:0',
        ]);

        $guru = Guru::findOrFail($id);
        $guru->update($request->all());

        return redirect()->route('admin.guru.index')->with('success', 'Data guru dan nominal gaji berhasil diperbarui!');
    }

    // Delete teacher profile
    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);
        $guru->delete();

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil dihapus!');
    }

    // List all generated monthly salary slips
    public function gajiIndex(Request $request)
    {
        $query = GajiGuru::with('guru');

        if ($request->has('bulan') && $request->bulan != '') {
            $query->where('bulan', $request->bulan);
        }
        if ($request->has('tahun') && $request->tahun != '') {
            $query->where('tahun', $request->tahun);
        }
        if ($request->has('guru_id') && $request->guru_id != '') {
            $query->where('guru_id', $request->guru_id);
        }

        $slips = $query->latest()->get();
        $gurus = Guru::orderBy('nama_guru')->get();

        return view('admin.gaji.index', compact('slips', 'gurus'));
    }

    // Step 1: Choose teacher, month, year for salary generation
    public function gajiCreate(Request $request)
    {
        $gurus = Guru::orderBy('nama_guru')->get();
        $selectedGuru = null;

        if ($request->has('guru_id') && $request->guru_id != '') {
            $selectedGuru = Guru::findOrFail($request->guru_id);
        }

        return view('admin.gaji.create', compact('gurus', 'selectedGuru'));
    }

    // Save generated salary slip
    public function gajiStore(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:gurus,id',
            'bulan' => 'required|numeric|min:1|max:12',
            'tahun' => 'required|numeric',
            'nominal_gaji' => 'required|numeric|min:0',
            'potongan' => 'required|numeric|min:0',
            'tanggal_dibayar' => 'required|date',
            'keterangan' => 'nullable|string',
            'status_pembayaran' => 'required|in:dibayar,pending',
        ]);

        $guru = Guru::findOrFail($request->guru_id);

        // Check if salary is already generated for this teacher, month, and year
        $existing = GajiGuru::where('guru_id', $request->guru_id)
            ->where('bulan', $request->bulan)
            ->where('tahun', $request->tahun)
            ->first();

        if ($existing) {
            return redirect()->back()->withInput()->withErrors(['gaji_exists' => 'Slip gaji untuk guru ini pada periode tersebut sudah pernah dibuat!']);
        }

        // Calculations
        $nominal_gaji = $request->nominal_gaji;
        $potongan = $request->potongan;
        $total_gaji = $nominal_gaji - $potongan;

        $gaji = GajiGuru::create([
            'guru_id' => $request->guru_id,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'nominal_gaji' => $nominal_gaji,
            'potongan' => $potongan,
            'total_gaji' => $total_gaji,
            'keterangan' => $request->keterangan,
            'tanggal_dibayar' => $request->tanggal_dibayar,
            'status_pembayaran' => $request->status_pembayaran,
        ]);

        // If status is paid ('dibayar'), log into Keuangan (Buku Kas Umum) as Expense
        if ($request->status_pembayaran === 'dibayar') {
            $bulanNama = $this->getNamaBulan($request->bulan);
            Keuangan::create([
                'tipe' => 'keluar',
                'kategori' => 'Gaji Guru',
                'nominal' => $total_gaji,
                'tanggal' => $request->tanggal_dibayar,
                'keterangan' => "[Gaji Guru] ID Slip: {$gaji->id} - {$guru->nama_guru} ({$bulanNama} {$request->tahun})",
            ]);
        }

        return redirect()->route('admin.gaji.index')->with('success', 'Slip gaji berhasil diterbitkan dan dicatat!');
    }

    // View detailed salary slip
    public function gajiShow($id)
    {
        $slip = GajiGuru::with('guru')->findOrFail($id);
        $bulanNama = $this->getNamaBulan($slip->bulan);
        return view('admin.gaji.show', compact('slip', 'bulanNama'));
    }

    // Print/Download PDF salary slip
    public function gajiPdf($id)
    {
        $slip = GajiGuru::with('guru')->findOrFail($id);
        $bulanNama = $this->getNamaBulan($slip->bulan);
        return view('admin.gaji.pdf', compact('slip', 'bulanNama'));
    }

    // Delete salary slip and its corresponding expense in general ledger (if exists)
    public function gajiDestroy($id)
    {
        $slip = GajiGuru::findOrFail($id);
        
        // Find and delete related expense entry in Keuangan
        Keuangan::where('tipe', 'keluar')
            ->where('kategori', 'Gaji Guru')
            ->where('keterangan', 'like', "[Gaji Guru] ID Slip: {$id} - %")
            ->delete();

        $slip->delete();

        return redirect()->route('admin.gaji.index')->with('success', 'Slip gaji dan data transaksi kas terkait berhasil dihapus!');
    }

    // Helper for month names
    private function getNamaBulan($bulan)
    {
        $bulanList = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        return $bulanList[(int)$bulan] ?? '';
    }

    // Helper for spelling numbers in Indonesian (e.g., for PDF receipts/slips)
    public static function terbilang($angka)
    {
        $angka = abs($angka);
        $baca = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $terbilang = "";
        
        if ($angka < 12) {
            $terbilang = " " . $baca[$angka];
        } else if ($angka < 20) {
            $terbilang = self::terbilang($angka - 10) . " belas";
        } else if ($angka < 100) {
            $terbilang = self::terbilang($angka / 10) . " puluh" . self::terbilang($angka % 10);
        } else if ($angka < 200) {
            $terbilang = " seratus" . self::terbilang($angka - 100);
        } else if ($angka < 1000) {
            $terbilang = self::terbilang($angka / 100) . " ratus" . self::terbilang($angka % 100);
        } else if ($angka < 2000) {
            $terbilang = " seribu" . self::terbilang($angka - 1000);
        } else if ($angka < 1000000) {
            $terbilang = self::terbilang($angka / 1000) . " ribu" . self::terbilang($angka % 1000);
        } else if ($angka < 1000000000) {
            $terbilang = self::terbilang($angka / 1000000) . " juta" . self::terbilang($angka % 1000000);
        } else if ($angka < 1000000000000) {
            $terbilang = self::terbilang($angka / 1000000000) . " milyar" . self::terbilang(fmod($angka, 1000000000));
        } else if ($angka < 1000000000000000) {
            $terbilang = self::terbilang($angka / 1000000000000) . " trilyun" . self::terbilang(fmod($angka, 1000000000000));
        }
        
        return trim($terbilang);
    }
}

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrangTuaController;
use App\Http\Controllers\KepalaSekolahController;
use App\Http\Controllers\GuruController;

Route::get('/', function () {
    return view('welcome'); // Halaman awal bawaan Laravel
});

// PENGATUR DASHBOARD BAWAAN (Otomatis mengarahkan user sesuai jabatannya setelah login)
Route::get('/dashboard', function () {
    if (auth()->user()->role == 'admin') return redirect()->route('admin.dashboard');
    if (auth()->user()->role == 'orang_tua') return redirect()->route('orangtua.dashboard');
    if (auth()->user()->role == 'kepala_sekolah') return redirect()->route('kepsek.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php'; // Rute bawaan Login/Register dari Breeze

// ===============================================================
// 1. AREA KHUSUS ADMIN SEKOLAH (Digembok dengan role:admin)
// ===============================================================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    // Rute Baru Khusus Data Siswa
    Route::get('/admin/siswa', [AdminController::class, 'kelolaSiswa'])->name('admin.siswa');
    Route::post('/admin/siswa/simpan', [AdminController::class, 'store'])->name('admin.siswa.store');
    Route::get('/admin/siswa/{id}/edit', [AdminController::class, 'editSiswa'])->name('admin.siswa.edit');
    Route::put('/admin/siswa/{id}', [AdminController::class, 'updateSiswa'])->name('admin.siswa.update');
    Route::delete('/admin/siswa/{id}', [AdminController::class, 'destroySiswa'])->name('admin.siswa.destroy');
    Route::post('/admin/tagihan/{id}/bayar-offline', [AdminController::class, 'bayarOffline'])->name('admin.tagihan.bayar_offline');
    Route::get('/admin/tagihan', [AdminController::class, 'kelolaTagihan'])->name('admin.tagihan');
    Route::post('/admin/tagihan/simpan', [AdminController::class, 'simpanTagihan'])->name('admin.tagihan.store');
    Route::delete('/admin/tagihan/{id}', [AdminController::class, 'destroyTagihan'])->name('admin.tagihan.destroy');
    Route::post('/admin/tagihan/{id}/bayar-cash', [AdminController::class, 'bayarCash'])->name('admin.tagihan.cash');
    Route::get('/admin/tagihan/{id}/cetak', [AdminController::class, 'cetakStruk'])->name('admin.tagihan.cetak');
    Route::get('/admin/verifikasi', [AdminController::class, 'verifikasi'])->name('admin.verifikasi');
    Route::post('/admin/verifikasi/{id}/konfirmasi', [AdminController::class, 'konfirmasi'])->name('admin.konfirmasi');
    Route::get('/admin/keuangan', [AdminController::class, 'bukuKas'])->name('admin.kas');
    Route::post('/admin/keuangan/simpan', [AdminController::class, 'simpanKas'])->name('admin.kas.simpan');
    Route::get('/admin/keuangan/pdf', [AdminController::class, 'bukuKasPdf'])->name('admin.kas.pdf');
    // Rute untuk Cetak Struk Admin
    Route::get('/admin/cetak/{id}', [AdminController::class, 'cetakStruk'])->name('admin.cetak');
    Route::post('/admin/verifikasi/{id}/setuju', [AdminController::class, 'setujuVerifikasi'])->name('admin.verifikasi.setuju');
    Route::post('/admin/verifikasi/{id}/tolak', [AdminController::class, 'tolakVerifikasi'])->name('admin.verifikasi.tolak');
    Route::get('/admin/rekapitulasi', [AdminController::class, 'rekapitulasi'])->name('admin.rekapitulasi');
    Route::get('/admin/rekapitulasi/pdf', [AdminController::class, 'rekapitulasiPdf'])->name('admin.rekapitulasi.pdf');
    Route::get('/admin/akun-siswa', [AdminController::class, 'akunSiswa'])->name('admin.akun_siswa');
    Route::get('/admin/akun-siswa/{id}/edit', [AdminController::class, 'editAkunSiswa'])->name('admin.akun_siswa.edit');
    Route::put('/admin/akun-siswa/{id}/update', [AdminController::class, 'updateAkunSiswa'])->name('admin.akun_siswa.update');
    Route::delete('/admin/akun-siswa/{id}/destroy', [AdminController::class, 'destroySiswa'])->name('admin.akun_siswa.destroy');
    
    // Rute Pengaturan Rekening Sekolah
    Route::get('/admin/pengaturan-rekening', [AdminController::class, 'editRekening'])->name('admin.rekening');
    Route::put('/admin/pengaturan-rekening', [AdminController::class, 'updateRekening'])->name('admin.rekening.update');

    // Rute Kelola Guru
    Route::get('/admin/guru', [GuruController::class, 'index'])->name('admin.guru.index');
    Route::post('/admin/guru', [GuruController::class, 'store'])->name('admin.guru.store');
    Route::get('/admin/guru/{id}/edit', [GuruController::class, 'edit'])->name('admin.guru.edit');
    Route::put('/admin/guru/{id}', [GuruController::class, 'update'])->name('admin.guru.update');
    Route::delete('/admin/guru/{id}', [GuruController::class, 'destroy'])->name('admin.guru.destroy');

    // Rute Kelola Gaji Guru
    Route::get('/admin/gaji', [GuruController::class, 'gajiIndex'])->name('admin.gaji.index');
    Route::get('/admin/gaji/buat', [GuruController::class, 'gajiCreate'])->name('admin.gaji.create');
    Route::post('/admin/gaji/simpan', [GuruController::class, 'gajiStore'])->name('admin.gaji.store');
    Route::get('/admin/gaji/{id}', [GuruController::class, 'gajiShow'])->name('admin.gaji.show');
    Route::get('/admin/gaji/{id}/pdf', [GuruController::class, 'gajiPdf'])->name('admin.gaji.pdf');
    Route::delete('/admin/gaji/{id}', [GuruController::class, 'gajiDestroy'])->name('admin.gaji.destroy');
});

// ===============================================================
// 2. AREA KHUSUS ORANG TUA SISWA (Digembok dengan role:orang_tua)
// ===============================================================
Route::middleware(['auth', 'role:orang_tua'])->group(function () {
    Route::get('/orangtua/dashboard', [OrangTuaController::class, 'dashboard'])->name('orangtua.dashboard');
    Route::get('/orangtua/tagihan', [OrangTuaController::class, 'tagihanSaya'])->name('orangtua.tagihan');
    Route::post('/orangtua/bayar', [OrangTuaController::class, 'prosesBayar'])->name('orangtua.bayar');
    Route::get('/orangtua/cetak/{id}', [OrangTuaController::class, 'cetakBukti'])->name('orangtua.cetak');
    Route::get('/orangtua/tagihan-mandiri', [OrangTuaController::class, 'tagihanMandiri'])->name('orangtua.tagihan_mandiri');
    Route::post('/orangtua/tagihan-mandiri/simpan', [OrangTuaController::class, 'buatTagihanMandiri'])->name('orangtua.tagihan_mandiri.simpan');
});

// ===============================================================
// 3. AREA KHUSUS KEPALA SEKOLAH (Digembok dengan role:kepala_sekolah)
// ===============================================================
Route::middleware(['auth', 'role:kepala_sekolah'])->group(function () {
    Route::get('/kepsek/dashboard', [KepalaSekolahController::class, 'dashboard'])->name('kepsek.dashboard');
    Route::get('/kepsek/laporan', [KepalaSekolahController::class, 'laporan'])->name('kepsek.laporan');
    Route::get('/kepsek/laporan/pdf', [KepalaSekolahController::class, 'laporanPdf'])->name('kepsek.laporan.pdf');
    Route::post('/kepsek/validasi/{id}', [KepalaSekolahController::class, 'validasi'])->name('kepsek.validasi');
});
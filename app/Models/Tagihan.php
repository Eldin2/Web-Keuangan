<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;
    protected $fillable = ['siswa_id', 'kategori_id', 'nominal', 'status'];

    // Menghubungkan tagihan dengan nama siswa
    public function siswa() {
        return $this->belongsTo(Siswa::class);
    }
    
    // Menghubungkan tagihan dengan jenis kategorinya
    public function kategori() {
        return $this->belongsTo(KategoriTagihan::class);
    }

    // Menghubungkan tagihan dengan data transaksinya (BARU DITAMBAHKAN)
    public function transaksi() {
        return $this->hasOne(Transaksi::class);
    }
}
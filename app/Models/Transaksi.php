<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'tagihan_id', 
        'bukti_bayar', 
        'metode', 
        'nominal_bayar', 
        'tanggal_bayar', 
        'is_valid_kepala_sekolah'
    ];

    public function tagihan() {
        return $this->belongsTo(Tagihan::class);
    }
}
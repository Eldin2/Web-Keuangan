<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GajiGuru extends Model
{
    use HasFactory;

    protected $fillable = [
        'guru_id',
        'bulan',
        'tahun',
        'nominal_gaji',
        'potongan',
        'total_gaji',
        'keterangan',
        'tanggal_dibayar',
        'status_pembayaran'
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }
}

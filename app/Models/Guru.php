<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_guru',
        'nip',
        'status',
        'jabatan',
        'gaji_bulanan'
    ];

    public function gaji()
    {
        return $this->hasMany(GajiGuru::class);
    }
}

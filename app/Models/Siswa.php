<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    // Mengizinkan kolom ini diisi form
    protected $fillable = [
        'user_id',
        'nis',
        'nama_siswa',
        'kelas'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CekRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Mengecek apakah user sudah login dan perannya (role) sesuai dengan yang diminta
        if (Auth::check() && Auth::user()->role == $role) {
            return $next($request);
        }
        
        // Jika tidak sesuai, munculkan halaman error 403 (Akses Ditolak)
        abort(403, 'AKSES DITOLAK: Anda tidak memiliki izin untuk membuka halaman ini untuk Skripsi ini.');
    }
}
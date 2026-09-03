<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Masuk - TK IT INSAN CENDIKIA</title>

    <!-- Memanggil Tailwind & Font agar seragam dengan Halaman Depan -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Nunito', sans-serif; } </style>
    
    <!-- File bawaan sistem Laravel -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="antialiased bg-blue-50 min-h-screen flex flex-col items-center justify-center relative overflow-hidden">
    
    <!-- Latar Belakang Dekoratif Biru -->
    <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>

    <div class="z-10 w-full max-w-md flex flex-col items-center px-6">
        
        <!-- Logo Sekolah & Judul -->
        <a href="/" class="flex flex-col items-center mb-8 hover:scale-105 transition-transform duration-300">
            <div class="bg-white p-4 rounded-full shadow-xl border-4 border-blue-500 mb-4">
                <!-- Memanggil file logo.png -->
                <img src="{{ asset('logo.png') }}" alt="Logo TK IT Insan Cendikia" class="w-20 h-20 object-contain">
            </div>
            <h2 class="text-2xl font-extrabold text-blue-900 tracking-tight text-center drop-shadow-sm">TK IT INSAN CENDIKIA</h2>
        </a>

        <!-- Wadah Putih untuk Form (Akan otomatis diisi oleh form Login atau Register) -->
        <div class="w-full bg-white/95 backdrop-blur-sm shadow-2xl border border-blue-100 rounded-3xl p-8 md:p-10">
            {{ $slot }}
        </div>
        
        <!-- Copyright Bawah -->
        <div class="mt-8 text-sm text-gray-500 font-bold tracking-wide text-center">
            &copy; {{ date('Y') }} TK IT Insan Cendikia.
        </div>
    </div>
</body>
</html>
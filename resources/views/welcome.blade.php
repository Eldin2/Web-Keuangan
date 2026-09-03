<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Administrasi Keuangan - TK IT INSAN CENDIKIA</title>
    
    <!-- Memanggil Tailwind CSS agar tampilannya cantik -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Nunito', sans-serif; }
    </style>
</head>
    <body class="antialiased bg-blue-50 min-h-screen flex flex-col items-center justify-center relative overflow-hidden">
    
        <!-- Latar Belakang Dekoratif -->
        <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-2000"></div>

    <div class="max-w-3xl w-full px-6 text-center z-10 relative">
        
        <!-- Bagian Logo -->
        <div class="mb-8 flex justify-center">
            <div class="bg-white p-5 rounded-full shadow-2xl border-4 border-blue-500 transform hover:scale-105 transition-transform duration-300">
                <img src="{{ asset('logo.png') }}" alt="Logo TK IT Insan Cendikia" class="h-28 w-28 object-contain">
            </div>
        </div>

        <!-- Bagian Judul -->
        <h1 class="text-4xl md:text-5xl font-extrabold text-blue-900 mb-2 tracking-tight">
            Administrasi Keuangan
        </h1>
        <p class="text-2xl text-blue-700 font-black mb-10 tracking-widest uppercase drop-shadow-sm">
            TK IT INSAN CENDIKIA
        </p>

        <!-- Kotak Tombol Login & Register -->
        <div class="bg-white/90 backdrop-blur-sm p-8 md:p-10 rounded-3xl shadow-xl border border-blue-100 max-w-md mx-auto">
            <p class="text-gray-600 mb-8 text-base font-semibold leading-relaxed">
                Selamat datang! Silakan masuk menggunakan akun yang telah terdaftar atau buat akun baru bagi orang tua siswa.
            </p>

            <div class="flex flex-col space-y-4">
                @if (Route::has('login'))
                    @auth
                        <!-- Jika user sudah login tapi tidak sengaja buka halaman depan -->
                        <a href="{{ url('/dashboard') }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-6 rounded-xl shadow-lg hover:shadow-blue-500/30 transition-all duration-200 text-lg">
                            Lanjut ke Dashboard &rarr;
                        </a>
                    @else
                        <!-- Tombol Login -->
                        <a href="{{ route('login') }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-6 rounded-xl shadow-lg hover:shadow-blue-500/30 transition-all duration-200 text-lg">
                            Masuk (Login)
                        </a>

                        <!-- Tombol Register -->
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="w-full bg-white hover:bg-blue-50 text-blue-600 border-2 border-blue-600 font-bold py-3 px-6 rounded-xl shadow-sm transition-all duration-200 text-lg">
                                Daftar Akun Baru
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="mt-12 text-sm text-gray-500 font-bold tracking-wide">
            &copy; {{ date('Y') }} TK IT Insan Cendikia. Hak Cipta Dilindungi.
        </div>
    </div>
</body>
</html>
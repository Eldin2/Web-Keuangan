<x-guest-layout>
    <div class="mb-6">
        <h3 class="text-xl font-extrabold text-blue-900 tracking-tight text-center">Lupa Password?</h3>
        <p class="text-sm text-gray-600 mt-2 text-center">
            Masukkan alamat email terdaftar Anda. Kami akan mengirimkan tautan untuk mengatur ulang password akun Anda.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-bold text-gray-700">Email Terdaftar</label>
            <input id="email" class="block mt-2 w-full rounded-xl border-gray-300 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition py-3 px-4 font-medium" type="email" name="email" :value="old('email')" placeholder="contoh: ortu@tkit.com" required autofocus />
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-4 border-t border-gray-100">
            <a class="text-sm text-blue-600 hover:text-blue-800 font-bold underline" href="{{ route('login') }}">
                &larr; Kembali ke Halaman Login
            </a>

            <button type="submit" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl shadow-md transition-all duration-200 text-sm tracking-wide flex items-center justify-center">
                Kirim Link Reset Password
            </button>
        </div>
    </form>
</x-guest-layout>

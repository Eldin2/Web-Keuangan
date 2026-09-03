<x-guest-layout>
    
    <!-- Pesan Error / Validasi -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Nama Lengkap -->
        <div>
            <label for="name" class="block text-sm font-bold text-gray-700">Nama Lengkap</label>
            <input id="name" class="block mt-2 w-full rounded-xl border-gray-300 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition py-3 px-4" type="text" name="name" :value="old('name')" required autofocus />
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-bold text-gray-700">Email</label>
            <input id="email" class="block mt-2 w-full rounded-xl border-gray-300 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition py-3 px-4" type="email" name="email" :value="old('email')" required />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-bold text-gray-700">Password</label>
            <input id="password" class="block mt-2 w-full rounded-xl border-gray-300 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition py-3 px-4" type="password" name="password" required autocomplete="new-password" />
        </div>

        <!-- Konfirmasi Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-bold text-gray-700">Konfirmasi Password</label>
            <input id="password_confirmation" class="block mt-2 w-full rounded-xl border-gray-300 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition py-3 px-4" type="password" name="password_confirmation" required />
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
            <a class="underline text-sm text-blue-600 hover:text-blue-800 font-bold" href="{{ route('login') }}">
                Sudah punya akun?
            </a>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-md transition-all duration-200 text-lg tracking-wide">
                DAFTAR
            </button>
        </div>
    </form>
</x-guest-layout>
<x-guest-layout>
    <div class="mb-6">
        <h3 class="text-xl font-extrabold text-blue-900 tracking-tight text-center">Atur Ulang Password</h3>
        <p class="text-sm text-gray-600 mt-2 text-center">
            Silakan masukkan alamat email dan password baru untuk akun Anda.
        </p>
    </div>

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-bold text-gray-700">Email Terdaftar</label>
            <input id="email" class="block mt-2 w-full rounded-xl border-gray-300 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition py-3 px-4 font-medium" type="email" name="email" :value="old('email', $request->email)" required autofocus />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-bold text-gray-700">Password Baru</label>
            <input id="password" class="block mt-2 w-full rounded-xl border-gray-300 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition py-3 px-4 font-medium" type="password" name="password" required />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-bold text-gray-700">Konfirmasi Password Baru</label>
            <input id="password_confirmation" class="block mt-2 w-full rounded-xl border-gray-300 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition py-3 px-4 font-medium" type="password" name="password_confirmation" required />
        </div>

        <div class="pt-4 border-t border-gray-100 flex items-center justify-end">
            <button type="submit" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl shadow-md transition-all duration-200 text-sm tracking-wide">
                Simpan Password Baru
            </button>
        </div>
    </form>
</x-guest-layout>

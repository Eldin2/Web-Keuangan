<x-guest-layout>
    
    <!-- Pesan Error / Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-bold text-gray-700">Email</label>
            <input id="email" class="block mt-2 w-full rounded-xl border-gray-300 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition py-3 px-4" type="email" name="email" :value="old('email')" required autofocus />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-bold text-gray-700">Password</label>
            <input id="password" class="block mt-2 w-full rounded-xl border-gray-300 bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition py-3 px-4" type="password" name="password" required autocomplete="current-password" />
        </div>

        <!-- Remember Me -->
        <div class="block">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-5 h-5" name="remember">
                <span class="ml-3 text-sm text-gray-600 font-bold">Ingat saya</span>
            </label>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-blue-600 hover:text-blue-800 font-bold" href="{{ route('password.request') }}">
                    Lupa password?
                </a>
            @endif

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-md transition-all duration-200 text-lg tracking-wide">
                LOG IN
            </button>
        </div>
    </form>
</x-guest-layout>
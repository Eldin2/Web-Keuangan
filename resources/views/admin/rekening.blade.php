<x-app-layout>
    <x-slot name="header">Pengaturan Rekening Pembayaran</x-slot>

    <div class="w-full mt-4">
        <!-- Session Feedback -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-5 py-4 rounded-2xl shadow-sm">
                <strong class="font-bold block mb-1">Berhasil!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-5 py-4 rounded-2xl shadow-sm">
                <strong class="font-bold block mb-1">Terjadi Kesalahan!</strong>
                <ul class="list-disc ml-5 text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6 md:p-8">
            <div class="border-b pb-4 mb-6">
                <h3 class="text-xl font-extrabold text-gray-900 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    Informasi Rekening Sekolah
                </h3>
                <p class="text-sm text-gray-500 mt-1">Ubah rincian tujuan transfer bank di bawah ini. Informasi ini akan langsung tampil secara real-time pada dashboard pembayaran semua akun wali murid (orang tua).</p>
            </div>

            <form action="{{ route('admin.rekening.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nama Bank</label>
                    <input type="text" name="norek_bank_name" value="{{ old('norek_bank_name', $bank_name) }}" class="w-full rounded-xl border-gray-250 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 transition py-3 px-4 font-bold text-gray-700 shadow-sm" placeholder="Contoh: BANK BRI, BANK MANDIRI" required>
                    <p class="text-xs text-gray-400 mt-1.5">*Gunakan nama bank yang singkat dan jelas.</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nomor Rekening</label>
                    <input type="text" name="norek_number" value="{{ old('norek_number', $norek_number) }}" class="w-full rounded-xl border-gray-250 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 transition py-3 px-4 font-bold text-gray-700 tracking-wider shadow-sm" placeholder="Contoh: 1111 222 33333" required>
                    <p class="text-xs text-gray-400 mt-1.5">*Format penulisan nomor rekening (bisa menyertakan spasi atau tanda hubung).</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Atas Nama (Pemilik Rekening)</label>
                    <input type="text" name="norek_owner" value="{{ old('norek_owner', $norek_owner) }}" class="w-full rounded-xl border-gray-250 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 transition py-3 px-4 font-bold text-gray-700 shadow-sm" placeholder="Contoh: TK IT INSAN CENDIKIA" required>
                    <p class="text-xs text-gray-400 mt-1.5">*Nama pemilik rekening harus sesuai dengan nama yang terdaftar di bank.</p>
                </div>

                <div class="pt-4 border-t border-gray-100 flex flex-col md:flex-row gap-3">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-md transition duration-200 text-md text-center">
                        Simpan Perubahan Rekening
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3.5 px-6 rounded-xl transition text-md text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">Kelola Akun Siswa & Wali</x-slot>

    <div class="w-full mt-4">

        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-5 py-4 rounded-2xl shadow-sm">
                <strong class="font-bold block mb-1">Gagal Menyimpan Perubahan!</strong>
                <ul class="list-disc ml-5 text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6 md:p-8">
            <div class="border-b pb-4 mb-6">
                <h3 class="text-xl font-extrabold text-gray-900">Edit Akun Siswa & Wali Terhubung</h3>
                <p class="text-sm text-gray-500 mt-1">Sesuaikan informasi siswa dan konfigurasi hubungan akun orang tua/wali murid.</p>
            </div>

            <form action="{{ route('admin.akun_siswa.update', $siswa->id) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- SECTION 1: DATA SISWA -->
                <div class="space-y-4">
                    <h4 class="text-md font-bold text-gray-800 flex items-center gap-2">
                        <span class="flex items-center justify-center w-6 h-6 bg-blue-100 text-blue-700 text-xs font-black rounded-full">1</span>
                        Informasi Profil Siswa
                    </h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">NIS (Nomor Induk Siswa)</label>
                            <input type="text" name="nis" value="{{ old('nis', $siswa->nis) }}" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 transition py-3 px-4 font-bold text-gray-700" required>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nama Lengkap Siswa</label>
                            <input type="text" name="nama_siswa" value="{{ old('nama_siswa', $siswa->nama_siswa) }}" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 transition py-3 px-4 font-bold text-gray-700" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Kelas</label>
                        <input type="text" name="kelas" value="{{ old('kelas', $siswa->kelas) }}" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 transition py-3 px-4 font-bold text-gray-700" required>
                    </div>
                </div>

                <hr class="border-gray-100">

                <!-- SECTION 2: AKUN ORANG TUA / WALI -->
                <div x-data="{ action: '{{ old('parent_action', $siswa->user_id ? 'edit' : 'link_existing') }}' }" class="space-y-6">
                    <h4 class="text-md font-bold text-gray-800 flex items-center gap-2">
                        <span class="flex items-center justify-center w-6 h-6 bg-blue-100 text-blue-700 text-xs font-black rounded-full">2</span>
                        Pengaturan Hubungan Akun Orang Tua (Wali)
                    </h4>

                    <!-- PILIHAN AKSI KONEKSI AKUN -->
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Pilih Tindakan untuk Akun Orang Tua:</label>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                            @if($siswa->user_id)
                                <!-- Option: Edit Existing -->
                                <label :class="action === 'edit' ? 'border-blue-500 bg-blue-50/50 ring-2 ring-blue-500/20' : 'border-gray-200 bg-white'" class="flex flex-col p-4 border rounded-xl cursor-pointer hover:bg-gray-50 transition shadow-sm">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm font-bold text-gray-900">Edit Akun Saat Ini</span>
                                        <input type="radio" name="parent_action" value="edit" x-model="action" class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    </div>
                                    <span class="text-xs text-gray-500 leading-relaxed">Ubah nama, email, atau password akun orang tua yang terhubung saat ini.</span>
                                </label>
                            @endif

                            <!-- Option: Link Existing -->
                            <label :class="action === 'link_existing' ? 'border-blue-500 bg-blue-50/50 ring-2 ring-blue-500/20' : 'border-gray-200 bg-white'" class="flex flex-col p-4 border rounded-xl cursor-pointer hover:bg-gray-50 transition shadow-sm">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-bold text-gray-900">Hubungkan Akun Lain</span>
                                    <input type="radio" name="parent_action" value="link_existing" x-model="action" class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                </div>
                                <span class="text-xs text-gray-500 leading-relaxed">Ganti koneksi ke akun orang tua lain yang sudah terdaftar di database.</span>
                            </label>

                            <!-- Option: Create New -->
                            <label :class="action === 'create_new' ? 'border-blue-500 bg-blue-50/50 ring-2 ring-blue-500/20' : 'border-gray-200 bg-white'" class="flex flex-col p-4 border rounded-xl cursor-pointer hover:bg-gray-50 transition shadow-sm">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-bold text-gray-900">Buat Akun Baru</span>
                                    <input type="radio" name="parent_action" value="create_new" x-model="action" class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                </div>
                                <span class="text-xs text-gray-500 leading-relaxed">Buat akun login orang tua baru dari awal dan langsung hubungkan ke siswa ini.</span>
                            </label>

                            @if($siswa->user_id)
                                <!-- Option: Unlink -->
                                <label :class="action === 'unlink' ? 'border-red-500 bg-red-50/50 ring-2 ring-red-500/20' : 'border-gray-200 bg-white'" class="flex flex-col p-4 border rounded-xl cursor-pointer hover:bg-gray-50 transition shadow-sm">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm font-bold text-red-600">Putus Hubungan</span>
                                        <input type="radio" name="parent_action" value="unlink" x-model="action" class="w-4 h-4 text-red-600 focus:ring-red-500 border-gray-300">
                                    </div>
                                    <span class="text-xs text-gray-500 leading-relaxed">Lepaskan akun orang tua dari siswa ini. Status siswa berubah menjadi offline.</span>
                                </label>
                            @endif
                        </div>
                    </div>

                    <!-- BLOK DINAMIS BERDASARKAN AKSI PILIHAN -->
                    
                    <!-- 1. EDIT CURRENT LINKED ACCOUNT -->
                    @if($siswa->user_id)
                        <div x-show="action === 'edit'" class="p-5 bg-blue-50/30 rounded-2xl border border-blue-100 space-y-4" style="display: none;">
                            <h5 class="text-sm font-extrabold text-blue-800 flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                Edit Akun Orang Tua Aktif
                            </h5>
                            
                            <input type="hidden" name="parent_id" value="{{ $siswa->user_id }}">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-600 mb-1">Nama Orang Tua / Wali</label>
                                    <input type="text" name="parent_name" value="{{ old('parent_name', $siswa->user->name) }}" class="w-full rounded-xl border-gray-200 bg-white focus:ring-2 focus:ring-blue-500 transition py-2.5 px-3.5 text-sm font-semibold">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-600 mb-1">Email Orang Tua / Wali</label>
                                    <input type="email" name="parent_email" value="{{ old('parent_email', $siswa->user->email) }}" class="w-full rounded-xl border-gray-200 bg-white focus:ring-2 focus:ring-blue-500 transition py-2.5 px-3.5 text-sm font-semibold">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1">Ganti Password (Opsional)</label>
                                <input type="password" name="parent_password" placeholder="Kosongkan jika tidak ingin mengubah password akun" class="w-full rounded-xl border-gray-200 bg-white focus:ring-2 focus:ring-blue-500 transition py-2.5 px-3.5 text-sm">
                                <p class="text-xs text-gray-400 mt-1.5">*Minimal 8 karakter jika ingin mereset password wali murid.</p>
                            </div>
                        </div>
                    @endif

                    <!-- 2. LINK TO AN EXISTING ACCOUNT -->
                    <div x-show="action === 'link_existing'" class="p-5 bg-blue-50/30 rounded-2xl border border-blue-100 space-y-4" style="display: none;">
                        <h5 class="text-sm font-extrabold text-blue-800 flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                            Hubungkan ke Akun Orang Tua Terdaftar
                        </h5>
                        
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-2">Pilih Orang Tua / Wali:</label>
                            <select name="existing_user_id" class="w-full rounded-xl border-gray-200 bg-white focus:ring-2 focus:ring-blue-500 transition py-3 px-4 text-sm font-semibold">
                                <option value="">-- Pilih Akun Orang Tua --</option>
                                @foreach($orangtuas as $ortu)
                                    <option value="{{ $ortu->id }}" {{ old('existing_user_id', $siswa->user_id) == $ortu->id ? 'selected' : '' }}>
                                        {{ $ortu->name }} ({{ $ortu->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- 3. CREATE A NEW PARENT ACCOUNT -->
                    <div x-show="action === 'create_new'" class="p-5 bg-blue-50/30 rounded-2xl border border-blue-100 space-y-4" style="display: none;">
                        <h5 class="text-sm font-extrabold text-blue-800 flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                            Buat Akun Orang Tua Baru & Koneksikan
                        </h5>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1">Nama Lengkap Orang Tua</label>
                                <input type="text" name="new_parent_name" value="{{ old('new_parent_name') }}" class="w-full rounded-xl border-gray-200 bg-white focus:ring-2 focus:ring-blue-500 transition py-2.5 px-3.5 text-sm" placeholder="Contoh: Budi Santoso">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1">Email Akun Orang Tua</label>
                                <input type="email" name="new_parent_email" value="{{ old('new_parent_email') }}" class="w-full rounded-xl border-gray-200 bg-white focus:ring-2 focus:ring-blue-500 transition py-2.5 px-3.5 text-sm" placeholder="Contoh: budi@email.com">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1">Password Akun Baru</label>
                            <input type="password" name="new_parent_password" class="w-full rounded-xl border-gray-200 bg-white focus:ring-2 focus:ring-blue-500 transition py-2.5 px-3.5 text-sm" placeholder="Masukkan password unik">
                            <p class="text-xs text-gray-400 mt-1.5">*Minimal 8 karakter. Sandi ini akan digunakan orang tua untuk login ke portal.</p>
                        </div>
                    </div>

                    <!-- 4. UNLINK ACCOUNT (WARNING) -->
                    @if($siswa->user_id)
                        <div x-show="action === 'unlink'" class="p-5 bg-red-50 rounded-2xl border border-red-200 space-y-3" style="display: none;">
                            <h5 class="text-sm font-extrabold text-red-800 flex items-center gap-1.5">
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                Peringatan Pemutusan Hubungan
                            </h5>
                            <p class="text-sm text-red-700 leading-relaxed font-semibold">
                                Hubungan antara siswa <strong>{{ $siswa->nama_siswa }}</strong> dan akun orang tua <strong>{{ $siswa->user->name }} ({{ $siswa->user->email }})</strong> akan dilepas.
                            </p>
                            <p class="text-xs text-red-500 leading-relaxed">
                                Akun orang tua itu sendiri tidak akan dihapus dari sistem, namun akun tersebut tidak akan lagi memiliki hak akses untuk melihat tagihan atau melakukan transfer pembayaran online atas nama siswa ini.
                            </p>
                        </div>
                    @endif
                </div>

                <!-- SUBMIT BUTTONS -->
                <div class="pt-6 border-t border-gray-100 flex flex-col md:flex-row gap-3">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-md transition duration-200 text-md text-center">
                        Simpan Perubahan Akun & Wali
                    </button>
                    <a href="{{ route('admin.akun_siswa') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3.5 px-6 rounded-xl transition text-md text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">Edit Data Siswa</x-slot>

    <div class="w-full mt-4">
        
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-8 md:p-10">
            
            <div class="flex items-center justify-between mb-6 border-b pb-4">
                <h3 class="text-xl font-extrabold text-gray-900">Perbarui Data: {{ $siswa->nama_siswa }}</h3>
            </div>
            
            <form action="{{ route('admin.siswa.update', $siswa->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT') 
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">NIS (Nomor Induk Siswa)</label>
                    <input type="text" name="nis" value="{{ $siswa->nis }}" class="w-full rounded-xl border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 transition py-3" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap Siswa</label>
                    <input type="text" name="nama_siswa" value="{{ $siswa->nama_siswa }}" class="w-full rounded-xl border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 transition py-3" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Kelas</label>
                    <input type="text" name="kelas" value="{{ $siswa->kelas }}" class="w-full rounded-xl border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 transition py-3" required>
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Hubungkan dengan Akun Orang Tua</label>
                    <select name="user_id" class="w-full rounded-xl border-gray-300 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 transition py-3">
                        <option value="">-- Pembayaran Offline (Tidak Punya HP / Akun) --</option>
                        @foreach($orangtuas as $ortu)
                            <option value="{{ $ortu->id }}" {{ $siswa->user_id == $ortu->id ? 'selected' : '' }}>
                                {{ $ortu->name }} ({{ $ortu->email }})
                            </option>
                        @endforeach
                    </select>
                    @if(!$siswa->user_id)
                        <p class="text-sm text-red-500 mt-2 font-bold">*Siswa ini menggunakan sistem Pembayaran Offline.</p>
                    @endif
                </div>
                
                <div class="pt-4">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-4 rounded-xl shadow-md transition-all duration-200 text-lg tracking-wide">
                        Simpan Perubahan
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
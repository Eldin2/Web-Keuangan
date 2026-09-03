<x-app-layout>
    <x-slot name="header">Edit Data & Gaji Guru</x-slot>

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between border-b pb-4 mb-6">
            <h3 class="text-lg font-bold text-gray-900">Ubah Data Guru: {{ $guru->nama_guru }}</h3>
            <a href="{{ route('admin.guru.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold px-4 py-2 rounded-xl transition">
                Kembali
            </a>
        </div>

        <form action="{{ route('admin.guru.update', $guru->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Basic Info -->
            <div class="space-y-4">
                <h4 class="text-sm font-extrabold text-gray-800 border-l-4 border-blue-600 pl-2">Informasi Pribadi</h4>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama_guru" value="{{ old('nama_guru', $guru->nama_guru) }}" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 transition py-2.5 px-3.5 text-sm" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">NIP</label>
                        <input type="text" name="nip" value="{{ old('nip', $guru->nip) }}" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 transition py-2.5 px-3.5 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Status Kerja</label>
                        <select name="status" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 transition py-2.5 px-3.5 text-sm" required>
                            <option value="Honor" {{ old('status', $guru->status) == 'Honor' ? 'selected' : '' }}>Honor / GTT</option>
                            <option value="Tetap Yayasan" {{ old('status', $guru->status) == 'Tetap Yayasan' ? 'selected' : '' }}>Tetap Yayasan</option>
                            <option value="PNS" {{ old('status', $guru->status) == 'PNS' ? 'selected' : '' }}>PNS Diperbantukan</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Jabatan / Tugas</label>
                    <input type="text" name="jabatan" value="{{ old('jabatan', $guru->jabatan) }}" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 transition py-2.5 px-3.5 text-sm" required>
                </div>
            </div>

            <!-- Salary Configuration -->
            <div class="border-t border-gray-100 pt-6 space-y-4">
                <h4 class="text-sm font-extrabold text-blue-700 border-l-4 border-blue-700 pl-2 uppercase tracking-wider">Keuangan</h4>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nominal Gaji Bulanan (Rp)</label>
                    <input type="number" name="gaji_bulanan" value="{{ old('gaji_bulanan', $guru->gaji_bulanan) }}" min="0" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 transition py-2.5 px-3.5 text-sm" required>
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-md transition-all duration-200 mt-8">
                Perbarui Data Guru
            </button>
        </form>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">Kelola Data Guru & Gaji Bulanan</x-slot>

    <!-- Session Feedback -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-2xl shadow-sm flex items-center justify-between">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-xl mr-3 text-green-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <p class="text-sm font-bold text-green-800">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Statistik Guru & Gaji -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Tenaga Pengajar</p>
                <p class="text-3xl font-black text-gray-800 mt-1">{{ $totalGuru }} Guru</p>
            </div>
            <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Gaji Terbayar Bulan Ini</p>
                <p class="text-3xl font-black text-green-600 mt-1">Rp {{ number_format($gajiBulanIni, 0, ',', '.') }}</p>
            </div>
            <div class="p-3 bg-green-50 text-green-600 rounded-xl">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 8h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Akumulasi Pengeluaran Gaji</p>
                <p class="text-3xl font-black text-gray-800 mt-1">Rp {{ number_format($totalGajiTerbayar, 0, ',', '.') }}</p>
            </div>
            <div class="p-3 bg-red-50 text-red-600 rounded-xl">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column: Add Teacher -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 h-fit lg:col-span-1">
            <h3 class="text-lg font-bold text-gray-900 border-b pb-3 mb-4">Registrasi Guru Baru</h3>
            
            <form action="{{ route('admin.guru.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama_guru" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 transition py-2.5 px-3.5 text-sm font-semibold" placeholder="Nama Guru beserta gelar" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">NIP</label>
                        <input type="text" name="nip" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 transition py-2.5 px-3.5 text-sm font-semibold" placeholder="NIP (opsional)">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Status Kerja</label>
                        <select name="status" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 transition py-2.5 px-3.5 text-sm font-semibold" required>
                            <option value="Honor">Honor / GTT</option>
                            <option value="Tetap Yayasan">Tetap Yayasan</option>
                            <option value="PNS">PNS Diperbantukan</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Jabatan / Tugas</label>
                    <input type="text" name="jabatan" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 transition py-2.5 px-3.5 text-sm font-semibold" placeholder="Contoh: Wali Kelas B, Guru Sentra" required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nominal Gaji Bulanan (Rp)</label>
                    <input type="number" name="gaji_bulanan" value="0" min="0" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 transition py-2.5 px-3.5 text-sm font-semibold" required>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl shadow-md transition-all duration-200 mt-6 text-sm">
                    Simpan Data Guru
                </button>
            </form>
        </div>

        <!-- Right Column: Teachers List Table -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 lg:col-span-2">
            <div class="flex items-center justify-between border-b pb-4 mb-4">
                <h3 class="text-lg font-bold text-gray-900">Daftar Tenaga Pendidik</h3>
                <a href="{{ route('admin.gaji.index') }}" class="bg-green-600 hover:bg-green-700 text-white text-xs font-bold px-4 py-2 rounded-xl transition shadow-sm flex items-center">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Kelola Transaksi Gaji
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider rounded-l-lg">Guru</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Jabatan</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Gaji Bulanan</th>
                            <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-r-lg">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-150">
                        @forelse($gurus as $guru)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ $guru->nama_guru }}</div>
                                    <div class="text-xs text-gray-400">
                                        NIP: {{ $guru->nip ?? '-' }} | 
                                        <span class="font-bold text-blue-600">{{ $guru->status }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="text-sm font-semibold text-gray-600">{{ $guru->jabatan }}</span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-bold text-gray-800 font-mono">
                                    Rp {{ number_format($guru->gaji_bulanan, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-center text-xs">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <a href="{{ route('admin.gaji.create', ['guru_id' => $guru->id]) }}" class="bg-blue-50 text-blue-700 hover:bg-blue-100 font-bold py-1.5 px-3 rounded-lg transition" title="Buat Slip Gaji">
                                            Buat Gaji
                                        </a>
                                        <a href="{{ route('admin.guru.edit', $guru->id) }}" class="bg-yellow-50 text-yellow-700 hover:bg-yellow-100 font-bold py-1.5 px-3 rounded-lg transition">
                                            Edit
                                        </a>
                                        <form id="delete-guru-{{ $guru->id }}" action="{{ route('admin.guru.destroy', $guru->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDeleteGuru('{{ $guru->id }}', '{{ addslashes($guru->nama_guru) }}')" class="bg-red-50 text-red-700 hover:bg-red-100 font-bold py-1.5 px-3 rounded-lg transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-sm text-gray-400">Belum ada data guru terdaftar. Silakan tambahkan lewat form di sebelah kiri.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        function confirmDeleteGuru(id, nama) {
            Swal.fire({
                title: 'Hapus Data Guru?',
                text: 'Apakah Anda yakin ingin menghapus data guru "' + nama + '"?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus Data',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-3xl p-6 shadow-2xl border border-gray-100',
                    title: 'text-xl font-extrabold text-gray-900',
                    confirmButton: 'bg-red-600 hover:bg-red-700 text-white font-bold px-5 py-2.5 rounded-xl shadow-sm text-sm',
                    cancelButton: 'bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold px-5 py-2.5 rounded-xl text-sm mr-2'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-guru-' + id).submit();
                }
            });
        }
    </script>
</x-app-layout>

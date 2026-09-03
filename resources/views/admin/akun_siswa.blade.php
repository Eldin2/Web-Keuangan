<x-app-layout>
    <x-slot name="header">Daftar Akun Siswa & Orang Tua</x-slot>

    <div class="grid grid-cols-1 gap-6 mt-4 w-full">
        
        @if(session('success'))
            <div class="p-4 bg-green-50 border-l-4 border-green-500 rounded-r-2xl shadow-sm flex items-center justify-between">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-xl mr-3 text-green-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <p class="text-sm font-bold text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="p-4 bg-red-50 border-l-4 border-red-500 rounded-r-2xl shadow-sm">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-sm font-bold text-red-800">Terjadi Kesalahan!</p>
                </div>
                <ul class="list-disc pl-8 text-xs text-red-700 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6 md:p-8">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-6 border-b pb-4 gap-4">
                <div>
                    <h3 class="text-xl font-extrabold text-gray-900">Direktori Siswa & Wali</h3>
                    <p class="text-sm text-gray-500 mt-1">Lihat status koneksi akun orang tua untuk setiap siswa.</p>
                </div>
                
                <form action="{{ route('admin.akun_siswa') }}" method="GET" class="flex flex-wrap items-center gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Siswa atau Orang Tua..." class="w-full md:w-64 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 transition py-2 px-3 text-sm font-semibold">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-blue-700 transition shadow-sm">Cari</button>
                    @if(request('search'))
                        <a href="{{ route('admin.akun_siswa') }}" class="bg-gray-100 text-gray-600 px-3 py-2 rounded-xl text-sm font-bold hover:bg-gray-200 transition">Reset</a>
                    @endif
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-extrabold text-gray-500 uppercase tracking-wider rounded-tl-lg">Informasi Siswa</th>
                            <th class="px-6 py-4 text-left text-sm font-extrabold text-gray-500 uppercase tracking-wider">Status Akun Orang Tua</th>
                            <th class="px-6 py-4 text-center text-sm font-extrabold text-gray-500 uppercase tracking-wider rounded-tr-lg">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($siswas as $siswa)
                        <tr class="hover:bg-blue-50 transition duration-150">
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="text-base font-bold text-gray-900">{{ $siswa->nama_siswa }}</div>
                                <div class="text-sm text-gray-500 mt-0.5">
                                    <span class="mr-2 font-mono">NIS: {{ $siswa->nis }}</span>
                                    <span class="px-2.5 py-0.5 bg-blue-50 text-blue-700 border border-blue-100 text-xs font-bold rounded-full">Kelas {{ $siswa->kelas }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                @if($siswa->user)
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-emerald-100 rounded-full flex items-center justify-center">
                                            <svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-900">{{ $siswa->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $siswa->user->email }}</div>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-red-50 rounded-full flex items-center justify-center border border-red-100">
                                            <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                        </div>
                                        <div class="ml-4">
                                            <span class="text-red-500 font-bold text-sm">Belum Ada Akun Terhubung</span>
                                            <div class="text-xs text-red-400 mt-0.5">Siswa ini hanya bisa membayar secara tunai/offline</div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.akun_siswa.edit', $siswa->id) }}" class="inline-flex items-center bg-amber-500 hover:bg-amber-600 text-white font-bold py-2 px-4 rounded-xl text-xs transition shadow-sm gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        Kelola Akun
                                    </a>
                                    <form id="delete-form-{{ $siswa->id }}" action="{{ route('admin.akun_siswa.destroy', $siswa->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete('{{ $siswa->id }}', '{{ addslashes($siswa->nama_siswa) }}', '{{ $siswa->nis }}')" class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-xl text-xs transition shadow-sm gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-10 text-center text-base text-gray-400">Tidak ada data siswa.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <script>
        function confirmDelete(id, nama, nis) {
            Swal.fire({
                title: 'Hapus Data Siswa?',
                text: 'Apakah Anda yakin ingin menghapus data siswa "' + nama + '" (NIS: ' + nis + ')? Semua data tagihan terkait juga akan terpengaruh.',
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
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
</x-app-layout>

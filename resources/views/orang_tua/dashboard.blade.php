<x-app-layout>
    <x-slot name="header">Dashboard Utama - Portal Orang Tua</x-slot>

    <div class="space-y-6 mt-4">
        
        <!-- Welcome Card -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 md:p-8 text-white shadow-lg flex flex-col md:flex-row items-center justify-between">
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight">Selamat Datang, {{ Auth::user()->name }}</h2>
                <p class="text-blue-100 text-sm mt-1">
                    Wali dari: 
                    <span class="font-bold underline">
                        @forelse($anak_list as $anak)
                            {{ $anak->nama_siswa }} (Kelas {{ $anak->kelas }}){{ !$loop->last ? ', ' : '' }}
                        @empty
                            -
                        @endforelse
                    </span>
                </p>
            </div>
            <div class="mt-4 md:mt-0 flex items-center space-x-3">
                <a href="{{ route('orangtua.tagihan') }}" class="inline-flex items-center px-5 py-3 bg-white text-blue-700 hover:bg-blue-50 font-bold rounded-xl text-sm transition shadow-md">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Bayar Tagihan
                </a>
            </div>
        </div>

        <!-- Summary Stat Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Tagihan Belum Dibayar</p>
                        <p class="text-2xl font-extrabold text-red-600 mt-2">Rp {{ number_format($stats['total_belum_bayar_nominal'], 0, ',', '.') }}</p>
                        <p class="text-xs text-red-500 font-semibold mt-1">{{ $stats['total_belum_bayar_count'] }} Tagihan Aktif</p>
                    </div>
                    <div class="p-3.5 bg-red-50 rounded-2xl text-red-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Proses Verifikasi Admin</p>
                        <p class="text-2xl font-extrabold text-amber-600 mt-2">{{ $stats['total_verifikasi_count'] }} Tagihan</p>
                        <p class="text-xs text-amber-500 font-semibold mt-1">Bukti bayar sedang dikonfirmasi</p>
                    </div>
                    <div class="p-3.5 bg-amber-50 rounded-2xl text-amber-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pembayaran Lunas</p>
                        <p class="text-2xl font-extrabold text-green-600 mt-2">Rp {{ number_format($stats['total_lunas_nominal'], 0, ',', '.') }}</p>
                        <p class="text-xs text-green-600 font-semibold mt-1">{{ $stats['total_lunas_count'] }} Tagihan Lunas</p>
                    </div>
                    <div class="p-3.5 bg-green-50 rounded-2xl text-green-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

        </div>

        <!-- Quick Access Banner Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="{{ route('orangtua.tagihan') }}" class="group bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:border-blue-300 hover:shadow-md transition flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="p-4 bg-blue-50 text-blue-600 rounded-2xl group-hover:bg-blue-600 group-hover:text-white transition">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-base font-extrabold text-gray-900 group-hover:text-blue-600 transition">Tagihan Saya</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Lihat rincian tagihan, upload bukti bayar & riwayat pembayaran</p>
                    </div>
                </div>
                <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>

            <a href="{{ route('orangtua.tagihan_mandiri') }}" class="group bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:border-blue-300 hover:shadow-md transition flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="p-4 bg-emerald-50 text-emerald-600 rounded-2xl group-hover:bg-emerald-600 group-hover:text-white transition">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-base font-extrabold text-gray-900 group-hover:text-emerald-600 transition">Buat Tagihan Mandiri</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Inisiatif pembuatan & pembayaran tagihan sekolah secara mandiri</p>
                    </div>
                </div>
                <svg class="w-5 h-5 text-gray-400 group-hover:text-emerald-600 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>

        <!-- Recent Bills Table Preview -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6 md:p-8">
            <div class="flex items-center justify-between mb-6 border-b pb-4">
                <div>
                    <h3 class="text-lg font-extrabold text-gray-900">Ringkasan Tagihan Terbaru</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Tagihan sekolah terbaru untuk anak Anda</p>
                </div>
                <a href="{{ route('orangtua.tagihan') }}" class="text-sm font-bold text-blue-600 hover:text-blue-800 flex items-center transition">
                    Lihat Semua Tagihan 
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-extrabold text-gray-500 uppercase tracking-wider rounded-tl-lg">Siswa</th>
                            <th class="px-6 py-4 text-left text-xs font-extrabold text-gray-500 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-4 text-left text-xs font-extrabold text-gray-500 uppercase tracking-wider">Nominal</th>
                            <th class="px-6 py-4 text-center text-xs font-extrabold text-gray-500 uppercase tracking-wider rounded-tr-lg">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($recent_tagihan as $t)
                        <tr class="hover:bg-blue-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                {{ $t->siswa->nama_siswa ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $t->kategori->nama_kategori ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">
                                Rp {{ number_format($t->nominal, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($t->status == 'lunas')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                        Lunas
                                    </span>
                                @elseif($t->status == 'proses_verifikasi')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700">
                                        Dicek Admin
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                        Belum Bayar
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-400">Belum ada tagihan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
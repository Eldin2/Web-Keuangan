<x-app-layout>
    <x-slot name="header">Dashboard Utama - Kepala Sekolah</x-slot>

    <div class="w-full mt-4 space-y-6">
        
        <!-- Welcome Card -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 md:p-8 text-white shadow-lg flex flex-col md:flex-row items-center justify-between">
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight">Selamat Datang, {{ Auth::user()->name }}</h2>
                <p class="text-blue-100 text-sm mt-1">Ringkasan statistik dan pengawasan laporan keuangan sekolah</p>
            </div>
            <a href="{{ route('kepsek.laporan') }}" class="mt-4 md:mt-0 inline-flex items-center px-5 py-3 bg-white text-blue-700 hover:bg-blue-50 font-bold rounded-xl text-sm transition shadow-md">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Kelola Laporan Transaksi
            </a>
        </div>

        <!-- Summary Stat Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Transaksi Lunas</p>
                        <p class="text-2xl font-extrabold text-gray-900 mt-2">Rp {{ number_format($totalNominal, 0, ',', '.') }}</p>
                        <p class="text-xs text-blue-600 font-semibold mt-1">{{ $totalTransaksi }} Transaksi Masuk</p>
                    </div>
                    <div class="p-3.5 bg-blue-50 rounded-2xl text-blue-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Menunggu Validasi</p>
                        <p class="text-2xl font-extrabold text-amber-600 mt-2">{{ $menungguValidasi }} Transaksi</p>
                        <p class="text-xs text-amber-500 font-semibold mt-1">Perlu ditinjau Kepala Sekolah</p>
                    </div>
                    <div class="p-3.5 bg-amber-50 rounded-2xl text-amber-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Validasi Selesai</p>
                        <p class="text-2xl font-extrabold text-green-600 mt-2">{{ $sudahValidasi }} Transaksi</p>
                        <p class="text-xs text-green-600 font-semibold mt-1">Tersimpan di Arsip Digital</p>
                    </div>
                    <div class="p-3.5 bg-green-50 rounded-2xl text-green-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

        </div>

        <!-- Recent Transactions Table Preview -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6 md:p-8">
            <div class="flex items-center justify-between mb-6 border-b pb-4">
                <div>
                    <h3 class="text-lg font-extrabold text-gray-900">Ringkasan Laporan Terbaru</h3>
                    <p class="text-xs text-gray-500 mt-0.5">5 transaksi lunas paling baru</p>
                </div>
                <a href="{{ route('kepsek.laporan') }}" class="text-sm font-bold text-blue-600 hover:text-blue-800 flex items-center transition">
                    Lihat Semua 
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-extrabold text-gray-500 uppercase tracking-wider rounded-tl-lg">Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-extrabold text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                            <th class="px-6 py-4 text-left text-xs font-extrabold text-gray-500 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-4 text-left text-xs font-extrabold text-gray-500 uppercase tracking-wider">Nominal</th>
                            <th class="px-6 py-4 text-center text-xs font-extrabold text-gray-500 uppercase tracking-wider rounded-tr-lg">Status Validasi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($recentTransaksis as $trx)
                        <tr class="hover:bg-blue-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($trx->tanggal_bayar)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                {{ $trx->tagihan->siswa->nama_siswa ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $trx->tagihan->kategori->nama_kategori ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">
                                Rp {{ number_format($trx->nominal_bayar, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($trx->is_valid_kepala_sekolah)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                        Arsip Digital
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700">
                                        Menunggu Validasi
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-400">Belum ada transaksi lunas.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
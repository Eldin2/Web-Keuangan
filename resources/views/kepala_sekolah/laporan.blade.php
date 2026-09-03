<x-app-layout>
    <x-slot name="header">Dasbor Kepala Sekolah - Validasi Laporan Keuangan</x-slot>

    <div class="w-full mt-4 space-y-6">
        
        @if(session('success'))
            <div class="p-4 bg-green-50 border-l-4 border-green-500 rounded-r-xl shadow-sm flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm font-semibold text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Card Filter Laporan -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6 md:p-8">
            <div class="flex items-center justify-between mb-4 border-b pb-3">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-50 text-blue-600 rounded-xl mr-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-base font-extrabold text-gray-900">Filter Laporan Transaksi</h4>
                        <p class="text-xs text-gray-500">Pilih kriteria pencarian untuk menyaring laporan keuangan</p>
                    </div>
                </div>
            </div>

            <form method="GET" action="{{ route('kepsek.laporan') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
                
                <!-- Filter Bulan -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Bulan</label>
                    <select name="bulan" class="w-full rounded-xl border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Semua Bulan</option>
                        @foreach([
                            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
                            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
                            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                        ] as $key => $name)
                            <option value="{{ $key }}" {{ request('bulan') == $key ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Tahun -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Tahun</label>
                    <select name="tahun" class="w-full rounded-xl border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Semua Tahun</option>
                        @foreach($tahunList as $t)
                            <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Jenis Laporan / Kategori -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Jenis Laporan / Kategori</label>
                    <select name="kategori_id" class="w-full rounded-xl border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Semua Jenis / Kategori</option>
                        @foreach($kategoriList as $kat)
                            <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Status Validasi -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Status Validasi</label>
                    <select name="status_validasi" class="w-full rounded-xl border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Semua Status</option>
                        <option value="menunggu" {{ request('status_validasi') == 'menunggu' ? 'selected' : '' }}>Menunggu Validasi</option>
                        <option value="valid" {{ request('status_validasi') == 'valid' ? 'selected' : '' }}>Tersimpan di Arsip Digital</option>
                    </select>
                </div>

                <!-- Tombol Action -->
                <div class="flex items-center space-x-2">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-xl text-sm transition shadow-sm flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        Tampilkan Laporan
                    </button>
                    @if(request()->hasAny(['bulan', 'tahun', 'kategori_id', 'status_validasi']))
                        <a href="{{ route('kepsek.laporan') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold py-2.5 px-3 rounded-xl text-sm transition" title="Reset Filter">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        </a>
                    @endif
                </div>

            </form>
        </div>

        <!-- Card Tabel Data Transaksi -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-8 md:p-10">
            
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 border-b pb-4 gap-4">
                <div>
                    <h3 class="text-xl font-extrabold text-gray-900">Laporan Transaksi Lunas</h3>
                    <p class="text-xs text-gray-500 mt-1">Daftar seluruh transaksi lunas yang memerlukan validasi Kepala Sekolah</p>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">
                        Total Data: {{ $transaksis->count() }} Transaksi
                    </span>
                    <a href="{{ route('kepsek.laporan.pdf', request()->all()) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-bold text-xs rounded-xl transition shadow-sm">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Cetak PDF
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-extrabold text-gray-500 uppercase tracking-wider rounded-tl-lg">Tanggal</th>
                            <th class="px-6 py-4 text-left text-sm font-extrabold text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                            <th class="px-6 py-4 text-left text-sm font-extrabold text-gray-500 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-4 text-left text-sm font-extrabold text-gray-500 uppercase tracking-wider">Nominal</th>
                            <th class="px-6 py-4 text-center text-sm font-extrabold text-gray-500 uppercase tracking-wider rounded-tr-lg">Status Validasi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        
                        @forelse($transaksis as $trx)
                        <tr class="hover:bg-blue-50 transition duration-150">
                            <td class="px-6 py-5 whitespace-nowrap text-base text-gray-600">
                                {{ \Carbon\Carbon::parse($trx->tanggal_bayar)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-base font-bold text-gray-900">
                                {{ $trx->tagihan->siswa->nama_siswa ?? '-' }}
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-base text-gray-600">
                                {{ $trx->tagihan->kategori->nama_kategori ?? '-' }}
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-base text-gray-900 font-bold">
                                Rp {{ number_format($trx->nominal_bayar, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-center">
                                @if($trx->is_valid_kepala_sekolah)
                                    <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-green-100 text-green-700 shadow-sm">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Tersimpan di Arsip Digital
                                    </span>
                                @else
                                    <form action="{{ route('kepsek.validasi', $trx->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-5 rounded-lg text-xs transition shadow-sm">
                                            Validasi Laporan
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-base text-gray-400">
                                @if(request()->hasAny(['bulan', 'tahun', 'kategori_id', 'status_validasi']))
                                    Tidak ada transaksi lunas yang memenuhi kriteria filter.
                                @else
                                    Belum ada laporan transaksi lunas.
                                @endif
                            </td>
                        </tr>
                        @endforelse
                        
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>

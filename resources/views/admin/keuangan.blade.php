<x-app-layout>
    <x-slot name="header">Buku Kas Umum Sekolah</x-slot>

    <div class="space-y-6 mt-4">

        <!-- Flash Messages -->
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

        @php
            $totalMasuk = $catatans->where('tipe', 'masuk')->sum('nominal');
            $totalKeluar = $catatans->where('tipe', 'keluar')->sum('nominal');
            $saldoKas = $totalMasuk - $totalKeluar;
        @endphp

        <!-- Quick Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Pemasukan Kas</p>
                    <h3 class="text-2xl font-black text-emerald-600 mt-1">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</h3>
                </div>
                <div class="p-3.5 bg-emerald-50 text-emerald-600 rounded-2xl">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path></svg>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Pengeluaran Kas</p>
                    <h3 class="text-2xl font-black text-red-600 mt-1">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</h3>
                </div>
                <div class="p-3.5 bg-red-50 text-red-600 rounded-2xl">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path></svg>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Saldo Kas Bersih</p>
                    <h3 class="text-2xl font-black {{ $saldoKas >= 0 ? 'text-blue-600' : 'text-red-600' }} mt-1">Rp {{ number_format($saldoKas, 0, ',', '.') }}</h3>
                </div>
                <div class="p-3.5 bg-blue-50 text-blue-600 rounded-2xl">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Column (Form Inputs & PDF Export) - 5 Cols -->
            <div class="lg:col-span-5 space-y-6">
                
                <!-- Card 1: Form Catat Transaksi -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-6 text-white">
                        <div class="flex items-center space-x-3">
                            <div class="p-2.5 bg-white/20 rounded-xl backdrop-blur-sm">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold">Catat Transaksi Kas Baru</h3>
                                <p class="text-xs text-blue-100">Tambahkan pencatatan uang masuk atau pengeluaran</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('admin.kas.simpan') }}" method="POST" class="p-6 md:p-8 space-y-5">
                        @csrf
                        
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                Jenis Transaksi <span class="text-red-500">*</span>
                            </label>
                            <select name="tipe" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm font-bold py-3" required>
                                <option value="masuk" class="text-emerald-600 font-bold">🟢 Uang Masuk (Pemasukan Kas)</option>
                                <option value="keluar" class="text-red-600 font-bold">🔴 Uang Keluar (Pengeluaran Kas)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                Kategori / Keterangan Sumber <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10M7 11h10M7 15h10"></path></svg>
                                </div>
                                <input type="text" name="kategori" placeholder="Contoh: Infaq Mingguan, Dana BOS, Kebersihan" class="w-full pl-11 pr-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm font-semibold" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                Nominal (Rp) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400 font-bold text-sm">
                                    Rp
                                </div>
                                <input type="number" name="nominal" placeholder="Contoh: 250000" class="w-full pl-11 pr-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm font-semibold" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                Tanggal Catatan <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full py-3 px-4 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm font-semibold" required>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-extrabold py-3.5 px-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 text-sm flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            Simpan Catatan Kas
                        </button>
                    </form>
                </div>

                <!-- Card 2: Form Unduh PDF -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6 md:p-8 space-y-4">
                    <div class="flex items-center space-x-3 border-b pb-4">
                        <div class="p-2.5 bg-red-50 rounded-xl text-red-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-extrabold text-gray-900">Unduh Laporan Kas (PDF)</h3>
                            <p class="text-xs text-gray-500">Cetak rekapitulasi pembukuan kas berdasarkan rentang bulan</p>
                        </div>
                    </div>

                    <form action="{{ route('admin.kas.pdf') }}" method="GET" target="_blank" class="space-y-4">
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Dari Bulan</label>
                                <select name="bulan_mulai" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white text-xs font-semibold py-2.5">
                                    @foreach(['1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni', '7'=>'Juli', '8'=>'Agustus', '9'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember'] as $num => $name)
                                        <option value="{{ $num }}" {{ date('n') == $num ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Sampai Bulan</label>
                                <select name="bulan_selesai" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white text-xs font-semibold py-2.5">
                                    @foreach(['1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni', '7'=>'Juli', '8'=>'Agustus', '9'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember'] as $num => $name)
                                        <option value="{{ $num }}" {{ date('n') == $num ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Tahun Akademik</label>
                            <select name="tahun" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white text-xs font-semibold py-2.5">
                                <option value="2026" {{ date('Y') == '2026' ? 'selected' : '' }}>2026</option>
                                <option value="2025" {{ date('Y') == '2025' ? 'selected' : '' }}>2025</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl shadow-md transition flex items-center justify-center gap-2 text-xs uppercase tracking-wider">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Unduh PDF Buku Kas
                        </button>
                    </form>
                </div>

            </div>

            <!-- Right Column (Table Riwayat Kas) - 7 Cols -->
            <div class="lg:col-span-7 bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6 md:p-8 space-y-6">
                
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b gap-4">
                    <div>
                        <h3 class="text-lg font-extrabold text-gray-900">Riwayat Kas Sekolah</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Daftar transaksi kas keluar dan masuk yang tercatat</p>
                    </div>

                    <form action="{{ route('admin.kas') }}" method="GET" class="flex flex-wrap items-center gap-2">
                        <select name="bulan" class="rounded-xl border-gray-200 bg-gray-50 focus:bg-white text-xs font-semibold py-2 px-2.5">
                            <option value="">-- Semua Bulan --</option>
                            @foreach(['01'=>'Januari', '02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni', '07'=>'Juli', '08'=>'Agustus', '09'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember'] as $num => $name)
                                <option value="{{ $num }}" {{ request('bulan') == $num ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        <select name="tahun" class="rounded-xl border-gray-200 bg-gray-50 focus:bg-white text-xs font-semibold py-2 px-2.5">
                            <option value="">-- Tahun --</option>
                            <option value="2026" {{ request('tahun') == '2026' ? 'selected' : '' }}>2026</option>
                            <option value="2025" {{ request('tahun') == '2025' ? 'selected' : '' }}>2025</option>
                        </select>

                        <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-3 py-2 rounded-xl text-xs font-bold transition shadow-sm">
                            Filter
                        </button>
                        @if(request('bulan') || request('tahun'))
                            <a href="{{ route('admin.kas') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-2.5 py-2 rounded-xl text-xs font-bold transition">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3.5 text-left text-xs font-extrabold text-gray-500 uppercase tracking-wider rounded-tl-lg">Tanggal</th>
                                <th class="px-4 py-3.5 text-left text-xs font-extrabold text-gray-500 uppercase tracking-wider">Kategori / Keterangan</th>
                                <th class="px-4 py-3.5 text-right text-xs font-extrabold text-emerald-600 uppercase tracking-wider">Pemasukan (+)</th>
                                <th class="px-4 py-3.5 text-right text-xs font-extrabold text-red-600 uppercase tracking-wider rounded-tr-lg">Pengeluaran (-)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($catatans as $c)
                            <tr class="hover:bg-blue-50/50 transition">
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-semibold text-gray-600">
                                    {{ \Carbon\Carbon::parse($c->tanggal)->format('d M Y') }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ $c->kategori }}</div>
                                    <span class="inline-flex items-center text-[10px] font-extrabold px-2 py-0.5 rounded uppercase mt-0.5 {{ $c->tipe == 'masuk' ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700' }}">
                                        {{ $c->tipe == 'masuk' ? 'Uang Masuk' : 'Pengeluaran' }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-bold text-emerald-600 font-mono">
                                    @if($c->tipe == 'masuk')
                                        + Rp {{ number_format($c->nominal, 0, ',', '.') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-bold text-red-600 font-mono">
                                    @if($c->tipe == 'keluar')
                                        - Rp {{ number_format($c->nominal, 0, ',', '.') }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-sm text-gray-400">
                                    Belum ada pencatatan kas ditemukan pada periode ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

        </div>

    </div>
</x-app-layout>
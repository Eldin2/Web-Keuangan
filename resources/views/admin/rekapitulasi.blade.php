<x-app-layout>
    <x-slot name="header">Rekapitulasi Pembayaran</x-slot>

    <div class="grid grid-cols-1 xl:grid-cols-12 gap-8 mt-4 w-full">
        
        <div class="xl:col-span-12 bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-8">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-8 gap-4">
                <h3 class="text-xl font-extrabold text-gray-900">Rekap Pembayaran Berdasarkan Metode</h3>
                
                <form action="{{ route('admin.rekapitulasi') }}" method="GET" class="flex flex-wrap gap-2 p-2 bg-gray-50 rounded-xl border border-gray-200">
                    <select name="bulan" class="rounded-lg border-gray-300 text-sm focus:ring-blue-500 py-2">
                        <option value="">-- Semua Bulan --</option>
                        @foreach(['01'=>'Januari', '02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni', '07'=>'Juli', '08'=>'Agustus', '09'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember'] as $num => $name)
                            <option value="{{ $num }}" {{ request('bulan') == $num ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    <select name="tahun" class="rounded-lg border-gray-300 text-sm focus:ring-blue-500 py-2">
                        <option value="">-- Semua Tahun --</option>
                        <option value="2026" {{ request('tahun') == '2026' ? 'selected' : '' }}>2026</option>
                        <option value="2025" {{ request('tahun') == '2025' ? 'selected' : '' }}>2025</option>
                    </select>
                    
                    <button type="submit" class="bg-gray-800 text-white px-5 py-2 rounded-lg text-sm font-bold hover:bg-gray-900 transition shadow-sm">Filter</button>
                    @if(request('bulan') || request('tahun'))
                        <a href="{{ route('admin.rekapitulasi') }}" class="bg-red-100 text-red-600 px-4 py-2 rounded-lg text-sm font-bold hover:bg-red-200 transition flex items-center">Reset</a>
                    @endif
                    
                    <a href="{{ route('admin.rekapitulasi.pdf', ['bulan' => request('bulan'), 'tahun' => request('tahun')]) }}" target="_blank" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-blue-700 transition flex items-center shadow-sm ml-auto">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Unduh PDF
                    </a>
                </form>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- TABEL ONLINE -->
                <div>
                    <h4 class="text-lg font-bold text-blue-800 bg-blue-100 px-4 py-3 rounded-t-xl mb-0 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        Pembayaran Online (Transfer)
                        <span class="ml-auto bg-blue-600 text-white text-xs px-2 py-1 rounded-md">{{ $online->count() }} Data</span>
                    </h4>
                    <div class="border border-gray-200 border-t-0 rounded-b-xl overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Siswa</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase">Nominal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @php $totalOnline = 0; @endphp
                                @forelse($online as $o)
                                    @php $totalOnline += $o->nominal_bayar; @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-semibold">{{ $o->tagihan->siswa->nama_siswa }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($o->tanggal_bayar)->format('d M Y') }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-bold text-right">Rp {{ number_format($o->nominal_bayar, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-8 text-center text-gray-400 text-sm">Tidak ada transaksi online</td>
                                    </tr>
                                @endforelse
                                <tr class="bg-blue-50">
                                    <td colspan="2" class="px-4 py-4 text-sm font-black text-blue-900 text-right">TOTAL ONLINE:</td>
                                    <td class="px-4 py-4 text-sm font-black text-blue-900 text-right">Rp {{ number_format($totalOnline, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TABEL CASH -->
                <div>
                    <h4 class="text-lg font-bold text-green-800 bg-green-100 px-4 py-3 rounded-t-xl mb-0 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Pembayaran Tunai (Cash)
                        <span class="ml-auto bg-green-600 text-white text-xs px-2 py-1 rounded-md">{{ $cash->count() }} Data</span>
                    </h4>
                    <div class="border border-gray-200 border-t-0 rounded-b-xl overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Siswa</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Tanggal</th>
                                    <th class="px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase">Nominal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @php $totalCash = 0; @endphp
                                @forelse($cash as $c)
                                    @php $totalCash += $c->nominal_bayar; @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-semibold">{{ $c->tagihan->siswa->nama_siswa }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($c->tanggal_bayar)->format('d M Y') }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-bold text-right">Rp {{ number_format($c->nominal_bayar, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-8 text-center text-gray-400 text-sm">Tidak ada transaksi tunai</td>
                                    </tr>
                                @endforelse
                                <tr class="bg-green-50">
                                    <td colspan="2" class="px-4 py-4 text-sm font-black text-green-900 text-right">TOTAL CASH:</td>
                                    <td class="px-4 py-4 text-sm font-black text-green-900 text-right">Rp {{ number_format($totalCash, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- TOTAL KESELURUHAN -->
            <div class="mt-8 bg-gray-900 rounded-xl p-6 flex flex-col md:flex-row justify-between items-center shadow-lg">
                <div class="text-white mb-2 md:mb-0">
                    <h3 class="text-xl font-bold uppercase tracking-wider">Total Pembayaran Keseluruhan</h3>
                    <p class="text-gray-400 text-sm">Gabungan Online & Cash sesuai filter</p>
                </div>
                <div class="text-3xl font-black text-yellow-400">
                    Rp {{ number_format(($totalOnline ?? 0) + ($totalCash ?? 0), 0, ',', '.') }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

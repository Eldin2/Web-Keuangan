<x-app-layout>
    <x-slot name="header">Dashboard Admin - Ringkasan Sistem</x-slot>

    <!-- Session Feedback -->
    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative shadow-sm">
            <strong class="font-bold">Berhasil!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-xs font-bold text-gray-400 uppercase">Total Siswa</p>
            <p class="text-2xl font-black text-gray-800">{{ $stats['total_siswa'] }}</p>
        </div>
        <div class="bg-green-50 p-6 rounded-2xl shadow-sm border border-green-100">
            <p class="text-xs font-bold text-green-600 uppercase">Total Uang Masuk</p>
            <p class="text-2xl font-black text-green-700">Rp {{ number_format($stats['total_masuk'], 0, ',', '.') }}</p>
        </div>
        <div class="bg-red-50 p-6 rounded-2xl shadow-sm border border-red-100">
            <p class="text-xs font-bold text-red-600 uppercase">Total Pengeluaran</p>
            <p class="text-2xl font-black text-red-700">Rp {{ number_format($stats['total_keluar'], 0, ',', '.') }}</p>
        </div>
        <div class="bg-blue-50 p-6 rounded-2xl shadow-sm border border-blue-100">
            <p class="text-xs font-bold text-blue-600 uppercase">Belum Bayar</p>
            <p class="text-2xl font-black text-blue-700">{{ $stats['belum_bayar'] }}</p>
        </div>
        <div class="bg-yellow-50 p-6 rounded-2xl shadow-sm border border-yellow-100">
            <p class="text-xs font-bold text-yellow-600 uppercase">Perlu Verifikasi</p>
            <p class="text-2xl font-black text-yellow-700">{{ $stats['pending'] }}</p>
        </div>
    </div>

    <!-- ROW 1: Chart & Pending Verifications -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Grafik Perbandingan Kas Keseluruhan</h3>
            <div class="relative h-72 w-full">
                <canvas id="financeChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col h-full">
            <div class="flex items-center justify-between mb-4 border-b pb-2">
                <h3 class="text-lg font-bold text-gray-800 flex items-center">
                    <span class="w-2.5 h-2.5 bg-yellow-500 rounded-full mr-2 animate-pulse"></span>
                    Perlu Verifikasi
                </h3>
                <span class="px-2.5 py-0.5 bg-yellow-100 text-yellow-800 text-xs font-extrabold rounded-full">{{ $stats['pending'] }}</span>
            </div>
            
            <div class="flex-1 space-y-3 overflow-y-auto max-h-[16.5rem]">
                @forelse($pending_payments as $payment)
                    <div class="p-3 bg-gray-50 border border-gray-150 rounded-xl hover:shadow-sm transition">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-bold text-gray-900">{{ $payment->siswa->nama_siswa }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $payment->kategori->nama_kategori }}</p>
                            </div>
                            <span class="text-sm font-black text-gray-800">Rp {{ number_format($payment->nominal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between mt-3 pt-2 border-t border-gray-100">
                            <span class="text-[10px] uppercase font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded">
                                {{ $payment->transaksi->metode ?? 'Online' }}
                            </span>
                            <div class="flex gap-1.5">
                                <a href="{{ route('admin.verifikasi') }}" class="text-[11px] font-bold text-gray-600 bg-white hover:bg-gray-100 border border-gray-200 px-2.5 py-1 rounded-lg transition">
                                    Detail
                                </a>
                                <form action="{{ route('admin.verifikasi.setuju', $payment->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-[11px] font-bold text-white bg-green-600 hover:bg-green-700 px-2.5 py-1 rounded-lg transition shadow-sm">
                                        Setujui
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center h-full text-center py-6">
                        <svg class="w-12 h-12 text-green-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-sm font-bold text-gray-800">Semua Terverifikasi</p>
                        <p class="text-xs text-gray-400 mt-1">Tidak ada pembayaran pending saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    <!-- ROW 2: Recent Transactions & Quick Shortcuts -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
        <!-- Col-span 2: Riwayat Transaksi Terkini -->
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4 border-b pb-2">
                <h3 class="text-lg font-bold text-gray-800 flex items-center">
                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Aktivitas Transaksi Terbaru
                </h3>
                <a href="{{ route('admin.rekapitulasi') }}" class="text-xs font-bold text-blue-600 hover:underline">Lihat Semua</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-xs font-bold text-gray-400 uppercase border-b pb-2">
                            <th class="pb-2">Siswa & Kategori</th>
                            <th class="pb-2">Tanggal</th>
                            <th class="pb-2">Metode</th>
                            <th class="pb-2 text-right">Nominal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($recent_transactions as $tx)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="py-3">
                                    <div class="text-sm font-bold text-gray-800">
                                        {{ $tx->tagihan->siswa->nama_siswa ?? 'N/A' }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $tx->tagihan->kategori->nama_kategori ?? 'N/A' }}
                                    </div>
                                </td>
                                <td class="py-3 text-xs text-gray-500 font-semibold">
                                    {{ \Carbon\Carbon::parse($tx->tanggal_bayar)->format('d M Y') }}
                                </td>
                                <td class="py-3">
                                    <span class="px-2 py-0.5 text-xs font-bold rounded-full {{ $tx->metode === 'online' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($tx->metode) }}
                                    </span>
                                </td>
                                <td class="py-3 text-sm font-bold text-green-600 text-right font-mono">
                                    Rp {{ number_format($tx->nominal_bayar, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-sm text-gray-400">Belum ada transaksi tercatat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Col-span 1: Akses Cepat / Menu Pintasan -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-800 flex items-center mb-4 border-b pb-2">
                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    Pintasan Navigasi
                </h3>
                
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('admin.siswa') }}" class="p-3 bg-gray-50 border border-gray-100 hover:border-blue-300 hover:bg-blue-50/50 rounded-xl text-center transition flex flex-col items-center justify-center group shadow-sm">
                        <svg class="w-6 h-6 text-gray-600 group-hover:text-blue-600 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span class="text-xs font-bold text-gray-700 group-hover:text-blue-700">Data Siswa</span>
                    </a>
                    
                    <a href="{{ route('admin.akun_siswa') }}" class="p-3 bg-gray-50 border border-gray-100 hover:border-blue-300 hover:bg-blue-50/50 rounded-xl text-center transition flex flex-col items-center justify-center group shadow-sm">
                        <svg class="w-6 h-6 text-gray-600 group-hover:text-blue-600 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span class="text-xs font-bold text-gray-700 group-hover:text-blue-700">Akun Wali</span>
                    </a>

                    <a href="{{ route('admin.tagihan') }}" class="p-3 bg-gray-50 border border-gray-100 hover:border-blue-300 hover:bg-blue-50/50 rounded-xl text-center transition flex flex-col items-center justify-center group shadow-sm">
                        <svg class="w-6 h-6 text-gray-600 group-hover:text-blue-600 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span class="text-xs font-bold text-gray-700 group-hover:text-blue-700">Tagihan</span>
                    </a>

                    <a href="{{ route('admin.kas') }}" class="p-3 bg-gray-50 border border-gray-100 hover:border-blue-300 hover:bg-blue-50/50 rounded-xl text-center transition flex flex-col items-center justify-center group shadow-sm">
                        <svg class="w-6 h-6 text-gray-600 group-hover:text-blue-600 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="text-xs font-bold text-gray-700 group-hover:text-blue-700">Kas Sekolah</span>
                    </a>

                    <a href="{{ route('admin.guru.index') }}" class="p-3 bg-gray-50 border border-gray-100 hover:border-blue-300 hover:bg-blue-50/50 rounded-xl text-center transition flex flex-col items-center justify-center group shadow-sm">
                        <svg class="w-6 h-6 text-gray-600 group-hover:text-blue-600 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="text-xs font-bold text-gray-700 group-hover:text-blue-700">Data Guru</span>
                    </a>

                    <a href="{{ route('admin.gaji.index') }}" class="p-3 bg-gray-50 border border-gray-100 hover:border-blue-300 hover:bg-blue-50/50 rounded-xl text-center transition flex flex-col items-center justify-center group shadow-sm">
                        <svg class="w-6 h-6 text-gray-600 group-hover:text-blue-600 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <span class="text-xs font-bold text-gray-700 group-hover:text-blue-700">Gaji Guru</span>
                    </a>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between text-xs text-gray-400 font-semibold">
                <span>Waktu Server:</span>
                <span>{{ now()->format('d M Y, H:i') }}</span>
            </div>
        </div>
    </div>

    <!-- Chart Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('financeChart').getContext('2d');
            
            const totalMasuk = {{ $stats['total_masuk'] }};
            const totalKeluar = {{ $stats['total_keluar'] }};

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Total Uang Masuk', 'Total Uang Keluar'],
                    datasets: [{
                        label: 'Nominal Rupiah (Rp)',
                        data: [totalMasuk, totalKeluar],
                        backgroundColor: [
                            'rgba(34, 197, 94, 0.85)',
                            'rgba(239, 68, 68, 0.85)'
                        ],
                        borderColor: [
                            'rgb(21, 128, 61)',
                            'rgb(185, 28, 28)'
                        ],
                        borderWidth: 1,
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">Rincian Slip Gaji Guru</x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        
        <!-- Header Actions Toolbar -->
        <div class="flex items-center justify-between bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
            <a href="{{ route('admin.gaji.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded-xl text-xs transition">
                &larr; Kembali ke Riwayat
            </a>
            
            <div class="flex gap-2">
                <a href="{{ route('admin.gaji.pdf', $slip->id) }}" target="_blank" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-xl text-xs transition shadow-sm flex items-center">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak / Download PDF
                </a>
            </div>
        </div>

        <!-- Salary Slip Card (Dashboard Printable layout) -->
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 space-y-8" id="slip-card">
            
            <!-- School logo and slip title -->
            <div class="flex flex-col md:flex-row md:items-center justify-between border-b pb-6 gap-4">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('logo.png') }}" alt="Logo" class="h-16 w-16 object-contain bg-gray-50 rounded-full p-1 border">
                    <div>
                        <h2 class="text-xl font-black text-gray-800 tracking-wide">TK IT INSAN CENDIKIA</h2>
                        <p class="text-xs text-gray-500 font-medium">Jalan Insan Cendikia, Jakarta</p>
                    </div>
                </div>
                <div class="text-left md:text-right">
                    <h3 class="text-lg font-black text-blue-700 uppercase tracking-widest">SLIP GAJI GURU</h3>
                    <p class="text-xs text-gray-400 font-mono mt-1">Ref No: #SG-{{ str_pad($slip->id, 5, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>

            <!-- Employee & Period Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-6 rounded-2xl border border-gray-100">
                <div>
                    <h4 class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider mb-2">IDENTITAS PENERIMA</h4>
                    <table class="w-full text-sm">
                        <tr>
                            <td class="text-gray-500 py-1 pr-4 w-28">Nama Guru</td>
                            <td class="text-gray-800 font-bold py-1">: {{ $slip->guru->nama_guru }}</td>
                        </tr>
                        <tr>
                            <td class="text-gray-500 py-1 pr-4">NIP</td>
                            <td class="text-gray-800 font-medium py-1">: {{ $slip->guru->nip ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-gray-500 py-1 pr-4">Jabatan</td>
                            <td class="text-gray-800 font-medium py-1">: {{ $slip->guru->jabatan }}</td>
                        </tr>
                        <tr>
                            <td class="text-gray-500 py-1 pr-4">Status Kerja</td>
                            <td class="text-gray-800 font-medium py-1">: {{ $slip->guru->status }}</td>
                        </tr>
                    </table>
                </div>
                <div>
                    <h4 class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider mb-2">PERIODE & TRANSAKSI</h4>
                    <table class="w-full text-sm">
                        <tr>
                            <td class="text-gray-500 py-1 pr-4 w-28">Periode Bulan</td>
                            <td class="text-gray-800 font-bold py-1">: {{ $bulanNama }} {{ $slip->tahun }}</td>
                        </tr>
                        <tr>
                            <td class="text-gray-500 py-1 pr-4">Tanggal Bayar</td>
                            <td class="text-gray-800 font-medium py-1">: {{ \Carbon\Carbon::parse($slip->tanggal_dibayar)->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <td class="text-gray-500 py-1 pr-4">Status Bayar</td>
                            <td class="py-1">: 
                                <span class="px-2 py-0.5 text-[10px] font-bold rounded-full {{ $slip->status_pembayaran === 'dibayar' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $slip->status_pembayaran === 'dibayar' ? 'LUNAS / DIBAYAR' : 'PENDING' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-gray-500 py-1 pr-4">Keterangan</td>
                            <td class="text-gray-800 font-medium py-1 italic">: {{ $slip->keterangan ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Simple Breakdown Table -->
            <div class="max-w-md mx-auto space-y-4 bg-gray-50/50 p-6 rounded-2xl border border-gray-100">
                <h4 class="text-xs font-black text-gray-700 uppercase tracking-widest border-b pb-2 text-center">
                    RINCIAN GAJI
                </h4>
                
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between py-1 border-b border-gray-100">
                        <span class="text-gray-600 font-semibold">Gaji Pokok / Bulanan</span>
                        <span class="font-mono font-bold text-gray-800">Rp {{ number_format($slip->nominal_gaji, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-gray-100">
                        <span class="text-gray-600 font-semibold">Potongan</span>
                        <span class="font-mono font-bold text-red-600">Rp {{ number_format($slip->potongan, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-blue-700 to-indigo-800 p-4 rounded-xl text-white flex justify-between items-center text-sm border border-blue-800 mt-4 shadow-sm">
                    <div class="font-bold text-xs uppercase tracking-wider text-blue-200">Total Diterima (Gaji Bersih)</div>
                    <div class="font-mono font-black text-lg text-green-300">Rp {{ number_format($slip->total_gaji, 0, ',', '.') }}</div>
                </div>
            </div>

            <!-- Signatures Section -->
            <div class="grid grid-cols-2 gap-12 mt-12 pt-8 border-t border-gray-100 text-center text-sm">
                <div>
                    <p class="text-gray-500">Penerima,</p>
                    <div class="h-20"></div>
                    <p class="font-bold text-gray-800 underline">{{ $slip->guru->nama_guru }}</p>
                    <p class="text-xs text-gray-400">Tenaga Pendidik</p>
                </div>
                <div>
                    <p class="text-gray-500">Mengetahui,</p>
                    <div class="h-20"></div>
                    <p class="font-bold text-gray-800 underline">Bendahara Sekolah</p>
                    <p class="text-xs text-gray-400">TK IT INSAN CENDIKIA</p>
                </div>
            </div>

        </div>

    </div>
</x-app-layout>

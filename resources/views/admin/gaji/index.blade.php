<x-app-layout>
    <x-slot name="header">Kelola Transaksi & Riwayat Gaji Guru</x-slot>

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

    <!-- Toolbar / Filters & Actions -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b pb-4 mb-4">
            <div>
                <h3 class="text-lg font-bold text-gray-900">Riwayat Penggajian Guru</h3>
                <p class="text-xs text-gray-400 mt-0.5">Filter data slip gaji yang sudah diterbitkan</p>
            </div>
            
            <a href="{{ route('admin.gaji.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-xl shadow-sm transition flex items-center justify-center text-sm">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Buat Slip Gaji Baru
            </a>
        </div>

        <form action="{{ route('admin.gaji.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <!-- Filter Guru -->
            <div>
                <label class="block text-xs font-bold text-gray-500 mb-1">Tenaga Pengajar</label>
                <select name="guru_id" class="w-full rounded-lg border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 transition py-2 px-3 text-xs">
                    <option value="">-- Semua Guru --</option>
                    @foreach($gurus as $g)
                        <option value="{{ $g->id }}" {{ request('guru_id') == $g->id ? 'selected' : '' }}>{{ $g->nama_guru }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Bulan -->
            <div>
                <label class="block text-xs font-bold text-gray-500 mb-1">Bulan</label>
                <select name="bulan" class="w-full rounded-lg border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 transition py-2 px-3 text-xs">
                    <option value="">-- Semua Bulan --</option>
                    @php
                        $bulanList = [
                            1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 
                            5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus', 
                            9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'
                        ];
                    @endphp
                    @foreach($bulanList as $k => $v)
                        <option value="{{ $k }}" {{ request('bulan') == $k ? 'selected' : '' }}>{{ $v }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Tahun -->
            <div>
                <label class="block text-xs font-bold text-gray-500 mb-1">Tahun</label>
                <select name="tahun" class="w-full rounded-lg border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 transition py-2 px-3 text-xs">
                    <option value="">-- Semua Tahun --</option>
                    @for($y = date('Y') - 3; $y <= date('Y') + 2; $y++)
                        <option value="{{ $y }}" {{ request('tahun', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-4 rounded-lg text-xs transition shadow-sm flex-1 h-9">
                    Terapkan Filter
                </button>
                @if(request('guru_id') || request('bulan') || request('tahun'))
                    <a href="{{ route('admin.gaji.index') }}" class="bg-red-50 hover:bg-red-100 text-red-600 font-bold py-2 px-3 rounded-lg text-xs transition flex items-center justify-center h-9">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table of generated salary slips -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-250">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider rounded-l-lg">Guru</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Periode</th>
                        <th class="px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Gaji Kotor</th>
                        <th class="px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Potongan</th>
                        <th class="px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Gaji Bersih</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider rounded-r-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-150">
                    @forelse($slips as $slip)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900">{{ $slip->guru->nama_guru }}</div>
                                <div class="text-xs text-gray-400">NIP: {{ $slip->guru->nip ?? '-' }}</div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-700">
                                    {{ $bulanList[$slip->bulan] ?? '' }} {{ $slip->tahun }}
                                </div>
                                <div class="text-[10px] text-gray-400 font-medium">Dibayar: {{ \Carbon\Carbon::parse($slip->tanggal_dibayar)->format('d M Y') }}</div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-bold text-gray-800 font-mono">
                                Rp {{ number_format($slip->nominal_gaji, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-bold text-red-600 font-mono">
                                Rp {{ number_format($slip->potongan, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-black text-green-600 font-mono">
                                Rp {{ number_format($slip->total_gaji, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-center">
                                <span class="px-2.5 py-1 text-[10px] uppercase font-bold rounded-full {{ $slip->status_pembayaran === 'dibayar' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-yellow-100 text-yellow-800 border border-yellow-200' }}">
                                    {{ $slip->status_pembayaran === 'dibayar' ? 'Lunas / Dibayar' : 'Tertunda' }}
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-center text-xs font-semibold">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('admin.gaji.show', $slip->id) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 py-1.5 px-3 rounded-lg transition" title="Lihat Detail Slip">
                                        Detail
                                    </a>
                                    <a href="{{ route('admin.gaji.pdf', $slip->id) }}" target="_blank" class="bg-green-50 hover:bg-green-100 text-green-700 py-1.5 px-3 rounded-lg transition flex items-center">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                        PDF
                                    </a>
                                    <form id="delete-gaji-{{ $slip->id }}" action="{{ route('admin.gaji.destroy', $slip->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDeleteGaji('{{ $slip->id }}', '{{ addslashes($slip->guru->nama_guru) }}', '{{ $bulanList[$slip->bulan] ?? '' }} {{ $slip->tahun }}')" class="bg-red-50 hover:bg-red-100 text-red-700 py-1.5 px-3 rounded-lg transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center text-sm text-gray-400">Belum ada slip gaji yang dibuat pada periode ini. Silakan klik tombol "Buat Slip Gaji Baru".</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- SweetAlert2 Centered Confirmation Modal -->
    <script>
        function confirmDeleteGaji(id, nama, periode) {
            Swal.fire({
                title: 'Hapus Slip Gaji Guru?',
                text: 'Apakah Anda yakin ingin menghapus slip gaji periode ' + periode + ' untuk ' + nama + '? Transaksi pengeluaran kas terkait juga akan dihapus!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus Slip Gaji',
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
                    document.getElementById('delete-gaji-' + id).submit();
                }
            });
        }
    </script>
</x-app-layout>

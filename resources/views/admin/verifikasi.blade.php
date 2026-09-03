<x-app-layout>
    <x-slot name="header">Verifikasi Pembayaran Siswa</x-slot>

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

        <!-- Quick Statistics Row -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Pembayaran In-App</p>
                    <h3 class="text-2xl font-black text-gray-900 mt-1">{{ $tagihans->count() }}</h3>
                </div>
                <div class="p-3 bg-blue-50 text-blue-600 rounded-2xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Menunggu Konfirmasi</p>
                    <h3 class="text-2xl font-black text-amber-600 mt-1">{{ $tagihans->where('status', 'proses_verifikasi')->count() }}</h3>
                </div>
                <div class="p-3 bg-amber-50 text-amber-600 rounded-2xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Dikonfirmasi Lunas</p>
                    <h3 class="text-2xl font-black text-emerald-600 mt-1">{{ $tagihans->where('status', 'lunas')->count() }}</h3>
                </div>
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Ditolak (Salah Nominal)</p>
                    <h3 class="text-2xl font-black text-red-600 mt-1">{{ $tagihans->where('status', 'salah_nominal')->count() }}</h3>
                </div>
                <div class="p-3 bg-red-50 text-red-600 rounded-2xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6 md:p-8 space-y-6">
            
            <!-- Table Header & Filter Bar -->
            <div class="flex flex-col md:flex-row md:items-center justify-between pb-4 border-b gap-4">
                <div>
                    <h3 class="text-lg font-extrabold text-gray-900">Validasi & Verifikasi Bukti Pembayaran</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Periksa keabsahan transfer dan setujui atau tolak pembayaran siswa</p>
                </div>
                
                <!-- Filter Tabs -->
                <div class="flex items-center space-x-1.5 bg-gray-100 p-1.5 rounded-xl border border-gray-200 text-xs font-bold">
                    <a href="{{ route('admin.verifikasi') }}" class="px-3 py-1.5 rounded-lg transition {{ !request('status') ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                        Semua Status
                    </a>
                    <a href="{{ route('admin.verifikasi', ['status' => 'proses_verifikasi']) }}" class="px-3 py-1.5 rounded-lg transition {{ request('status') == 'proses_verifikasi' ? 'bg-amber-500 text-white shadow-sm' : 'text-amber-700 hover:text-amber-900' }}">
                        Menunggu
                    </a>
                    <a href="{{ route('admin.verifikasi', ['status' => 'lunas']) }}" class="px-3 py-1.5 rounded-lg transition {{ request('status') == 'lunas' ? 'bg-emerald-600 text-white shadow-sm' : 'text-emerald-700 hover:text-emerald-900' }}">
                        Lunas
                    </a>
                    <a href="{{ route('admin.verifikasi', ['status' => 'salah_nominal']) }}" class="px-3 py-1.5 rounded-lg transition {{ request('status') == 'salah_nominal' ? 'bg-red-600 text-white shadow-sm' : 'text-red-700 hover:text-red-900' }}">
                        Salah Nominal
                    </a>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-5 py-4 text-left text-xs font-extrabold text-gray-500 uppercase tracking-wider rounded-tl-lg">Tanggal Bayar</th>
                            <th class="px-5 py-4 text-left text-xs font-extrabold text-gray-500 uppercase tracking-wider">Siswa & Kategori</th>
                            <th class="px-5 py-4 text-left text-xs font-extrabold text-gray-500 uppercase tracking-wider">Nominal Tagihan</th>
                            <th class="px-5 py-4 text-left text-xs font-extrabold text-gray-500 uppercase tracking-wider">Bukti Struk Transfer</th>
                            <th class="px-5 py-4 text-center text-xs font-extrabold text-gray-500 uppercase tracking-wider">Status Validasi</th>
                            <th class="px-5 py-4 text-center text-xs font-extrabold text-gray-500 uppercase tracking-wider rounded-tr-lg">Aksi Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($tagihans as $t)
                        <tr class="hover:bg-blue-50/50 transition">
                            <td class="px-5 py-4 whitespace-nowrap text-sm font-semibold text-gray-600">
                                @if($t->transaksi && $t->transaksi->tanggal_bayar)
                                    {{ \Carbon\Carbon::parse($t->transaksi->tanggal_bayar)->format('d M Y, H:i') }}
                                @else
                                    {{ $t->updated_at->format('d M Y') }}
                                @endif
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900">{{ $t->siswa->nama_siswa ?? 'Siswa Dihapus' }}</div>
                                <div class="flex items-center space-x-2 mt-0.5">
                                    <span class="px-2 py-0.5 bg-blue-50 text-blue-700 text-xs font-bold rounded-md">Kelas {{ $t->siswa->kelas ?? '-' }}</span>
                                    <span class="text-xs text-gray-500 font-medium">{{ $t->kategori->nama_kategori ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap text-sm font-extrabold text-gray-900 font-mono">
                                Rp {{ number_format($t->nominal, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap text-sm">
                                @if($t->transaksi && $t->transaksi->bukti_bayar)
                                    @if(str_contains($t->transaksi->bukti_bayar, 'Tunai') || str_contains($t->transaksi->bukti_bayar, 'Loket'))
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-gray-100 text-gray-600">
                                            💵 Pembayaran Tunai
                                        </span>
                                    @else
                                        <a href="{{ asset('storage/' . $t->transaksi->bukti_bayar) }}" target="_blank" class="inline-flex items-center text-xs font-extrabold text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg border border-blue-100 transition">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            Lihat Struk
                                        </a>
                                    @endif
                                @else
                                    <span class="text-xs text-gray-400 italic">Belum ada file</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap text-center text-xs">
                                @if($t->status == 'proses_verifikasi')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200 animate-pulse">
                                        <span class="w-2 h-2 rounded-full bg-amber-500 mr-1.5"></span> Menunggu Konfirmasi
                                    </span>
                                @elseif($t->status == 'lunas')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <svg class="w-3.5 h-3.5 mr-1 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Dikonfirmasi Lunas
                                    </span>
                                @elseif($t->status == 'salah_nominal')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-200">
                                        <svg class="w-3.5 h-3.5 mr-1 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                        Salah Nominal (Ditolak)
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap text-center text-xs">
                                <div class="flex items-center justify-center space-x-2">
                                    
                                    @if($t->status == 'proses_verifikasi')
                                        <!-- Form Konfirmasi Lunas -->
                                        <form id="form-setuju-{{ $t->id }}" action="{{ route('admin.verifikasi.setuju', $t->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="button" onclick="confirmSetuju('{{ $t->id }}', '{{ addslashes($t->siswa->nama_siswa ?? '-') }}', '{{ addslashes($t->kategori->nama_kategori ?? '-') }}', '{{ number_format($t->nominal, 0, ',', '.') }}')" class="inline-flex items-center bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-1.5 px-3 rounded-xl text-xs transition shadow-sm">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                Konfirmasi Lunas
                                            </button>
                                        </form>

                                        <!-- Form Tolak (Salah Nominal) -->
                                        <form id="form-tolak-{{ $t->id }}" action="{{ route('admin.verifikasi.tolak', $t->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="button" onclick="confirmTolak('{{ $t->id }}', '{{ addslashes($t->siswa->nama_siswa ?? '-') }}', '{{ addslashes($t->kategori->nama_kategori ?? '-') }}', '{{ number_format($t->nominal, 0, ',', '.') }}')" class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white font-bold py-1.5 px-3 rounded-xl text-xs transition shadow-sm">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                Tolak (Salah Nominal)
                                            </button>
                                        </form>

                                    @elseif($t->status == 'lunas')
                                        <a href="{{ route('admin.cetak', $t->id) }}" target="_blank" class="inline-flex items-center bg-gray-800 hover:bg-black text-white font-bold py-1.5 px-3 rounded-xl text-xs transition shadow-sm">
                                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H7a2 2 0 00-2 2v4h10z"></path></svg>
                                            Cetak Struk
                                        </a>
                                        <form id="form-tolak-{{ $t->id }}" action="{{ route('admin.verifikasi.tolak', $t->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="button" onclick="confirmTolak('{{ $t->id }}', '{{ addslashes($t->siswa->nama_siswa ?? '-') }}', '{{ addslashes($t->kategori->nama_kategori ?? '-') }}', '{{ number_format($t->nominal, 0, ',', '.') }}')" class="inline-flex items-center bg-red-100 hover:bg-red-200 text-red-700 font-bold py-1.5 px-2.5 rounded-xl text-xs transition">
                                                Ubah ke Salah Nominal
                                            </button>
                                        </form>

                                    @elseif($t->status == 'salah_nominal')
                                        <form id="form-setuju-{{ $t->id }}" action="{{ route('admin.verifikasi.setuju', $t->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="button" onclick="confirmSetuju('{{ $t->id }}', '{{ addslashes($t->siswa->nama_siswa ?? '-') }}', '{{ addslashes($t->kategori->nama_kategori ?? '-') }}', '{{ number_format($t->nominal, 0, ',', '.') }}')" class="inline-flex items-center bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-1.5 px-3 rounded-xl text-xs transition shadow-sm">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                Setujui Lunas
                                            </button>
                                        </form>
                                    @endif

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-400">
                                Tidak ada data pembayaran verifikasi ditemukan saat ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <!-- SweetAlert2 Scripts -->
    <script>
        function confirmSetuju(id, nama, kategori, nominal) {
            Swal.fire({
                title: 'Konfirmasi Pembayaran Lunas',
                text: 'Apakah Anda yakin ingin mengonfirmasi LUNAS pembayaran "' + kategori + '" (Rp ' + nominal + ') untuk siswa ' + nama + '?',
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Setujui Lunas',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-3xl p-6 shadow-2xl border border-gray-100',
                    title: 'text-xl font-extrabold text-gray-900',
                    confirmButton: 'bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-5 py-2.5 rounded-xl shadow-sm text-sm',
                    cancelButton: 'bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold px-5 py-2.5 rounded-xl text-sm mr-2'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-setuju-' + id).submit();
                }
            });
        }

        function confirmTolak(id, nama, kategori, nominal) {
            Swal.fire({
                title: 'Tolak Pembayaran (Salah Nominal)?',
                text: 'Status tagihan "' + kategori + '" (Rp ' + nominal + ') milik ' + nama + ' akan diubah menjadi "Salah Nominal". Orang tua dapat mengirimkan ulang bukti bayar.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Tolak Pembayaran',
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
                    document.getElementById('form-tolak-' + id).submit();
                }
            });
        }
    </script>
</x-app-layout>
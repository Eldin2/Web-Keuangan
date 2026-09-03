<x-app-layout>
    <x-slot name="header">Kelola Tagihan Keuangan</x-slot>

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

        @if ($errors->any())
            <div class="p-4 bg-red-50 border-l-4 border-red-500 rounded-r-2xl shadow-sm">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-sm font-bold text-red-800">Terjadi Kesalahan Form Input:</p>
                </div>
                <ul class="list-disc pl-8 text-xs text-red-700 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Quick Statistics Row -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Tagihan</p>
                    <h3 class="text-2xl font-black text-gray-900 mt-1">{{ $tagihans->count() }}</h3>
                </div>
                <div class="p-3 bg-blue-50 text-blue-600 rounded-2xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Belum Bayar</p>
                    <h3 class="text-2xl font-black text-red-600 mt-1">{{ $tagihans->where('status', 'belum_bayar')->count() }}</h3>
                </div>
                <div class="p-3 bg-red-50 text-red-600 rounded-2xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Proses Verifikasi</p>
                    <h3 class="text-2xl font-black text-amber-600 mt-1">{{ $tagihans->where('status', 'proses_verifikasi')->count() }}</h3>
                </div>
                <div class="p-3 bg-amber-50 text-amber-600 rounded-2xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Tagihan Lunas</p>
                    <h3 class="text-2xl font-black text-emerald-600 mt-1">{{ $tagihans->where('status', 'lunas')->count() }}</h3>
                </div>
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Form Input Tagihan Baru (Left Column: 5 Cols) -->
            <div class="lg:col-span-5 bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-6 text-white">
                    <div class="flex items-center space-x-3">
                        <div class="p-2.5 bg-white/20 rounded-xl backdrop-blur-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold">Buat Tagihan Baru</h3>
                            <p class="text-xs text-blue-100">Terbitkan tagihan baru untuk individu atau seluruh siswa</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.tagihan.store') }}" method="POST" class="p-6 md:p-8 space-y-5">
                    @csrf
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Pilih Siswa <span class="text-red-500">*</span>
                        </label>
                        <select name="siswa_id" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm font-medium py-3" required>
                            <option value="">-- Pilih Siswa Penerima --</option>
                            <option value="semua" class="font-extrabold text-blue-600">📢 -- SEMUA SISWA TERDAFTAR --</option>
                            @foreach($siswas as $s)
                                <option value="{{ $s->id }}">👦 {{ $s->nama_siswa }} (Kelas {{ $s->kelas }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Kategori Tagihan <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10M7 11h10M7 15h10"></path></svg>
                            </div>
                            <input type="text" name="nama_kategori" placeholder="Contoh: SPP Agustus 2026 / Uang Buku" class="w-full pl-11 pr-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm font-semibold" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Nominal Tagihan (Rp) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400 font-bold text-sm">
                                Rp
                            </div>
                            <input type="number" name="nominal" placeholder="Contoh: 150000" class="w-full pl-11 pr-4 py-3 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition text-sm font-semibold" required>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-extrabold py-3.5 px-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 text-sm flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Buat & Terbitkan Tagihan
                    </button>
                </form>
            </div>

            <!-- Tabel Daftar Tagihan (Right Column: 7 Cols) -->
            <div class="lg:col-span-7 bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6 md:p-8 space-y-6">
                
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b gap-4">
                    <div>
                        <h3 class="text-lg font-extrabold text-gray-900">Daftar Tagihan Berjalan</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Kelola status pembayaran dan hapus tagihan jika diperlukan</p>
                    </div>
                    
                    <form action="{{ route('admin.tagihan') }}" method="GET" class="flex flex-wrap items-center gap-2">
                        <select name="siswa_id" class="rounded-xl border-gray-200 bg-gray-50 focus:bg-white text-xs font-semibold py-2 px-2.5">
                            <option value="">-- Semua Siswa --</option>
                            @foreach($siswas as $s)
                                <option value="{{ $s->id }}" {{ request('siswa_id') == $s->id ? 'selected' : '' }}>{{ $s->nama_siswa }}</option>
                            @endforeach
                        </select>
                        <select name="bulan" class="rounded-xl border-gray-200 bg-gray-50 focus:bg-white text-xs font-semibold py-2 px-2.5">
                            <option value="">-- Bulan --</option>
                            @foreach(['01'=>'Jan', '02'=>'Feb', '03'=>'Mar', '04'=>'Apr', '05'=>'Mei', '06'=>'Jun', '07'=>'Jul', '08'=>'Agu', '09'=>'Sep', '10'=>'Okt', '11'=>'Nov', '12'=>'Des'] as $num => $name)
                                <option value="{{ $num }}" {{ request('bulan') == $num ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-3 py-2 rounded-xl text-xs font-bold transition shadow-sm">
                            Cari
                        </button>
                        @if(request('bulan') || request('tahun') || request('siswa_id'))
                            <a href="{{ route('admin.tagihan') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-2.5 py-2 rounded-xl text-xs font-bold transition">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3.5 text-left text-xs font-extrabold text-gray-500 uppercase tracking-wider rounded-tl-lg">Siswa</th>
                                <th class="px-4 py-3.5 text-left text-xs font-extrabold text-gray-500 uppercase tracking-wider">Kategori</th>
                                <th class="px-4 py-3.5 text-left text-xs font-extrabold text-gray-500 uppercase tracking-wider">Nominal</th>
                                <th class="px-4 py-3.5 text-left text-xs font-extrabold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3.5 text-center text-xs font-extrabold text-gray-500 uppercase tracking-wider rounded-tr-lg">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($tagihans as $t)
                            <tr class="hover:bg-blue-50/50 transition">
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                    {{ $t->siswa->nama_siswa ?? 'Siswa Dihapus' }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600 font-medium">
                                    {{ $t->kategori->nama_kategori ?? '-' }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-bold text-gray-900 font-mono">
                                    Rp {{ number_format($t->nominal, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-xs">
                                    @if($t->status == 'lunas')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> LUNAS
                                        </span>
                                    @elseif($t->status == 'proses_verifikasi')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5"></span> PROSES ONLINE
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></span> BELUM BAYAR
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-center">
                                    <div class="flex items-center justify-center space-x-1.5">
                                        @if($t->status == 'lunas')
                                            <a href="{{ route('admin.cetak', $t->id) }}" target="_blank" class="inline-flex items-center bg-gray-800 hover:bg-black text-white font-bold py-1.5 px-3 rounded-lg text-xs transition shadow-sm" title="Cetak Struk Pembayaran">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H7a2 2 0 00-2 2v4h10z"></path></svg>
                                                Struk
                                            </a>
                                        @elseif($t->status == 'belum_bayar')
                                            <form id="cash-form-{{ $t->id }}" action="{{ route('admin.tagihan.bayar_offline', $t->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="button" onclick="confirmBayarTunai('{{ $t->id }}', '{{ addslashes($t->siswa->nama_siswa ?? '-') }}', '{{ number_format($t->nominal, 0, ',', '.') }}')" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-1.5 px-2.5 rounded-lg text-xs transition shadow-sm" title="Terima Pembayaran Tunai">
                                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                                    Tunai
                                                </button>
                                            </form>
                                        @endif

                                        <!-- Hapus Tagihan Button -->
                                        <form id="delete-tagihan-{{ $t->id }}" action="{{ route('admin.tagihan.destroy', $t->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDeleteTagihan('{{ $t->id }}', '{{ addslashes($t->siswa->nama_siswa ?? '-') }}', '{{ addslashes($t->kategori->nama_kategori ?? '-') }}', '{{ number_format($t->nominal, 0, ',', '.') }}')" class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white font-bold py-1.5 px-2.5 rounded-lg text-xs transition shadow-sm" title="Hapus Tagihan">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-400">
                                    Belum ada data tagihan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

        </div>

    </div>

    <script>
        function confirmBayarTunai(id, nama, nominal) {
            Swal.fire({
                title: 'Konfirmasi Terima Pembayaran Tunai',
                text: 'Apakah Anda menerima pembayaran tunai sebesar Rp ' + nominal + ' dari siswa ' + nama + '?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Terima Tunai',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-3xl p-6 shadow-2xl border border-gray-100',
                    title: 'text-xl font-extrabold text-gray-900',
                    confirmButton: 'bg-blue-600 hover:bg-blue-700 text-white font-bold px-5 py-2.5 rounded-xl shadow-sm text-sm',
                    cancelButton: 'bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold px-5 py-2.5 rounded-xl text-sm mr-2'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('cash-form-' + id).submit();
                }
            });
        }

        function confirmDeleteTagihan(id, nama, kategori, nominal) {
            Swal.fire({
                title: 'Hapus Tagihan Keuangan?',
                text: 'Apakah Anda yakin ingin menghapus tagihan "' + kategori + '" (Rp ' + nominal + ') milik ' + nama + '? Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus Tagihan',
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
                    document.getElementById('delete-tagihan-' + id).submit();
                }
            });
        }
    </script>
</x-app-layout>
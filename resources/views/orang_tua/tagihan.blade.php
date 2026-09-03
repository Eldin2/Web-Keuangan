<x-app-layout>
    <x-slot name="header">Portal Orang Tua - Tagihan Saya & Pembayaran</x-slot>

    <div class="space-y-8 mt-4">

        <div class="flex flex-col lg:flex-row gap-6 w-full">
            
            <!-- Tujuan Transfer Box -->
            <div class="w-full lg:w-1/3 bg-gradient-to-br from-blue-700 to-blue-900 rounded-2xl shadow-lg p-6 md:p-8 text-white flex flex-col relative overflow-hidden transform transition-all hover:scale-[1.01]">
                
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl"></div>
                
                <div class="relative z-10 flex flex-col h-full justify-between">
                    <div>
                        <div class="flex items-center gap-4 mb-6 border-b border-white/20 pb-4">
                            <div class="bg-white/20 p-3 rounded-full backdrop-blur-sm shadow-inner inline-flex">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                            </div>
                            <h4 class="text-blue-100 font-bold text-sm uppercase tracking-wider leading-tight">Tujuan Transfer<br>Pembayaran</h4>
                        </div>
                        
                        <div class="mb-8">
                            <p class="text-3xl font-extrabold tracking-widest drop-shadow-md mb-2">{{ \App\Models\Setting::get('norek_bank_name', 'BRI') }}</p>
                            <p class="text-3xl lg:text-4xl font-black tracking-widest drop-shadow-lg mb-3 text-yellow-300">{{ \App\Models\Setting::get('norek_number', '111 111 1111') }}</p>
                            <p class="text-sm font-bold text-blue-50 uppercase tracking-wider">a.n. {{ \App\Models\Setting::get('norek_owner', 'TK IT INSAN CENDIKIA') }}</p>
                        </div>
                    </div>
                    
                    <div class="bg-black/20 p-4 rounded-xl border border-white/10 shadow-inner">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-yellow-300 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div>
                                <p class="text-xs text-blue-100 mb-0.5">Peringatan Penting</p>
                                <p class="text-sm font-bold tracking-wide">Simpan & unggah bukti transfer untuk divalidasi.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upload Bukti Bayar Form -->
            <div class="w-full lg:w-2/3 bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-center">
                <h3 class="text-xl font-bold mb-6 text-gray-900 border-b pb-3">Upload Bukti Bayar</h3>
                
                @if(session('success'))
                    <div class="mb-5 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative">
                        <strong class="font-bold">Berhasil!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-5 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative">
                        <strong class="font-bold">Upload Gagal!</strong>
                        <ul class="list-disc mt-1 ml-4 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('orangtua.bayar') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Tagihan (Bisa Lebih Dari Satu)</label>
                        <div class="space-y-3 bg-gray-50 p-4 rounded-xl border border-gray-200 max-h-60 overflow-y-auto">
                            @php $ada_tagihan = false; @endphp
                            @php $ada_tagihan = false; @endphp
                            @foreach($tagihan_aktif as $t)
                                @if(in_array($t->status, ['belum_bayar', 'salah_nominal']))
                                    @php $ada_tagihan = true; @endphp
                                    <label class="flex items-start p-3 bg-white border border-gray-200 rounded-lg cursor-pointer hover:bg-blue-50 transition shadow-sm">
                                        <div class="flex-shrink-0 mt-0.5">
                                            <input type="checkbox" name="tagihan_id[]" value="{{ $t->id }}" class="w-5 h-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500 tagihan-checkbox" data-nominal="{{ $t->nominal }}">
                                        </div>
                                        <div class="ml-3 flex-1">
                                            <div class="flex items-center justify-between">
                                                <span class="block text-sm font-bold text-gray-900">{{ $t->siswa->nama_siswa }} - {{ $t->kategori->nama_kategori }}</span>
                                                @if($t->status == 'salah_nominal')
                                                    <span class="text-[10px] bg-red-100 text-red-700 font-bold px-2 py-0.5 rounded">Ditolak: Nominal/Bukti Tidak Sesuai</span>
                                                @endif
                                            </div>
                                            <span class="block text-sm text-gray-600 font-semibold mt-1">Rp {{ number_format($t->nominal, 0, ',', '.') }}</span>
                                        </div>
                                    </label>
                                @endif
                            @endforeach
                            @if(!$ada_tagihan)
                                <p class="text-sm text-gray-500 italic text-center py-2">Tidak ada tagihan yang harus dibayar saat ini.</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nominal Transfer (Rp)</label>
                            <input type="number" name="nominal_bayar" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 transition py-3" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Foto Bukti Transfer</label>
                            <input type="file" name="bukti_bayar" class="w-full text-sm text-gray-600 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:bg-blue-50 file:text-blue-700 file:font-bold hover:file:bg-blue-100 transition cursor-pointer" required>
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full mt-4 bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-md transition-all text-lg">
                        Kirim Bukti Pembayaran
                    </button>
                </form>
            </div>
        </div>

        <div class="space-y-6">
            
            <!-- Tagihan Berjalan Table -->
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 overflow-x-auto">
                <h3 class="text-lg font-bold mb-6 text-gray-800 flex items-center">
                    <span class="w-2 h-6 bg-yellow-400 rounded-full mr-3"></span>
                    Tagihan Berjalan
                </h3>
                <table class="w-full text-left min-w-max">
                    <thead>
                        <tr class="text-xs font-bold text-gray-400 uppercase tracking-wider border-b">
                            <th class="pb-4 px-2">Siswa</th>
                            <th class="pb-4 px-2">Kategori</th>
                            <th class="pb-4 px-2">Nominal</th>
                            <th class="pb-4 px-2 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($tagihan_aktif as $t)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-5 px-2 text-sm font-bold">{{ $t->siswa->nama_siswa }}</td>
                            <td class="py-5 px-2 text-sm text-gray-600">{{ $t->kategori->nama_kategori }}</td>
                            <td class="py-5 px-2 text-sm text-gray-900 font-bold">Rp {{ number_format($t->nominal, 0, ',', '.') }}</td>
                            <td class="py-5 px-2 text-center">
                                @if($t->status == 'belum_bayar')
                                    <span class="px-4 py-1.5 bg-red-100 text-red-600 rounded-full text-xs font-black">Belum Bayar</span>
                                @elseif($t->status == 'salah_nominal')
                                    <span class="px-4 py-1.5 bg-red-100 text-red-700 rounded-full text-xs font-black" title="Silakan upload ulang bukti bayar yang sesuai">Salah Nominal (Ditolak)</span>
                                @else
                                    <span class="px-4 py-1.5 bg-yellow-100 text-yellow-700 rounded-full text-xs font-black">Dicek Admin</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="py-8 text-center text-gray-400">Tidak ada tagihan aktif.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Riwayat Pembayaran Selesai Table -->
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 overflow-x-auto">
                <h3 class="text-lg font-bold mb-6 text-gray-800 flex items-center">
                    <span class="w-2 h-6 bg-green-500 rounded-full mr-3"></span>
                    Riwayat Pembayaran Selesai
                </h3>
                <table class="w-full text-left min-w-max">
                    <thead>
                        <tr class="text-xs font-bold text-gray-400 uppercase tracking-wider border-b">
                            <th class="pb-4 px-2">Kategori</th>
                            <th class="pb-4 px-2">Tanggal Lunas</th>
                            <th class="pb-4 px-2">Nominal</th>
                            <th class="pb-4 px-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($riwayat as $r)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-5 px-2 text-sm font-bold">{{ $r->kategori->nama_kategori }}</td>
                            <td class="py-5 px-2 text-sm text-gray-500">{{ $r->updated_at->format('d M Y') }}</td>
                            <td class="py-5 px-2 text-sm text-green-600 font-bold">Rp {{ number_format($r->nominal, 0, ',', '.') }}</td>
                            <td class="py-5 px-2 flex justify-center">
                                <a href="{{ route('orangtua.cetak', $r->id) }}" target="_blank" class="px-4 py-2 bg-gray-800 hover:bg-black text-white rounded-lg text-xs font-bold transition flex items-center">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                    Cetak Bukti
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="py-8 text-center text-gray-400">Belum ada riwayat pembayaran lunas.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.tagihan-checkbox');
            const nominalInput = document.querySelector('input[name="nominal_bayar"]');
            
            function hitungTotal() {
                let total = 0;
                checkboxes.forEach(cb => {
                    if(cb.checked) {
                        total += parseFloat(cb.getAttribute('data-nominal'));
                    }
                });
                nominalInput.value = total > 0 ? total : '';
            }

            checkboxes.forEach(cb => {
                cb.addEventListener('change', hitungTotal);
            });
        });
    </script>
</x-app-layout>

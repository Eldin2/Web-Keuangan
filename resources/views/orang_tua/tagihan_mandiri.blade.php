<x-app-layout>
    <x-slot name="header">Buat Tagihan Mandiri (Bayar Lebih Awal)</x-slot>

    <div class="space-y-6 mt-4">
        
        <!-- Header Banner (Tema Blue Insan Cendikia) -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 md:p-8 text-white shadow-md flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-extrabold tracking-tight flex items-center gap-3">
                    <div class="p-2.5 bg-white/20 rounded-xl backdrop-blur-sm shadow-inner inline-flex">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    Pembuatan Tagihan Baru Mandiri
                </h2>
                <p class="text-blue-100 text-sm mt-2 max-w-2xl">
                    Gunakan fitur ini apabila Anda ingin mencatatkan dan membayar tagihan sekolah lebih awal dari jadwal reguler. Anda dapat memasukkan lebih dari satu tagihan sekaligus.
                </p>
            </div>
            <button type="button" onclick="addTagihanRow()" class="bg-white hover:bg-blue-50 text-blue-700 font-extrabold px-5 py-3 rounded-xl transition text-sm shadow-md flex items-center gap-2 flex-shrink-0">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                Tambah Baris Tagihan
            </button>
        </div>

        <!-- Session Feedback -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-300 text-green-800 px-5 py-4 rounded-2xl shadow-sm flex items-center gap-3">
                <svg class="w-6 h-6 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <strong class="font-bold block text-sm">Berhasil!</strong>
                    <span class="text-sm">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border border-red-300 text-red-800 px-5 py-4 rounded-2xl shadow-sm">
                <strong class="font-bold block text-sm mb-1">Terjadi Kesalahan!</strong>
                <ul class="list-disc ml-5 text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Main Form Card -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6 md:p-8">
            <form action="{{ route('orangtua.tagihan_mandiri.simpan') }}" method="POST">
                @csrf
                
                <div id="tagihan-rows-container" class="space-y-4 mb-6">
                    <!-- Row 1 (Default) -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-5 bg-blue-50/50 rounded-2xl border border-blue-100/80 relative transition hover:border-blue-200 shadow-xs">
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Pilih Anak <span class="text-red-500">*</span></label>
                            <select name="tagihan[0][siswa_id]" class="w-full rounded-xl border-gray-200 bg-white text-sm py-3 px-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-medium text-gray-800 transition" required>
                                @if(count($anak) > 1)
                                    <option value="">-- Pilih Anak --</option>
                                @endif
                                @foreach($anak as $a)
                                    <option value="{{ $a->id }}" {{ count($anak) == 1 ? 'selected' : '' }}>👦 {{ $a->nama_siswa }} (Kelas {{ $a->kelas }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Kategori Pembayaran <span class="text-red-500">*</span></label>
                            <select name="tagihan[0][nama_kategori]" onchange="updateNominal(this)" class="w-full rounded-xl border-gray-200 bg-white text-sm py-3 px-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-medium text-gray-800 transition" required>
                                <option value="">-- Pilih Kategori Pembayaran --</option>
                                @foreach($kategori_list as $kl)
                                    <option value="{{ $kl->nama_kategori }}" data-nominal="{{ (int)$kl->nominal }}">{{ $kl->nama_kategori }} (Rp {{ number_format((int)$kl->nominal, 0, ',', '.') }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Nominal (Rp) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 font-bold text-sm pointer-events-none">Rp</span>
                                <input type="number" name="tagihan[0][nominal]" placeholder="Pilih kategori terlebih dahulu" class="nominal-input w-full rounded-xl border-gray-200 bg-gray-100 text-sm py-3 pl-11 pr-4 text-blue-900 font-extrabold cursor-not-allowed focus:outline-none" readonly required min="1000">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 flex flex-col md:flex-row gap-3 justify-end items-center">
                    <a href="{{ route('orangtua.dashboard') }}" class="w-full md:w-auto bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3.5 px-6 rounded-xl transition text-sm text-center">
                        Kembali ke Dashboard
                    </a>
                    <button type="submit" class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-extrabold py-3.5 px-8 rounded-xl shadow-md hover:shadow-lg transition text-sm flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Terbitkan Tagihan Terpilih
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let tagihanIndex = 1;

        function updateNominal(selectElement) {
            const row = selectElement.closest('.grid');
            const nominalInput = row.querySelector('.nominal-input');
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const nominal = selectedOption ? selectedOption.getAttribute('data-nominal') : '';

            if (nominal) {
                nominalInput.value = nominal;
            } else {
                nominalInput.value = '';
            }
        }

        function addTagihanRow() {
            const container = document.getElementById('tagihan-rows-container');
            const row = document.createElement('div');
            row.className = 'grid grid-cols-1 md:grid-cols-3 gap-4 p-5 bg-blue-50/50 rounded-2xl border border-blue-100/80 relative transition hover:border-blue-200 shadow-xs';
            row.id = `tagihan-row-${tagihanIndex}`;
            row.innerHTML = `
                <div>
                    <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Pilih Anak <span class="text-red-500">*</span></label>
                    <select name="tagihan[${tagihanIndex}][siswa_id]" class="w-full rounded-xl border-gray-200 bg-white text-sm py-3 px-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-medium text-gray-800 transition" required>
                        <option value="">-- Pilih Anak --</option>
                        @foreach($anak as $a)
                            <option value="{{ $a->id }}" {{ count($anak) == 1 ? 'selected' : '' }}>👦 {{ $a->nama_siswa }} (Kelas {{ $a->kelas }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Kategori Pembayaran <span class="text-red-500">*</span></label>
                    <select name="tagihan[${tagihanIndex}][nama_kategori]" onchange="updateNominal(this)" class="w-full rounded-xl border-gray-200 bg-white text-sm py-3 px-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-medium text-gray-800 transition" required>
                        <option value="">-- Pilih Kategori Pembayaran --</option>
                        @foreach($kategori_list as $kl)
                            <option value="{{ $kl->nama_kategori }}" data-nominal="{{ (int)$kl->nominal }}">{{ $kl->nama_kategori }} (Rp {{ number_format((int)$kl->nominal, 0, ',', '.') }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">Nominal (Rp) <span class="text-red-500">*</span></label>
                    <div class="flex gap-2 items-center">
                        <div class="relative w-full">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 font-bold text-sm pointer-events-none">Rp</span>
                            <input type="number" name="tagihan[${tagihanIndex}][nominal]" placeholder="Pilih kategori terlebih dahulu" class="nominal-input w-full rounded-xl border-gray-200 bg-gray-100 text-sm py-3 pl-11 pr-4 text-blue-900 font-extrabold cursor-not-allowed focus:outline-none" readonly required min="1000">
                        </div>
                        <button type="button" onclick="removeTagihanRow(${tagihanIndex})" class="bg-red-50 hover:bg-red-100 text-red-600 p-3 rounded-xl transition flex-shrink-0 border border-red-100" title="Hapus Baris">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(row);
            tagihanIndex++;
        }

        function removeTagihanRow(index) {
            const row = document.getElementById(`tagihan-row-${index}`);
            if (row) {
                row.remove();
            }
        }
    </script>
</x-app-layout>

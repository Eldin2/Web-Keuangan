<x-app-layout>
    <x-slot name="header">Buat Tagihan Mandiri (Bayar Lebih Awal)</x-slot>

    <div class="w-full mt-4">
        <!-- Session Feedback -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-5 py-4 rounded-2xl shadow-sm">
                <strong class="font-bold block mb-1">Berhasil!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-5 py-4 rounded-2xl shadow-sm">
                <strong class="font-bold block mb-1">Terjadi Kesalahan!</strong>
                <ul class="list-disc ml-5 text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6 md:p-8">
            <div class="border-b pb-4 mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h3 class="text-xl font-extrabold text-gray-900 flex items-center gap-2">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Pembuatan Tagihan Baru Mandiri
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">Gunakan fitur ini apabila Anda ingin mencatatkan dan membayar tagihan sekolah lebih awal dari jadwal reguler. Anda dapat memasukkan lebih dari satu tagihan sekaligus.</p>
                </div>
                <button type="button" onclick="addTagihanRow()" class="bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold px-4 py-2.5 rounded-xl transition text-sm flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Baris Tagihan
                </button>
            </div>

            <form action="{{ route('orangtua.tagihan_mandiri.simpan') }}" method="POST">
                @csrf
                
                <div id="tagihan-rows-container">
                    <!-- Row 1 (Default) -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4 bg-gray-50 rounded-xl border border-gray-200 relative mb-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Pilih Anak</label>
                            <select name="tagihan[0][siswa_id]" class="w-full rounded-xl border-gray-250 bg-white text-sm py-3 px-4 focus:ring-blue-500 focus:border-blue-500" required>
                                @if(count($anak) > 1)
                                    <option value="">-- Pilih Anak --</option>
                                @endif
                                @foreach($anak as $a)
                                    <option value="{{ $a->id }}" {{ count($anak) == 1 ? 'selected' : '' }}>{{ $a->nama_siswa }} (Kelas {{ $a->kelas }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Kategori Pembayaran</label>
                            <input list="kategori-datalist" name="tagihan[0][nama_kategori]" placeholder="Pilih atau ketik baru..." class="w-full rounded-xl border-gray-250 bg-white text-sm py-3 px-4 focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Nominal (Rp)</label>
                            <input type="number" name="tagihan[0][nominal]" placeholder="Contoh: 150000" class="w-full rounded-xl border-gray-250 bg-white text-sm py-3 px-4 focus:ring-blue-500 focus:border-blue-500" required min="1000">
                        </div>
                    </div>
                </div>

                <datalist id="kategori-datalist">
                    @foreach($kategori_list as $kl)
                        <option value="{{ $kl->nama_kategori }}"></option>
                    @endforeach
                </datalist>

                <div class="pt-4 border-t border-gray-100 flex flex-col md:flex-row gap-3 justify-end">
                    <a href="{{ route('orangtua.dashboard') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3.5 px-6 rounded-xl transition text-sm text-center">
                        Kembali ke Dashboard
                    </a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 px-6 rounded-xl shadow-md transition text-sm">
                        Terbitkan Tagihan Terpilih
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let tagihanIndex = 1;

        function addTagihanRow() {
            const container = document.getElementById('tagihan-rows-container');
            const row = document.createElement('div');
            row.className = 'grid grid-cols-1 md:grid-cols-3 gap-4 p-4 bg-gray-50 rounded-xl border border-gray-200 relative mb-4';
            row.id = `tagihan-row-${tagihanIndex}`;
            row.innerHTML = `
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Pilih Anak</label>
                    <select name="tagihan[${tagihanIndex}][siswa_id]" class="w-full rounded-xl border-gray-250 bg-white text-sm py-3 px-4 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">-- Pilih Anak --</option>
                        @foreach($anak as $a)
                            <option value="{{ $a->id }}" {{ count($anak) == 1 ? 'selected' : '' }}>{{ $a->nama_siswa }} (Kelas {{ $a->kelas }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Kategori Pembayaran</label>
                    <input list="kategori-datalist" name="tagihan[${tagihanIndex}][nama_kategori]" placeholder="Pilih atau ketik baru..." class="w-full rounded-xl border-gray-250 bg-white text-sm py-3 px-4 focus:ring-blue-500 focus:border-blue-500" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Nominal (Rp)</label>
                    <div class="flex gap-2 items-center">
                        <input type="number" name="tagihan[${tagihanIndex}][nominal]" placeholder="Contoh: 150000" class="w-full rounded-xl border-gray-250 bg-white text-sm py-3 px-4 focus:ring-blue-500 focus:border-blue-500" required min="1000">
                        <button type="button" onclick="removeTagihanRow(${tagihanIndex})" class="bg-red-100 hover:bg-red-200 text-red-600 p-3 rounded-xl transition">
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

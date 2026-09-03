<x-app-layout>
    <x-slot name="header">Penerbitan Slip Gaji Guru</x-slot>

    <!-- Error Validation Feedback -->
    @if($errors->any())
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative shadow-sm">
            <strong class="font-bold">Error!</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="max-w-5xl mx-auto space-y-8">
        
        <!-- STEP 1: Select Teacher -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-3">Langkah 1: Pilih Tenaga Pengajar</h3>
            <form action="{{ route('admin.gaji.create') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-end">
                <div class="flex-1">
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nama Guru</label>
                    <select name="guru_id" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 transition py-2.5 px-3.5 text-sm" onchange="this.form.submit()">
                        <option value="">-- Pilih Guru --</option>
                        @foreach($gurus as $g)
                            <option value="{{ $g->id }}" {{ (isset($selectedGuru) && $selectedGuru->id == $g->id) ? 'selected' : '' }}>{{ $g->nama_guru }} ({{ $g->jabatan }})</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2.5 px-6 rounded-xl text-sm transition shadow-sm h-11 w-full sm:w-auto">
                    Pilih Guru
                </button>
            </form>
        </div>

        @if(isset($selectedGuru))
            <!-- STEP 2: Input Metrics & Live Calculation -->
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                
                <!-- Calculation Input Form (Left 3 cols) -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 lg:col-span-3 space-y-6">
                    <div>
                        <h3 class="text-base font-extrabold text-gray-800 border-l-4 border-blue-600 pl-2">Langkah 2: Rincian Nominal Gaji</h3>
                        <p class="text-xs text-gray-400 mt-1">Masukkan nominal gaji bulanan dan potongan jika ada.</p>
                    </div>

                    <form action="{{ route('admin.gaji.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="guru_id" value="{{ $selectedGuru->id }}">

                        <!-- Period Details -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Bulan Penggajian</label>
                                <select name="bulan" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 transition py-2 px-3 text-sm">
                                    @php
                                        $bulanList = [
                                            1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 
                                            5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus', 
                                            9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'
                                        ];
                                        $currentMonth = date('n');
                                    @endphp
                                    @foreach($bulanList as $k => $v)
                                        <option value="{{ $k }}" {{ $k == $currentMonth ? 'selected' : '' }}>{{ $v }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Tahun</label>
                                <select name="tahun" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 transition py-2 px-3 text-sm">
                                    @for($y = date('Y') - 1; $y <= date('Y') + 2; $y++)
                                        <option value="{{ $y }}" {{ $y == date('Y') ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <!-- Salary & Deduction -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Gaji Pokok / Bulanan (Rp)</label>
                                <input type="number" name="nominal_gaji" id="nominal_gaji" value="{{ $selectedGuru->gaji_bulanan }}" min="0" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 transition py-2 px-3 text-sm" required>
                                <p class="text-[10px] text-gray-400 mt-1">Gaji standar: Rp {{ number_format($selectedGuru->gaji_bulanan, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Potongan Gaji (Rp)</label>
                                <input type="number" name="potongan" id="potongan" value="0" min="0" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 transition py-2 px-3 text-sm" required>
                            </div>
                        </div>

                        <!-- Date & Status -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Tanggal Dibayar</label>
                                <input type="date" name="tanggal_dibayar" value="{{ date('Y-m-d') }}" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 transition py-2 px-3 text-sm" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Status Pembayaran</label>
                                <select name="status_pembayaran" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 transition py-2 px-3 text-sm" required>
                                    <option value="dibayar">Lunas (Catat ke Kas Keluar)</option>
                                    <option value="pending">Tertunda (Belum Dibayar)</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Catatan Tambahan</label>
                            <textarea name="keterangan" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 transition py-2 px-3 text-sm h-20" placeholder="Keterangan opsional..."></textarea>
                        </div>

                        <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white font-bold py-3.5 px-4 rounded-xl shadow-md transition-all duration-200 mt-6 text-sm">
                            Terbitkan Slip Gaji
                        </button>
                    </form>
                </div>

                <!-- Live Salary Slip Preview (Right 2 cols) -->
                <div class="bg-gradient-to-br from-blue-900 to-indigo-950 text-white p-6 rounded-2xl shadow-xl lg:col-span-2 flex flex-col justify-between border border-blue-950">
                    <div>
                        <div class="flex items-center justify-between border-b border-white/10 pb-4 mb-4">
                            <div>
                                <h3 class="text-base font-black tracking-wide">Live Preview Slip</h3>
                                <p class="text-[10px] text-blue-300 font-medium">TK IT INSAN CENDIKIA</p>
                            </div>
                            <span class="bg-blue-500/20 text-blue-300 text-[10px] font-bold px-2 py-0.5 rounded border border-blue-500/30">Draf Slip</span>
                        </div>

                        <div class="space-y-4 text-sm">
                            <!-- Teacher Profile summary -->
                            <div>
                                <p class="text-[10px] text-blue-300 uppercase font-bold tracking-wider">Penerima</p>
                                <p class="font-extrabold text-base">{{ $selectedGuru->nama_guru }}</p>
                                <p class="text-xs text-blue-200">{{ $selectedGuru->jabatan }} ({{ $selectedGuru->status }})</p>
                            </div>

                            <!-- Calculations breakdown -->
                            <div class="border-t border-white/10 pt-3 space-y-2">
                                <p class="text-[10px] text-blue-300 uppercase font-bold tracking-wider mb-1">Rincian Slip Gaji</p>
                                
                                <div class="flex justify-between text-xs">
                                    <span class="text-blue-200">Gaji Bulanan</span>
                                    <span class="font-mono font-bold" id="prev_nominal">Rp 0</span>
                                </div>
                                <div class="flex justify-between text-xs">
                                    <span class="text-blue-200">Total Potongan</span>
                                    <span class="font-mono font-bold text-red-300" id="prev_potongan">Rp 0</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Net Salary Display -->
                    <div class="border-t border-white/10 pt-4 mt-6">
                        <p class="text-[10px] text-blue-300 uppercase font-bold tracking-wider">Total Diterima (Gaji Bersih)</p>
                        <p class="text-3xl font-black text-green-400 font-mono mt-1" id="prev_gaji_bersih">Rp 0</p>
                    </div>

                </div>

            </div>

            <!-- Client-Side Live Calculation Script -->
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    // Inputs elements
                    const inputNominal = document.getElementById('nominal_gaji');
                    const inputPotongan = document.getElementById('potongan');

                    // Preview elements
                    const prevNominal = document.getElementById('prev_nominal');
                    const prevPotongan = document.getElementById('prev_potongan');
                    const prevGajiBersih = document.getElementById('prev_gaji_bersih');

                    function formatRupiah(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }

                    function calculateLiveSalary() {
                        const nominal = parseInt(inputNominal.value) || 0;
                        const potongan = parseInt(inputPotongan.value) || 0;
                        const gajiBersih = nominal - potongan;

                        // Update DOM preview
                        prevNominal.textContent = formatRupiah(nominal);
                        prevPotongan.textContent = formatRupiah(potongan);
                        prevGajiBersih.textContent = formatRupiah(gajiBersih);
                    }

                    // Attach event listeners
                    inputNominal.addEventListener('input', calculateLiveSalary);
                    inputPotongan.addEventListener('input', calculateLiveSalary);

                    // Initial calculation run
                    calculateLiveSalary();
                });
            </script>
        @endif

    </div>
</x-app-layout>

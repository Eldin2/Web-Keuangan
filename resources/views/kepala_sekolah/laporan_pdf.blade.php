<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Validasi Transaksi Keuangan - TK IT INSAN CENDIKIA</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; margin: 0; padding: 0; background: #fff; }
        .container { width: 100%; padding: 25px; margin: 0 auto; }
        .header { text-align: center; margin-bottom: 25px; border-bottom: 3px double #1e40af; padding-bottom: 12px; }
        .header h1 { margin: 0; font-size: 22px; text-transform: uppercase; letter-spacing: 1px; color: #1e40af; font-weight: bold; }
        .header h2 { margin: 6px 0 0 0; font-size: 15px; font-weight: bold; color: #374151; }
        .header p { margin: 4px 0 0 0; font-size: 12px; color: #6b7280; font-style: italic; }
        
        table.data-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table.data-table th, table.data-table td { border: 1px solid #d1d5db; padding: 9px 10px; text-align: left; font-size: 11px; }
        table.data-table th { background-color: #f3f4f6; font-weight: bold; text-transform: uppercase; color: #374151; font-size: 10px; }
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        
        .badge-valid { color: #15803d; font-weight: bold; background: #dcfce7; padding: 3px 8px; rounded: 10px; display: inline-block; border: 1px solid #bbf7d0; }
        .badge-menunggu { color: #b45309; font-weight: bold; background: #fef3c7; padding: 3px 8px; rounded: 10px; display: inline-block; border: 1px solid #fde68a; }

        .summary-section { margin-top: 25px; display: flex; justify-content: flex-end; }
        .summary-table { width: 320px; border-collapse: collapse; float: right; }
        .summary-table td { padding: 8px 12px; border: 1px solid #d1d5db; font-size: 12px; }
        .summary-table tr.total-row { background-color: #eff6ff; font-weight: bold; font-size: 13px; color: #1e40af; }
        .summary-table tr.total-row td { border: 2px solid #3b82f6; }

        .signature-section { margin-top: 70px; display: flex; justify-content: space-between; page-break-inside: avoid; clear: both; padding-top: 20px; }
        .signature-box { text-align: center; width: 220px; font-size: 12px; }
        .signature-space { height: 70px; }
    </style>
</head>
<body>
    <div id="pdf-content" class="container">
        <div class="header">
            <h1>TK IT INSAN CENDIKIA</h1>
            <h2>LAPORAN VALIDASI TRANSAKSI KEUANGAN</h2>
            <p>Periode Laporan: {{ $periode }} | Tanggal Cetak: {{ \Carbon\Carbon::now()->format('d M Y') }}</p>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 5%;" class="text-center">No</th>
                    <th style="width: 15%;" class="text-center">Tanggal Bayar</th>
                    <th style="width: 30%;">Nama Siswa</th>
                    <th style="width: 20%;">Kategori Tagihan</th>
                    <th style="width: 15%;" class="text-right">Nominal</th>
                    <th style="width: 15%;" class="text-center">Status Validasi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @forelse($transaksis as $trx)
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($trx->tanggal_bayar)->format('d/m/Y') }}</td>
                        <td class="font-bold">{{ $trx->tagihan->siswa->nama_siswa ?? '-' }}</td>
                        <td>{{ $trx->tagihan->kategori->nama_kategori ?? '-' }}</td>
                        <td class="text-right font-bold">
                            Rp {{ number_format($trx->nominal_bayar, 0, ',', '.') }}
                        </td>
                        <td class="text-center">
                            @if($trx->is_valid_kepala_sekolah)
                                <span class="badge-valid">Arsip Digital</span>
                            @else
                                <span class="badge-menunggu">Belum Validasi</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center" style="padding: 20px; color: #9ca3af;">
                            Tidak ada transaksi lunas pada periode ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="summary-section">
            <table class="summary-table">
                <tr>
                    <td class="font-bold">Total Transaksi</td>
                    <td class="text-right font-bold">{{ $totalTransaksi }} Transaksi</td>
                </tr>
                <tr class="total-row">
                    <td>Total Nominal Keuangan</td>
                    <td class="text-right font-bold">Rp {{ number_format($totalNominal, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <div style="clear: both;"></div>

        <div class="signature-section">
            <div class="signature-box" style="float: left;">
                <p>Mengetahui,</p>
                <p class="font-bold">Bendahara Sekolah</p>
                <div class="signature-space"></div>
                <p class="font-bold" style="text-decoration: underline;">( ____________________ )</p>
            </div>
            <div class="signature-box" style="float: right;">
                <p>Kabupaten, {{ \Carbon\Carbon::now()->format('d M Y') }}</p>
                <p class="font-bold">Kepala Sekolah</p>
                <div class="signature-space"></div>
                <p class="font-bold" style="text-decoration: underline;">Indrianti, S.Pd</p>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            var element = document.getElementById('pdf-content');
            var opt = {
                margin:       [0.3, 0.3, 0.3, 0.3],
                filename:     'Laporan_Transaksi_Keuangan_{{ str_replace([" - ", " "], ["_to_", "_"], $periode) }}.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2, useCORS: true },
                jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
            };

            // Generate PDF & simpan otomatis
            html2pdf().set(opt).from(element).save().then(function() {
                setTimeout(function() {
                    window.close();
                }, 1500);
            });
        };
    </script>
</body>
</html>

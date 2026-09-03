<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Buku Kas Umum Sekolah</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; margin: 0; padding: 0; }
        .container { width: 100%; padding: 20px; margin: 0 auto; }
        .header { text-align: center; margin-bottom: 25px; border-bottom: 3px double #333; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 24px; text-transform: uppercase; letter-spacing: 1px; }
        .header h2 { margin: 5px 0 0 0; font-size: 16px; font-weight: normal; color: #666; }
        .header p { margin: 5px 0 0 0; font-size: 13px; font-style: italic; }
        
        .meta-info { margin-bottom: 20px; font-size: 14px; }
        .meta-info table { width: 150px; }
        
        table.data-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table.data-table th, table.data-table td { border: 1px solid #999; padding: 10px 8px; text-align: left; font-size: 12px; }
        table.data-table th { background-color: #f2f2f2; font-weight: bold; text-transform: uppercase; }
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        
        .summary-section { margin-top: 30px; display: flex; justify-content: flex-end; }
        .summary-table { width: 350px; border-collapse: collapse; }
        .summary-table td { padding: 8px 12px; border: 1px solid #999; font-size: 13px; }
        .summary-table tr.total-row { background-color: #e6f4ea; font-weight: bold; font-size: 14px; }
        .summary-table tr.total-row td { border: 2px solid #2e7d32; }

        .signature-section { margin-top: 60px; display: flex; justify-content: space-between; page-break-inside: avoid; }
        .signature-box { text-align: center; width: 200px; font-size: 13px; }
        .signature-space { height: 75px; }
    </style>
</head>
<body>
    <div id="pdf-content" class="container">
        <div class="header">
            <h1>TK IT INSAN CENDIKIA</h1>
            <h2>Laporan Buku Kas Umum Sekolah</h2>
            <p>Periode Laporan: {{ $periode }}</p>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 5%;" class="text-center">No</th>
                    <th style="width: 15%;" class="text-center">Tanggal</th>
                    <th style="width: 40%;">Kategori / Keterangan</th>
                    <th style="width: 20%;" class="text-right">Debit (Uang Masuk)</th>
                    <th style="width: 20%;" class="text-right">Kredit (Uang Keluar)</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @forelse($catatans as $c)
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($c->tanggal)->format('d-m-Y') }}</td>
                        <td class="font-bold">{{ $c->kategori }}</td>
                        <td class="text-right text-green-700 font-bold">
                            @if($c->tipe == 'masuk')
                                Rp {{ number_format($c->nominal, 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-right text-red-700 font-bold">
                            @if($c->tipe == 'keluar')
                                Rp {{ number_format($c->nominal, 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center" style="padding: 20px; color: #777;">
                            Tidak ada catatan transaksi kas pada periode ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="summary-section">
            <table class="summary-table">
                <tr>
                    <td class="font-bold">Total Uang Masuk (Debit)</td>
                    <td class="text-right text-green-700 font-bold">Rp {{ number_format($total_masuk, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="font-bold">Total Pengeluaran (Kredit)</td>
                    <td class="text-right text-red-700 font-bold">Rp {{ number_format($total_keluar, 0, ',', '.') }}</td>
                </tr>
                <tr class="total-row">
                    <td>Saldo Akhir Kas</td>
                    <td class="text-right text-green-800">Rp {{ number_format($saldo_akhir, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <div class="signature-section">
            <div class="signature-box">
                <p>Mengetahui,</p>
                <p class="font-bold">Kepala Sekolah</p>
                <div class="signature-space"></div>
                <p class="font-bold" style="text-decoration: underline;">( ____________________ )</p>
            </div>
            <div class="signature-box">
                <p>Jakarta, {{ \Carbon\Carbon::now()->format('d M Y') }}</p>
                <p class="font-bold">Bendahara Sekolah</p>
                <div class="signature-space"></div>
                <p class="font-bold" style="text-decoration: underline;">( ____________________ )</p>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            var element = document.getElementById('pdf-content');
            var opt = {
                margin:       [0.4, 0.4, 0.4, 0.4],
                filename:     'Laporan_Buku_Kas_{{ str_replace([" - ", " "], ["_to_", "_"], $periode) }}.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2, useCORS: true },
                jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
            };

            // Generate PDF and download automatically
            html2pdf().set(opt).from(element).save().then(function() {
                setTimeout(function() {
                    window.close(); // Close the newly opened print tab
                }, 1500);
            });
        };
    </script>
</body>
</html>

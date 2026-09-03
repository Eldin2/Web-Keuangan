<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekapitulasi Pembayaran</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        * { box-sizing: border-box; }
        body { font-family: sans-serif; color: #333; margin: 0; padding: 0; }
        .container { width: 100%; padding: 0 10px; margin: 0 auto; }
        h1, h2, h3 { text-align: center; margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; table-layout: fixed; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; word-wrap: break-word; }
        th:nth-child(1) { width: 10%; }
        th:nth-child(2) { width: 40%; }
        th:nth-child(3) { width: 25%; }
        th:nth-child(4) { width: 25%; }
        th { background-color: #f4f4f4; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .section-title { margin-top: 30px; font-size: 1.2em; font-weight: bold; border-bottom: 2px solid #333; padding-bottom: 5px; }
        .total-box { margin-top: 20px; padding: 15px; border: 2px solid #333; text-align: center; font-size: 1.5em; font-weight: bold; }
    </style>
</head>
<body>
    <div id="pdf-content" class="container">
        <h2>TK IT INSAN CENDIKIA</h2>
        <h3>Laporan Rekapitulasi Pembayaran</h3>
        <p style="text-align: center;">Periode: {{ $periode }}</p>

        <div class="section-title">Pembayaran Online (Transfer)</div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Siswa</th>
                    <th>Tanggal</th>
                    <th class="text-right">Nominal</th>
                </tr>
            </thead>
            <tbody>
                @php $totalOnline = 0; $no = 1; @endphp
                @forelse($online as $o)
                    @php $totalOnline += $o->nominal_bayar; @endphp
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $o->tagihan->siswa->nama_siswa }}</td>
                        <td>{{ \Carbon\Carbon::parse($o->tanggal_bayar)->format('d M Y') }}</td>
                        <td class="text-right">Rp {{ number_format($o->nominal_bayar, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center;">Tidak ada transaksi online</td>
                    </tr>
                @endforelse
                <tr>
                    <td colspan="3" class="text-right font-bold">TOTAL ONLINE:</td>
                    <td class="text-right font-bold">Rp {{ number_format($totalOnline, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="section-title">Pembayaran Tunai (Cash)</div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Siswa</th>
                    <th>Tanggal</th>
                    <th class="text-right">Nominal</th>
                </tr>
            </thead>
            <tbody>
                @php $totalCash = 0; $no = 1; @endphp
                @forelse($cash as $c)
                    @php $totalCash += $c->nominal_bayar; @endphp
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $c->tagihan->siswa->nama_siswa }}</td>
                        <td>{{ \Carbon\Carbon::parse($c->tanggal_bayar)->format('d M Y') }}</td>
                        <td class="text-right">Rp {{ number_format($c->nominal_bayar, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center;">Tidak ada transaksi tunai</td>
                    </tr>
                @endforelse
                <tr>
                    <td colspan="3" class="text-right font-bold">TOTAL CASH:</td>
                    <td class="text-right font-bold">Rp {{ number_format($totalCash, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="total-box">
            TOTAL KESELURUHAN: Rp {{ number_format(($totalOnline ?? 0) + ($totalCash ?? 0), 0, ',', '.') }}
        </div>
    </div>

    <script>
        window.onload = function() {
            var element = document.getElementById('pdf-content');
            var opt = {
                margin:       0.5,
                filename:     'Rekapitulasi_Pembayaran_{{ str_replace(" ", "_", $periode) }}.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2 },
                jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
            };

            // Generate PDF and download
            html2pdf().set(opt).from(element).save().then(function() {
                // Optionally go back after download
                setTimeout(function() {
                    window.close(); // Try to close the tab if it was opened in a new tab
                    window.history.back(); // Fallback if opened in same tab
                }, 1000);
            });
        };
    </script>
</body>
</html>

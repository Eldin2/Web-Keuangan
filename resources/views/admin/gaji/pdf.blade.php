<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Slip_Gaji_{{ str_replace(' ', '_', $slip->guru->nama_guru) }}_{{ $bulanNama }}_{{ $slip->tahun }}</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; margin: 0; padding: 0; }
        .container { width: 100%; padding: 40px; margin: 0 auto; max-width: 800px; }
        .header { display: flex; align-items: center; justify-content: space-between; border-bottom: 3px double #333; padding-bottom: 12px; margin-bottom: 20px; }
        .header-left { display: flex; align-items: center; }
        .header-logo { height: 60px; width: 60px; margin-right: 15px; }
        .header-title h1 { margin: 0; font-size: 20px; text-transform: uppercase; letter-spacing: 0.5px; }
        .header-title p { margin: 3px 0 0 0; font-size: 11px; color: #666; }
        .header-right { text-align: right; }
        .header-right h2 { margin: 0; font-size: 16px; color: #2563eb; text-transform: uppercase; letter-spacing: 1px; }
        .header-right p { margin: 3px 0 0 0; font-size: 10px; font-family: monospace; color: #888; }
        
        .section-info { display: flex; justify-content: space-between; background-color: #f9fafb; border: 1px solid #e5e7eb; padding: 15px; border-radius: 12px; margin-bottom: 25px; font-size: 12px; line-height: 1.6; }
        .info-col { width: 48%; }
        .info-col table { width: 100%; border-collapse: collapse; }
        .info-col td { padding: 3px 0; vertical-align: top; }
        .info-col td.label { width: 30%; color: #666; }
        .info-col td.value { width: 70%; font-weight: bold; }
        
        .table-box { width: 100%; max-width: 400px; margin: 0 auto 25px auto; }
        .table-box h4 { margin: 0 0 10px 0; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; padding-bottom: 5px; text-align: center; color: #1e3a8a; border-bottom: 2px solid #3b82f6; }
        
        table.slip-table { width: 100%; border-collapse: collapse; font-size: 12px; margin-bottom: 15px; }
        table.slip-table td { padding: 10px 0; border-bottom: 1px solid #e5e7eb; }
        table.slip-table td.amount { text-align: right; font-weight: bold; font-family: monospace; }
        table.slip-table td.label-text { font-weight: 600; color: #555; }
        
        .net-salary-box { background-color: #1e3a8a; color: white; padding: 15px; border-radius: 8px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 30px; }
        .net-salary-label h5 { margin: 0; font-size: 11px; color: #93c5fd; letter-spacing: 0.5px; }
        .net-salary-label p { margin: 3px 0 0 0; font-size: 9px; font-style: italic; color: #bfdbfe; }
        .net-salary-amount { font-size: 20px; font-weight: bold; font-family: monospace; }
        
        .signature-section { margin-top: 40px; display: flex; justify-content: space-between; page-break-inside: avoid; }
        .signature-box { text-align: center; width: 220px; font-size: 12px; }
        .signature-space { height: 60px; }
        .signature-box p.name { font-weight: bold; text-decoration: underline; margin-bottom: 2px; }
        .signature-box p.title { font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <div id="pdf-content" class="container">
        
        <div class="header">
            <div class="header-left">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="header-logo">
                <div class="header-title">
                    <h1>TK IT INSAN CENDIKIA</h1>
                    <p>Membentuk Generasi Cerdas, Mandiri, dan Berkarakter Islami</p>
                </div>
            </div>
            <div class="header-right">
                <h2>SLIP GAJI GURU</h2>
                <p>Ref: #SG-{{ str_pad($slip->id, 5, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>

        <div class="section-info">
            <div class="info-col">
                <table>
                    <tr>
                        <td class="label">Nama Guru</td>
                        <td class="value">: {{ $slip->guru->nama_guru }}</td>
                    </tr>
                    <tr>
                        <td class="label">NIP</td>
                        <td class="value">: {{ $slip->guru->nip ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Jabatan</td>
                        <td class="value">: {{ $slip->guru->jabatan }}</td>
                    </tr>
                    <tr>
                        <td class="label">Status Kerja</td>
                        <td class="value">: {{ $slip->guru->status }}</td>
                    </tr>
                </table>
            </div>
            <div class="info-col">
                <table>
                    <tr>
                        <td class="label">Periode Gaji</td>
                        <td class="value">: {{ $bulanNama }} {{ $slip->tahun }}</td>
                    </tr>
                    <tr>
                        <td class="label">Tanggal Bayar</td>
                        <td class="value">: {{ \Carbon\Carbon::parse($slip->tanggal_dibayar)->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <td class="label">Status Bayar</td>
                        <td class="value">: {{ strtoupper($slip->status_pembayaran) }}</td>
                    </tr>
                    <tr>
                        <td class="label">Keterangan</td>
                        <td class="value italic">: {{ $slip->keterangan ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="table-box">
            <h4>Rincian Penerimaan</h4>
            <table class="slip-table">
                <tr>
                    <td class="label-text">Gaji Pokok / Bulanan</td>
                    <td class="amount">Rp {{ number_format($slip->nominal_gaji, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="label-text">Potongan</td>
                    <td class="amount" style="color: #ef4444;">Rp {{ number_format($slip->potongan, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <div class="net-salary-box">
            <div class="net-salary-label">
                <h5>GAJI BERSIH (TAKE HOME PAY)</h5>
                <p>Terbilang: {{ ucfirst(\App\Http\Controllers\GuruController::terbilang($slip->total_gaji)) }} Rupiah</p>
            </div>
            <div class="net-salary-amount">
                Rp {{ number_format($slip->total_gaji, 0, ',', '.') }}
            </div>
        </div>

        <div class="signature-section">
            <div class="signature-box">
                <p>Penerima,</p>
                <div class="signature-space"></div>
                <p class="name">{{ $slip->guru->nama_guru }}</p>
                <p class="title">Tenaga Pengajar</p>
            </div>
            <div class="signature-box">
                <p>Mengetahui,</p>
                <div class="signature-space"></div>
                <p class="name">Bendahara Sekolah</p>
                <p class="title">TK IT INSAN CENDIKIA</p>
            </div>
        </div>

    </div>

    <script>
        window.onload = function() {
            var element = document.getElementById('pdf-content');
            var opt = {
                margin:       [0.4, 0.4, 0.4, 0.4],
                filename:     'Slip_Gaji_{{ str_replace(' ', '_', $slip->guru->nama_guru) }}_{{ $bulanNama }}_{{ $slip->tahun }}.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2, useCORS: true },
                jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
            };

            // Generate PDF and download automatically
            html2pdf().set(opt).from(element).save().then(function() {
                setTimeout(function() {
                    window.close(); // Close the newly opened tab
                }, 1500);
            });
        };
    </script>
</body>
</html>

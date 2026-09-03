<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Struk Pembayaran</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; padding: 20px; color: #333; }
        .struk-container { max-width: 400px; margin: 0 auto; border: 2px dashed #ccc; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 0; font-size: 18px; }
        .header p { margin: 5px 0 0; font-size: 12px; }
        .content p { margin: 8px 0; font-size: 14px; }
        .divider { border-bottom: 1px dashed #333; margin: 15px 0; }
        .footer { text-align: center; margin-top: 20px; font-size: 12px; font-style: italic; }
        .lunas-stamp { color: green; font-weight: bold; font-size: 18px; text-align: center; border: 2px solid green; padding: 5px; margin-top: 10px; transform: rotate(-5deg); width: 100px; margin-left: auto; margin-right: auto; }
    </style>
</head>
<body onload="window.print()"> <div class="struk-container">
        <div class="header">
            <h2>BUKTI PEMBAYARAN RESMI</h2>
            <p>Sistem Administrasi Keuangan Sekolah</p>
        </div>
        
        <div class="content">
            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($transaksi->tanggal_bayar)->format('d F Y') }}</p>
            <p><strong>Nama Siswa:</strong> {{ $tagihan->siswa->nama_siswa }}</p>
            <p><strong>NIS:</strong> {{ $tagihan->siswa->nis }}</p>
            <p><strong>Kelas:</strong> {{ $tagihan->siswa->kelas }}</p>
            
            <div class="divider"></div>
            
            <p><strong>Kategori:</strong> {{ $tagihan->kategori->nama_kategori }}</p>
            <p><strong>Metode:</strong> {{ strtoupper($transaksi->metode) }}</p>
            <p><strong>Nominal:</strong> Rp {{ number_format($transaksi->nominal_bayar, 0, ',', '.') }}</p>
            
            <div class="lunas-stamp">LUNAS</div>
        </div>
        
        <div class="footer">
            <p>Terima kasih.</p>
            <p>Struk ini dicetak otomatis oleh sistem.</p>
        </div>
    </div>
</body>
</html>
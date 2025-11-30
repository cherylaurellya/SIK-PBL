<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran #{{ $pembayaran->id }}</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; background-color: #f3f3f3; padding: 20px; }
        .ticket {
            width: 300px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        h3, p { text-align: center; margin: 5px 0; }
        .divider { border-top: 2px dashed #333; margin: 15px 0; }
        .item { display: flex; justify-content: space-between; margin-bottom: 5px; font-size: 14px; }
        .total { font-weight: bold; font-size: 16px; margin-top: 10px; }
        .footer { font-size: 10px; color: #555; text-align: center; margin-top: 20px; }
        @media print {
            body { background: none; padding: 0; }
            .ticket { box-shadow: none; width: 100%; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="ticket">
        <h3>KLINIK SEHAT</h3>
        <p>Jl. Kesehatan No. 123</p>
        <p>Telp: 021-555-666</p>
        
        <div class="divider"></div>
        
        <div class="item">
            <span>Tgl:</span>
            <span>{{ $pembayaran->created_at->format('d/m/Y H:i') }}</span>
        </div>
        <div class="item">
            <span>No. Ref:</span>
            <span>TRX-{{ $pembayaran->id }}</span>
        </div>
        <div class="item">
            <span>Pasien:</span>
            <span>{{ $pembayaran->rekamMedis->pasien->user->name }}</span>
        </div>
        <div class="item">
            <span>Dokter:</span>
            <span>{{ $pembayaran->rekamMedis->dokter->user->name }}</span>
        </div>

        <div class="divider"></div>

        <div class="item">
            <span>Jasa Medis & Obat</span>
        </div>
        <div class="item">
            <span>({{ $pembayaran->metode_pembayaran }})</span>
            <span>Rp {{ number_format($pembayaran->total_biaya, 0, ',', '.') }}</span>
        </div>

        <div class="divider"></div>

        <div class="item total">
            <span>TOTAL BAYAR</span>
            <span>Rp {{ number_format($pembayaran->total_biaya, 0, ',', '.') }}</span>
        </div>

        <div class="footer">
            <p>Terima Kasih atas kunjungan Anda.</p>
            <p>Semoga Lekas Sembuh!</p>
        </div>
    </div>

</body>
</html>
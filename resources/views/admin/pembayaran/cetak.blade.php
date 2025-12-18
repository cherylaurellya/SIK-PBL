<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran - {{ $pembayaran->no_transaksi }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 14px;
            max-width: 300px; 
            margin: 0 auto;
            padding: 10px;
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 10px;
        }
        .divider {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            font-size: 16px;
            margin-top: 10px;
        }
        .btn-print {
            display: block;
            width: 100%;
            background: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
            text-decoration: none;
            margin-top: 20px;
            cursor: pointer;
        }
        @media print {
            .btn-print { display: none; }
            body { margin: 0; padding: 0; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h3 style="margin:0;">KLINIK SEHAT</h3>
        <p style="margin:0; font-size:12px;">Jl. Banyuwangi No. 123</p>
        <p style="margin:0; font-size:12px;">Telp: 0812-3456-7890</p>
    </div>

    <div class="divider"></div>

    <div class="info-row">
        <span>No. Transaksi</span>
        <span>#{{ $pembayaran->id }}</span>
    </div>
    <div class="info-row">
        <span>Tanggal</span>
        <span>{{ $pembayaran->created_at->format('d/m/Y H:i') }}</span>
    </div>
    <div class="info-row">
        <span>Dokter</span>
        <span>{{ $pembayaran->rekamMedis->dokter->user->name ?? 'Dokter Umum' }}</span>
    </div>
    <div class="info-row">
        <span>Pasien</span>
        <span>{{ $pembayaran->rekamMedis->pasien->user->name ?? 'Pasien' }}</span>
    </div>

    <div class="divider"></div>

    <div style="margin-bottom: 10px;">
        <strong>Diagnosa & Tindakan:</strong><br>
        {{ $pembayaran->rekamMedis->diagnosa }}
    </div>

    <div class="divider"></div>

    <div class="total-row">
        <span>TOTAL BAYAR</span>
        <span>Rp {{ number_format($pembayaran->total_biaya, 0, ',', '.') }}</span>
    </div>

    <div class="info-row" style="margin-top: 5px;">
        <span>Status</span>
        <span>LUNAS</span>
    </div>

    <div class="divider"></div>

    <div class="footer">
        <p>Terima Kasih atas kepercayaan Anda.<br>Semoga Lekas Sembuh.</p>
    </div>

    <a href="javascript:window.print()" class="btn-print">Cetak Struk</a>

</body>
</html>
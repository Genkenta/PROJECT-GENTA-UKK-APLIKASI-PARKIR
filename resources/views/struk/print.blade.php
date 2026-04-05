<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Parkir</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Barlow+Condensed:wght@400;600;700;800&family=Barlow:wght@400;500;600&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        body {
            background: #e8e8e8;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 15px;
        }

        .receipt {
            width: 300px;
            background: #fff;
            font-family: 'Share Tech Mono', monospace;
            border: 1px solid #ccc;
            position: relative;
        }

        .receipt::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image: repeating-linear-gradient(
                0deg, transparent, transparent 3px,
                rgba(0,0,0,0.015) 3px, rgba(0,0,0,0.015) 4px
            );
            pointer-events: none;
            z-index: 0;
        }

        /* HEADER */
        .header {
            border-bottom: 3px solid #000;
            padding: 14px 16px 12px;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .logo-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 4px;
        }

        .logo-p {
            width: 30px;
            height: 30px;
            border: 2.5px solid #000;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 800;
            font-size: 17px;
            color: #000;
            flex-shrink: 0;
        }

        .header h1 {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 800;
            font-size: 17px;
            letter-spacing: 3px;
            color: #000;
        }

        .header .sub {
            font-family: 'Barlow', sans-serif;
            font-size: 8px;
            letter-spacing: 4px;
            color: #333;
            font-weight: 600;
            text-transform: uppercase;
        }

        .receipt-title {
            margin-top: 8px;
            font-family: 'Barlow', sans-serif;
            font-size: 8px;
            letter-spacing: 5px;
            text-transform: uppercase;
            color: #000;
            border-top: 1px solid #000;
            padding-top: 6px;
        }

        /* BODY */
        .body {
            padding: 14px 16px;
            position: relative;
            z-index: 1;
        }

        .txn-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1.5px solid #000;
            padding: 5px 10px;
            margin-bottom: 14px;
        }

        .txn-row .lbl {
            font-family: 'Barlow', sans-serif;
            font-size: 8px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #555;
        }

        .txn-row .val {
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 1px;
            color: #000;
        }

        .sec-label {
            font-family: 'Barlow', sans-serif;
            font-size: 8px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #333;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .plate {
            border: 2px solid #000;
            padding: 7px 12px;
            text-align: center;
            margin-bottom: 14px;
            position: relative;
        }

        .plate::before, .plate::after {
            content: '●';
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 6px;
            color: #000;
        }
        .plate::before { left: 5px; }
        .plate::after  { right: 5px; }

        .plate-num {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 800;
            font-size: 24px;
            letter-spacing: 5px;
            color: #000;
        }

        .plate-jenis {
            font-family: 'Barlow', sans-serif;
            font-size: 8px;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: #555;
            margin-top: 1px;
        }

        .time-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1px;
            background: #000;
            border: 1.5px solid #000;
        }

        .time-cell {
            background: #fff;
            padding: 7px 9px;
        }

        .time-cell .tc-label {
            font-family: 'Barlow', sans-serif;
            font-size: 7px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #333;
            margin-bottom: 2px;
            font-weight: 600;
        }

        .time-cell .tc-date {
            font-size: 9px;
            color: #333;
            font-weight: 500;
        }

        .time-cell .tc-time {
            font-size: 16px;
            font-weight: bold;
            color: #000;
            line-height: 1.1;
        }

        .dur-row {
            border: 1.5px solid #000;
            border-top: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 9px;
            margin-bottom: 14px;
        }

        .dur-row .d-lbl {
            font-family: 'Barlow', sans-serif;
            font-size: 8px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #333;
            font-weight: 600;
        }

        .dur-row .d-val {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 700;
            font-size: 15px;
            color: #000;
            letter-spacing: 1px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            padding: 4px 0;
            border-bottom: 1px dotted #ccc;
        }

        .info-row:last-child { border-bottom: none; }

        .info-row .ik {
            font-family: 'Barlow', sans-serif;
            font-size: 9px;
            color: #333;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .info-row .iv {
            font-size: 11px;
            color: #000;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .dashed {
            border: none;
            border-top: 1.5px dashed #000;
            margin: 14px 0;
        }

        /* TOTAL */
        .total-block {
            border: 2px solid #000;
            padding: 10px 12px;
            margin-bottom: 14px;
        }

        .total-block::before {
            content: '▶ TOTAL BIAYA';
            display: block;
            font-family: 'Barlow', sans-serif;
            font-size: 8px;
            letter-spacing: 4px;
            color: #555;
            margin-bottom: 4px;
        }

        .total-amount {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 800;
            font-size: 34px;
            letter-spacing: 1px;
            color: #000;
            line-height: 1;
        }

        .total-amount .rp {
            font-size: 16px;
            font-weight: 600;
            margin-right: 2px;
            color: #333;
        }

        .total-status {
            font-family: 'Barlow', sans-serif;
            font-size: 9px;
            letter-spacing: 3px;
            color: #555;
            margin-top: 5px;
        }

        /* FOOTER */
        .footer {
            border-top: 3px solid #000;
            padding: 12px 16px 14px;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .op-row {
            display: flex;
            justify-content: space-between;
            font-size: 9px;
            color: #777;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        .barcode {
            display: flex;
            justify-content: center;
            align-items: flex-end;
            gap: 1.5px;
            margin: 0 auto 6px;
            height: 36px;
        }

        .b { background: #000; border-radius: 0.5px; }

        .barcode-text {
            font-size: 8px;
            color: #555;
            letter-spacing: 2px;
            margin-bottom: 10px;
        }

        .thankyou {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 700;
            font-size: 11px;
            letter-spacing: 5px;
            text-transform: uppercase;
            color: #333;
        }

        .safety {
            font-family: 'Barlow', sans-serif;
            font-size: 8px;
            color: #555;
            letter-spacing: 1px;
            margin-top: 4px;
        }

        @media print {
            @page {
                margin: 0;
                size: 80mm auto;
            }
            body {
                background: white;
                padding: 0;
                display: block;
            }
            .receipt {
                width: 100%;
                border: none;
            }
        }
    </style>
</head>
<body onload="window.print()">

<div class="receipt">

    <div class="header">
        <div class="logo-row">
            <div class="logo-p">P</div>
            <h1>SPARK ⚡</h1>
        </div>
        <div class="sub">Smart Parking System</div>
        <div class="receipt-title">Bukti Parkir Resmi</div>
    </div>

    <div class="body">

        <div class="txn-row">
            <span class="lbl">No. Transaksi</span>
            <span class="val">#{{ str_pad($transaksi->id_parkir, 6, '0', STR_PAD_LEFT) }}</span>
        </div>

        <div class="sec-label">Kendaraan</div>
        <div class="plate">
            <div class="plate-num">{{ $transaksi->kendaraan->plat_nomor ?? '-' }}</div>
            <div class="plate-jenis">{{ $transaksi->kendaraan->jenis_kendaraan ?? '-' }}</div>
        </div>

        <div class="sec-label">Waktu Parkir</div>
        <div class="time-grid">
            <div class="time-cell">
                <div class="tc-label">▶ Masuk</div>
                <div class="tc-date">{{ \Carbon\Carbon::parse($transaksi->waktu_masuk)->format('d/m/Y') }}</div>
                <div class="tc-time">{{ \Carbon\Carbon::parse($transaksi->waktu_masuk)->format('H:i') }}</div>
            </div>
            <div class="time-cell">
                <div class="tc-label">■ Keluar</div>
                <div class="tc-date">{{ \Carbon\Carbon::parse($transaksi->waktu_keluar)->format('d/m/Y') }}</div>
                <div class="tc-time">{{ \Carbon\Carbon::parse($transaksi->waktu_keluar)->format('H:i') }}</div>
            </div>
        </div>
        <div class="dur-row">
            <span class="d-lbl">Durasi</span>
            <span class="d-val">{{ $transaksi->durasi_jam }} JAM</span>
        </div>

        <div class="info-row">
            <span class="ik">Operator</span>
            <span class="iv">{{ strtoupper($transaksi->user->username ?? '-') }}</span>
        </div>
        <div class="info-row">
            <span class="ik">Metode Bayar</span>
            <span class="iv">TUNAI</span>
        </div>

        <hr class="dashed">

        <div class="total-block">
            <div class="total-amount">
                <span class="rp">Rp</span>{{ number_format($transaksi->biaya_total, 0, ',', '.') }}
            </div>
            <div class="total-status">✓ LUNAS</div>
        </div>

    </div>

    <div class="footer">
        <div class="op-row">
            <span>{{ \Carbon\Carbon::now()->format('d-m-Y') }}</span>
            <span>{{ \Carbon\Carbon::now()->format('H:i:s') }}</span>
        </div>

        <div class="barcode" id="barcode"></div>
        <div class="barcode-text">{{ str_pad($transaksi->id_parkir ?? '1', 6, '0', STR_PAD_LEFT) }}-PKR-{{ now()->format('Ymd') }}</div>

        <div class="thankyou">— Terima Kasih —</div>
        <div class="safety">Hati-hati di jalan &nbsp;•&nbsp; Jaga keselamatan Anda</div>
    </div>

</div>

<script>
    const bc = document.getElementById('barcode');
    const widths = [2,1,3,1,2,1,4,2,1,2,3,1,2,1,3,2,1,2,1,4,1,3,2,1,2,3,1,2,1,3,1,4,2,1,2,1,3,2,1];
    widths.forEach((w, i) => {
        const b = document.createElement('div');
        b.className = 'b';
        b.style.width = w + 'px';
        b.style.height = (i % 5 === 0 ? 36 : 28) + 'px';
        bc.appendChild(b);
    });
</script>

</body>
</html>
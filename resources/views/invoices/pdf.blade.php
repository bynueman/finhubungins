<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }}</title>
    <style>
        @page { size: A4 landscape; margin: 1.2cm; }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #000;
        }

        h3 {
            text-align: center;
            margin-top: 0;
        }

        .header-table td {
            vertical-align: top;
            padding: 2px 4px;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .main-table th, .main-table td {
            border: 1px solid #074d5bff;
            padding: 4px 6px;
            text-align: center;
        }


        .amount-table {
            width: 280px;
            float: right;
            margin-top: 10px;
            font-size: 11px;
        }

        .amount-table td {
            padding: 2px 6px;
        }

        .notes {
            font-size: 10px;
            margin-top: 60px;
        }

        .signature-table {
            width: 100%;
            margin-top: 50px;
            text-align: center;
        }

        .logo {
            height: 60px;
        }
    </style>
</head>
<body>

<table width="100%" class="header-table">
    <tr>
        <td width="50%">
    <table>
        <tr>
            <td style="vertical-align: top; padding-right: 8px;">
                <img src="{{ public_path('storage/logo/logo.png') }}" class="logo" alt="Logo HUBUNGINS">
            </td>
            <td style="vertical-align: top; font-size: 10px;">
                <strong>HUBUNGINS</strong><br>
                Creative Agency & Production House<br>
                Jl. Contoh No. 123, Kota<br>
                Telp : 08xx-xxxx-xxxx<br>
                Email : info@hubungins.com
            </td>
        </tr>
    </table>
</td>

        <td style="text-align: right; padding-top: 30px;">
            <table>
                <tr>
                    <td><strong>Kepada</strong></td>
                    <td>: {{ $invoice->klien->nama }}</td>
                </tr>
                <tr>
                    <td><strong>Instansi</strong></td>
                    <td>: {{ $invoice->klien->nama_instansi ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Alamat</strong></td>
                    <td>: {{ $invoice->klien->alamat ?? '-' }}</td>
                </tr>
                <tr>
                    <td><strong>Projek</strong></td>
                    <td>: {{ $invoice->projek }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table width="100%" style="margin-top: 5px;">
    <tr>
        <td><strong>No. Invoice</strong></td>
        <td>: #INV-{{ str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }}</td>
        <td style="text-align: right;" rowspan="2">
            Pembayaran via transfer<br>
            Rek. Bank contoh<br>
            a.n HUBUNGINS
        </td>
    </tr>
    <tr>
        <td><strong>Tanggal</strong></td>
        <td>: {{ $invoice->tanggal->format('d M Y') }}</td>
    </tr>
</table>

<table class="main-table">
    <thead>
        <tr>
            <th>No</th>
            <th>Deskripsi</th>
            <th>Quantity</th>
            <th>Harga</th>
            <th>Diskon</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        @if($invoice->tipe_invoice === 'detail' && $invoice->jasas->count())
            @foreach($invoice->jasas as $index => $jasa)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $jasa->nama_jasa }}</td>
                    <td>{{ $jasa->qty }}</td>
                    <td>Rp{{ number_format($jasa->biaya, 0, ',', '.') }}</td>
                    <td>-</td>
                    <td>Rp{{ number_format($jasa->biaya * $jasa->qty, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td>1</td>
                <td>{{ $invoice->projek }}</td>
                <td>1</td>
                <td>Rp{{ number_format($invoice->total_tagihan, 0, ',', '.') }}</td>
                <td>Rp{{ number_format($invoice->diskon ?? 0, 0, ',', '.') }}</td>
                <td>Rp{{ number_format($invoice->total_tagihan - ($invoice->diskon ?? 0), 0, ',', '.') }}</td>
            </tr>
        @endif
    </tbody>
</table>

<table class="amount-table">
    <tr>
        <td>Jumlah</td>
        <td style="text-align: right;">Rp{{ number_format($invoice->total_tagihan, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>Diskon</td>
        <td style="text-align: right;">Rp{{ number_format($invoice->diskon ?? 0, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td><strong>Total</strong></td>
        <td style="text-align: right;"><strong>Rp{{ number_format($invoice->total_tagihan - ($invoice->diskon ?? 0), 0, ',', '.') }}</strong></td>
    </tr>
    <tr>
        <td>Bayar</td>
        <td style="text-align: right;">Rp{{ number_format($invoice->jumlah_bayar ?? 0, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td>Kurang</td>
        <td style="text-align: right;">Rp{{ number_format($invoice->kurang_bayar ?? 0, 0, ',', '.') }}</td>
    </tr>
</table>

<div style="clear: both;"></div>

<div class="notes">
    <strong>Ket:</strong><br>
    1. Invoice ini sebagai bukti transaksi.<br>
    2. Pembayaran dapat dilakukan via cash / transfer.<br>
    3. Barang/jasa yang sudah dipesan tidak dapat dikembalikan.<br>
</div>

<table class="signature-table">
    <tr>
        <td>Pelanggan</td>
        <td>HUBUNGINS</td>
    </tr>
    <tr><td colspan="2" style="height: 40px;"></td></tr>
</table>

</body>
</html>

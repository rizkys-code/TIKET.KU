<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>E-Tiket - {{ $pemesanan->kode_booking }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #333; }
        .container { width: 100%; margin: 0 auto; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 24px; color: #8A2BE2; }
        .header p { margin: 0; font-size: 14px; }
        .card { border: 1px solid #ddd; border-radius: 8px; padding: 20px; margin-bottom: 20px; }
        .card-header { border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 10px; }
        .card-header h2 { margin: 0; font-size: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: 8px; border-bottom: 1px solid #eee; }
        th { background-color: #f8f9fa; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .status { padding: 5px 10px; border-radius: 12px; font-size: 10px; color: white; }
        .status-lunas { background-color: #28a745; }
        .status-belum { background-color: #dc3545; }
        .footer { text-align: center; font-size: 10px; color: #777; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Tiket.Ku</h1>
            <p>E-Ticket Penerbangan</p>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Detail Pemesanan</h2>
            </div>
            <table>
                <tr>
                    <td>Kode Booking</td>
                    <td class="text-right font-bold">{{ $pemesanan->kode_booking }}</td>
                </tr>
                <tr>
                    <td>Tanggal Pemesanan</td>
                    <td class="text-right">{{ \Carbon\Carbon::parse($pemesanan->created_at)->isoFormat('dddd, D MMMM YYYY, HH:mm') }}</td>
                </tr>
                <tr>
                    <td>Status Pembayaran</td>
                    <td class="text-right">
                        <span class="status {{ $pemesanan->status_pembayaran == 'Lunas' ? 'status-lunas' : 'status-belum' }}">
                            {{ $pemesanan->status_pembayaran }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class="font-bold">Total Harga</td>
                    <td class="text-right font-bold">IDR {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Detail Penerbangan</h2>
            </div>
            <table>
                <tr>
                    <td>Maskapai</td>
                    <td class="text-right font-bold">{{ $pemesanan->penerbangan->maskapai->nama_maskapai }}</td>
                </tr>
                <tr>
                    <td>Rute</td>
                    <td class="text-right">{{ $pemesanan->penerbangan->bandaraAsal->kota }} → {{ $pemesanan->penerbangan->bandaraTujuan->kota }}</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td class="text-right">{{ \Carbon\Carbon::parse($pemesanan->penerbangan->tanggal_berangkat)->isoFormat('dddd, D MMMM YYYY') }}</td>
                </tr>
                 <tr>
                    <td>Waktu Berangkat</td>
                    <td class="text-right">{{ \Carbon\Carbon::parse($pemesanan->penerbangan->waktu_berangkat)->format('H:i') }} ({{ $pemesanan->penerbangan->bandaraAsal->kode_bandara }})</td>
                </tr>
                 <tr>
                    <td>Waktu Tiba</td>
                    <td class="text-right">{{ \Carbon\Carbon::parse($pemesanan->penerbangan->waktu_tiba)->format('H:i') }} ({{ $pemesanan->penerbangan->bandaraTujuan->kode_bandara }})</td>
                </tr>
            </table>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Data Penumpang</h2>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th class="text-right">Nomor Identitas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pemesanan->penumpangs as $index => $penumpang)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $penumpang->nama }}</td>
                            <td class="text-right">{{ $penumpang->nomor_identitas }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="footer">
            <p>Terima kasih telah melakukan pemesanan melalui Tiket.Ku. Tiket ini adalah bukti pembayaran yang sah.</p>
        </div>
    </div>
</body>
</html>

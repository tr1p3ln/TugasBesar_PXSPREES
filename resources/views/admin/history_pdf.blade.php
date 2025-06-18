<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi</title>
    <style>
        body { font-family: sans-serif; margin: 0; }
        h1 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #dddddd; padding: 8px; text-align: left; font-size: 12px; }
        thead { background-color: #f2f2f2; }
        tr:nth-child(even) { background-color: #f9f9f9; }
    </style>
</head>
<body>
    <h1>Laporan Transaksi</h1>
    <p>Periode: <strong>{{ $startDate }}</strong> sampai <strong>{{ $endDate }}</strong></p>
    <hr>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tgl. Bayar</th>
                <th>Pelanggan</th>
                <th>Ruangan</th>
                <th>Jenis Konsol</th>
                <th>Status</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->paid_at ? $payment->paid_at->format('d M Y') : '-' }}</td>
                    <td>{{ $payment->booking->user->name ?? 'N/A' }}</td>
                    <td>{{ $payment->booking->room->name ?? 'N/A' }}</td>
                    <td>{{ $payment->booking->room->console_type ?? 'N/A' }}</td>
                    <td>{{ ucfirst($payment->payment_status) }}</td>
                    <td>Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">Tidak ada data pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" style="text-align: right; font-weight: bold;">Total Pendapatan</td>
                <td style="font-weight: bold;">Rp{{ number_format($totalAmount, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
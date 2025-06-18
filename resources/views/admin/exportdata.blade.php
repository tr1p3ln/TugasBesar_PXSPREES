<div style="text-align: center; margin-bottom: 20px;">
        <h1 style="margin: 0; font-size: 28px; font-weight: bold;">PSXPRESS</h1>
        <p style="margin: 0; font-size: 16px;">Laporan History Transaksi</p>
        <hr style="margin-top: 10px; border: 1px solid #000;">
    </div>
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 13px;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="border: 1px solid #000; padding: 8px;">Booking ID</th>
                <th style="border: 1px solid #000; padding: 8px;">Metode Pembayaran</th>
                <th style="border: 1px solid #000; padding: 8px;">Status Pembayaran</th>
                <th style="border: 1px solid #000; padding: 8px;">Jumlah</th>
                <th style="border: 1px solid #000; padding: 8px;">Bukti Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
            <tr>
                <td style="border: 1px solid #000; padding: 8px;">"$payment->booking_id"</td>
                <td style="border: 1px solid #000; padding: 8px;">{{ $payment->payment_method }}</td>
                <td style="border: 1px solid #000; padding: 8px;">{{ $payment->payment_status }}</td>
                <td style="border: 1px solid #000; padding: 8px;">Rp {{ number_format($payment->amount, 2, ',', '.') }}</td>
                <td style="border: 1px solid #000; padding: 8px;">
                    {{ $payment->payment_proof ? 'Ada' : 'Tidak Ada' }}
                </td>
            </tr>
            @endforeach
        </tbody>
</table>
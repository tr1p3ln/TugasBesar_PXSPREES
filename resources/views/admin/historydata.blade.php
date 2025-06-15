    <x-layouts.admin>
        <div class="table-container bg-gray-900 text-white p-5 mt-5 rounded-lg shadow-lg">
            <h5 class="mb-4 text-2xl font-bold">History Transaksi</h5>

            <table class="min-w-full bg-gray-800 rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-gray-700 text-gray-300">
                        <th class="border-b border-gray-600 px-4 py-2 text-center">Booking Id</th>
                        <th class="border-b border-gray-600 px-4 py-2 text-center">Payment Method</th>
                        <th class="border-b border-gray-600 px-4 py-2 text-center">Payment Status</th>
                        <th class="border-b border-gray-600 px-4 py-2 text-center">Amount</th>
                        <th class="border-b border-gray-600 px-4 py-2 text-center">Payment Proof</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment)
                        <tr class="hover:bg-gray-600">
                            <td class="border-b border-gray-600 px-4 py-2 text-center">{{ $payment->booking_id }}</td>
                            <td class="border-b border-gray-600 px-4 py-2 text-center">{{ $payment->payment_method }}</td>
                            <td class="border-b border-gray-600 px-4 py-2 text-center">{{ $payment->payment_status }}</td>
                            <td class="border-b border-gray-600 px-4 py-2 text-center">{{ number_format($payment->amount, 2) }}</td>
                            <td class="border-b border-gray-600 px-4 py-2 text-center">
                                @if ($payment->payment_proof)
                                    <a href="{{ asset('storage/' . $payment->payment_proof) }}" class="text-blue-500 hover:underline" target="_blank">View Proof</a>
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    <a href="{{ route('admin.exportpdf', ['filter_date' => request('filter_date')]) }}"
    target="_blank"
    class="inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
        Eksport PDF
    </a>


    </x-layouts.admin>
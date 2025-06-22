<x-layouts.admin>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header Halaman History Transaksi --}}
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-white">History Transaksi</h2>
                <p class="text-gray-400 mt-1">Lihat riwayat lengkap semua transaksi pembayaran.</p>
            </div>
            {{-- Tombol Eksport PDF --}}
            <a href="{{ route('admin.exportpdf', ['filter_date' => request('filter_date')]) }}"
                target="_blank"
                class="px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-300 inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Eksport PDF
            </a>
        </div>

        {{-- Tabel Data History Transaksi --}}
        <div class="bg-gray-800/80 backdrop-blur-sm rounded-2xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-300">
                    <thead class="text-xs text-gray-400 uppercase bg-gray-700/50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-center">Booking Id</th>
                            <th scope="col" class="px-6 py-3 text-center">Payment Method</th>
                            <th scope="col" class="px-6 py-3 text-center">Payment Status</th>
                            <th scope="col" class="px-6 py-3 text-center">Amount</th>
                            <th scope="col" class="px-6 py-3 text-center">Payment Proof</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($payments as $payment)
                            <tr class="bg-gray-800 border-b border-gray-700 hover:bg-gray-700/60 transition">
                                <td class="px-6 py-4 font-medium text-white whitespace-nowrap">{{ $payment->booking_id }}</td>
                                <td class="px-6 py-4">{{ $payment->payment_method }}</td>
                                <td class="px-6 py-4">
                                    {{-- Badge Status dengan warna dinamis --}}
                                    <span @class([
                                        'px-2 py-1 text-xs font-semibold rounded-full',
                                        'bg-green-500 text-green-900' => $payment->payment_status === 'paid',
                                        'bg-yellow-500 text-yellow-900' => $payment->payment_status === 'pending',
                                        'bg-red-500 text-red-900' => $payment->payment_status === 'failed',
                                    ])>
                                        {{ $payment->payment_status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if ($payment->payment_proof)
                                        <a href="{{ asset('storage/' . $payment->payment_proof) }}" class="font-medium text-blue-400 hover:underline" target="_blank">Lihat Bukti</a>
                                    @else
                                        <span class="text-gray-500">N/A</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-gray-800">
                                <td colspan="5" class="text-center py-8 text-gray-400">
                                    Belum ada data transaksi yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.admin>
    <div class="table-container bg-gray-900 text-white p-5 mt-5 rounded-lg shadow-lg">
        
        <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
            <h5 class="text-2xl font-bold mb-3 sm:mb-0">History Transaksi</h5>

            {{-- FORM FILTER --}}
            <form action="{{ route('admin.historydata') }}" method="GET" class="flex items-center space-x-2">
                <input type="date" name="start_date" value="{{ $start_date ?? '' }}" class="bg-gray-700 border-gray-600 text-white text-sm rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
                <input type="date" name="end_date" value="{{ $end_date ?? '' }}" class="bg-gray-700 border-gray-600 text-white text-sm rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">Filter</button>
            </form>
        </div>

        <div class="mb-4">
            <a href="{{ route('admin.exportpdf', ['start_date' => $start_date, 'end_date' => $end_date]) }}"
                target="_blank"
                class="inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                <i class="fas fa-file-pdf mr-2"></i> Eksport PDF
            </a>
        </div>


        <div class="overflow-x-auto">
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
                    @forelse ($payments as $payment)
                        <tr class="hover:bg-gray-600">
                            <td class="border-b border-gray-600 px-4 py-2 text-center">{{ $payment->booking_id }}</td>
                            <td class="border-b border-gray-600 px-4 py-2 text-center">{{ $payment->payment_method }}</td>
                            <td class="border-b border-gray-600 px-4 py-2 text-center">
                                <span @class([
                                    'px-2 py-1 text-xs font-bold rounded-full',
                                    'bg-green-500 text-green-900' => $payment->payment_status === 'paid',
                                    'bg-yellow-500 text-yellow-900' => $payment->payment_status === 'pending',
                                    'bg-red-500 text-red-900' => $payment->payment_status === 'failed',
                                    'bg-gray-500 text-gray-900' => $payment->payment_status === 'refunded',
                                ])>
                                    {{ ucfirst($payment->payment_status) }}
                                </span>
                            </td>
                            <td class="border-b border-gray-600 px-4 py-2 text-center">Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td class="border-b border-gray-600 px-4 py-2 text-center">
                                @if ($payment->payment_proof)
                                    <a href="{{ asset('storage/' . $payment->payment_proof) }}" class="text-blue-500 hover:underline" target="_blank">View Proof</a>
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center p-5 text-gray-400">
                                Tidak ada data transaksi untuk ditampilkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Tombol ekspor lama di bagian bawah sudah dihapus --}}

    </div>
</x-layouts.admin>

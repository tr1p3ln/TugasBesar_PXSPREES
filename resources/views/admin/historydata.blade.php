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

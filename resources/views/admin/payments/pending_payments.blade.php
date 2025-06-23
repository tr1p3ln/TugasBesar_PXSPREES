<x-layouts.admin>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header Halaman Konfirmasi Pembayaran --}}
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-white">Konfirmasi Pembayaran</h2>
                <p class="text-gray-400 mt-1">Kelola dan konfirmasi pembayaran yang tertunda.</p>
            </div>
            {{-- Tombol atau Aksi Tambahan (Opsional) --}}
            {{-- Jika ada tombol untuk melihat semua transaksi (termasuk yang sudah dikonfirmasi/gagal), bisa ditambahkan di sini --}}
            {{-- <a href="{{ route('admin.historydata') }}" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300 inline-flex items-center">
                Lihat Semua Histori Pembayaran
            </a> --}}
        </div>

        {{-- Notifikasi Sukses/Error --}}
        @if (session('success'))
            <div class="bg-green-800/80 border border-green-600 text-green-200 px-4 py-3 rounded-lg mb-6" role="alert">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-900/50 border border-red-700 text-red-300 px-4 py-3 rounded-lg mb-6" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        {{-- Tabel Data Pembayaran untuk Konfirmasi --}}
        <div class="bg-gray-800/80 backdrop-blur-sm rounded-2xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-300">
                    <thead class="text-xs text-gray-400 uppercase bg-gray-700/50">
                        <tr>
                            <th scope="col" class="px-6 py-3">ID Pembayaran</th>
                            <th scope="col" class="px-6 py-3">Pemesan</th>
                            <th scope="col" class="px-6 py-3">Ruangan</th>
                            <th scope="col" class="px-6 py-3">Metode Pembayaran</th>
                            <th scope="col" class="px-6 py-3">Jumlah</th>
                            <th scope="col" class="px-6 py-3 text-center">Bukti Pembayaran</th>
                            <th scope="col" class="px-6 py-3 text-center">Status Pembayaran</th>
                            <th scope="col" class="px-6 py-3 text-center">Aksi Konfirmasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($paymentsToConfirm as $payment)
                            <tr class="bg-gray-800 border-b border-gray-700 hover:bg-gray-700/60 transition">
                                <td class="px-6 py-4 font-medium text-white whitespace-nowrap">{{ $payment->id }}</td>
                                <td class="px-6 py-4">{{ $payment->booking->user->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4">{{ $payment->booking->room->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 uppercase">{{ $payment->payment_method }}</td>
                                <td class="px-6 py-4">Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if ($payment->payment_proof)
                                        <a href="{{ asset('storage/' . $payment->payment_proof) }}" class="font-medium text-blue-400 hover:underline" target="_blank">Lihat Bukti</a>
                                    @else
                                        <span class="text-gray-500">Tidak Ada</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{-- Badge Status --}}
                                    <span @class([
                                        'px-2 py-1 text-xs font-semibold rounded-full',
                                        'bg-yellow-500 text-yellow-900' => $payment->payment_status === 'pending',
                                        'bg-green-500 text-green-900' => $payment->payment_status === 'paid',
                                        'bg-red-500 text-red-900' => $payment->payment_status === 'failed',
                                    ])>
                                        {{ $payment->payment_status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{-- Form untuk Update Status Pembayaran --}}
                                    <form action="{{ route('admin.payments.updateStatus', $payment->id) }}" method="POST" class="flex flex-col items-center justify-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="w-32 px-2 py-1 text-xs rounded-md bg-gray-600 text-white border border-gray-500 focus:border-purple-500 focus:ring-purple-500 mb-2">
                                            <option value="pending" @if($payment->payment_status == 'pending') selected @endif>Pending</option>
                                            <option value="paid" @if($payment->payment_status == 'paid') selected @endif>Paid</option>
                                            <option value="failed" @if($payment->payment_status == 'failed') selected @endif>Failed</option>
                                        </select>
                                        <button type="submit" class="p-1.5 bg-purple-600 hover:bg-purple-700 rounded-md" title="Update Status">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-gray-800">
                                <td colspan="8" class="text-center py-8 text-gray-400">
                                    Tidak ada pembayaran 'pending' yang membutuhkan konfirmasi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.admin>

<x-layouts.admin>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header Halaman dengan Filter --}}
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div>
                <h2 class="text-3xl font-bold text-white">Data Booking & Pembayaran</h2>
                <p class="text-gray-400 mt-1">Lihat riwayat booking dan kelola status pembayaran.</p>
            </div>
            <form method="GET" action="{{ route('admin.bookingdata') }}" class="mt-4 md:mt-0">
                <div class="flex flex-wrap items-center gap-2">
                    {{-- Filter Status --}}
                    <select name="filter_status" id="filter_status" class="w-full sm:w-auto rounded-lg px-3 py-2 bg-gray-700/50 text-white border-2 border-gray-600 focus:border-purple-500 focus:ring-purple-500 transition">
                        <option value="">Semua Status</option>
                        <option value="pending" @if(request('filter_status') == 'pending') selected @endif>Pending</option>
                        <option value="confirmed" @if(request('filter_status') == 'confirmed') selected @endif>Confirmed</option>
                        <option value="cancelled" @if(request('filter_status') == 'cancelled') selected @endif>Cancelled</option>
                    </select>

                    {{-- Filter Tanggal --}}
                    <input type="date" name="filter_date" id="filter_date" value="{{ request('filter_date') }}" class="w-full sm:w-auto rounded-lg px-3 py-2 bg-gray-700/50 text-white border-2 border-gray-600 focus:border-purple-500 focus:ring-purple-500 transition">
                    
                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition">Filter</button>
                    @if(request('filter_date') || request('filter_status'))
                        <a href="{{ route('admin.bookingdata') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">Reset</a>
                    @endif
                </div>
            </form>
        </div>
        
        @if (session('success'))
            <div class="bg-green-800/80 border border-green-600 text-green-200 px-4 py-3 rounded-lg mb-6" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-gray-800/80 backdrop-blur-sm rounded-2xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-300">
                    <thead class="text-xs text-gray-400 uppercase bg-gray-700/50">
                        <tr>
                            <th scope="col" class="px-6 py-4">Pelanggan</th>
                            <th scope="col" class="px-6 py-4">Detail Booking</th>
                            <th scope="col" class="px-6 py-4 text-center">Status Pembayaran</th>
                            <th scope="col" class="px-6 py-4 text-center">Bukti Pembayaran</th>
                            <th scope="col" class="px-6 py-4 text-center">Aksi Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bookings as $booking)
                            <tr class="bg-gray-800 border-b border-gray-700 hover:bg-gray-700/60 transition">
                                <td class="px-6 py-4 font-medium text-white whitespace-nowrap">
                                    {{ $booking->user->name }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-semibold">{{ $booking->room->name }}</div>
                                    <div class="text-xs text-gray-400">{{ $booking->start_time->format('d M Y, H:i') }} ({{ $booking->duration_hour }} Jam)</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{-- Cek jika ada data payment --}}
                                    @if($booking->payment)
                                        <span @class([
                                            'px-2.5 py-1 text-xs font-bold leading-none rounded-full',
                                            'bg-yellow-500 text-yellow-900' => $booking->payment->payment_status === 'pending',
                                            'bg-green-500 text-green-900' => $booking->payment->payment_status === 'paid',
                                            'bg-red-500 text-red-900' => $booking->payment->payment_status === 'failed',
                                        ])>
                                            {{ ucfirst($booking->payment->payment_status) }}
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 text-xs font-bold leading-none rounded-full bg-gray-600 text-gray-200">No Payment</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($booking->payment && $booking->payment->payment_proof)
                                        <a href="{{ Storage::url($booking->payment->payment_proof) }}" target="_blank" class="font-medium text-blue-400 hover:underline inline-flex items-center gap-1">
                                            Lihat Bukti
                                        </a>
                                    @else
                                        <span class="text-gray-500 text-xs">Belum diunggah</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{-- Tampilkan form hanya jika ada data payment --}}
                                    @if($booking->payment)
                                        <form action="{{ route('admin.payments.updateStatus', $booking->payment->id) }}" method="POST" class="flex items-center justify-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="w-28 px-2 py-1 text-xs rounded-md bg-gray-600 text-white border border-gray-500 focus:border-purple-500 focus:ring-purple-500">
                                                <option value="pending" @if($booking->payment->payment_status == 'pending') selected @endif>Pending</option>
                                                <option value="paid" @if($booking->payment->payment_status == 'paid') selected @endif>Paid</option>
                                                <option value="failed" @if($booking->payment->payment_status == 'failed') selected @endif>Failed</option>
                                            </select>
                                            <button type="submit" class="p-1.5 bg-blue-600 hover:bg-blue-700 rounded-md text-white" title="Simpan Status">
                                                Simpan
                                            </button>
                                        </form>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-gray-800">
                                <td colspan="5" class="text-center py-10 text-gray-400">
                                    Tidak ada data untuk ditampilkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.admin>

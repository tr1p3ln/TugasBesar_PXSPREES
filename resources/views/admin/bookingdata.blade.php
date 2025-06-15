<x-layouts.admin>
    <!-- TABLE DATA -->
    <div class="table-container bg-gray-900 text-white p-5 mt-5 rounded-lg shadow-lg">
        <h5 class="mb-4 text-2xl font-bold">Booking Data</h5>

        <form method="GET" action="{{ route('admin.bookingdata') }}" class="mb-5">
            <div class="flex items-center gap-3">
                <label for="filter_date" class="text-white">Filter Waktu Mulai Booking:</label>
                <input type="date" name="filter_date" id="filter_date" value="{{ request('filter_date') }}" class="rounded px-3 py-2 bg-gray-800 text-white border border-gray-600">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Filter</button>
                @if(request('filter_date'))
                    <a href="{{ route('admin.bookingdata') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Reset</a>
                @endif
            </div>
        </form>

        @if($bookings->isEmpty())
            <div class="bg-gray-800 p-4 rounded-lg text-center text-gray-300">
                Tidak ada data booking untuk tanggal yang dipilih.
            </div>
        @else
            <table class="min-w-full bg-gray-800 rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-gray-700 text-gray-300">
                        <th class="border-b border-gray-600 px-4 py-2 text-center">User Id</th>
                        <th class="border-b border-gray-600 px-4 py-2 text-center">Voucher Id</th>
                        <th class="border-b border-gray-600 px-4 py-2 text-center">Waktu Mulai</th>
                        <th class="border-b border-gray-600 px-4 py-2 text-center">Durasi (Jam)</th>
                        <th class="border-b border-gray-600 px-4 py-2 text-center">Status</th>
                        <th class="border-b border-gray-600 px-4 py-2 text-center">Total Harga</th>
                        <th class="border-b border-gray-600 px-4 py-2 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                        <tr class="hover:bg-gray-600">
                            <td class="border-b border-gray-600 px-4 py-2 text-center">{{ $booking->user_id }}</td>
                            <td class="border-b border-gray-600 px-4 py-2 text-center">{{ $booking->voucher_id }}</td>
                            <td class="border-b border-gray-600 px-4 py-2 text-center">{{ \Carbon\Carbon::parse($booking->start_time)->format('Y-m-d H:i') }}</td>
                            <td class="border-b border-gray-600 px-4 py-2 text-center">{{ $booking->duration_hour }}</td>
                            <td class="border-b border-gray-600 px-4 py-2 text-center">{{ ucfirst($booking->status) }}</td>
                            <td class="border-b border-gray-600 px-4 py-2 text-center">{{ number_format($booking->total_price, 2) }}</td>
                            <td class="border-b border-gray-600 p-4 text-center">
                                <a href="#" class="inline-block px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition duration-300">Edit</a>
                                <a href="#" class="inline-block px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition duration-300 ml-2">Hapus</a>
                            </td>  
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-layouts.admin>
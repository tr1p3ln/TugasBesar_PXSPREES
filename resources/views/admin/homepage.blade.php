<x-layouts.admin>
    <style>
        body {
            background-color: black;
            color: white;
        }
    </style>

    <div class="grid grid-cols-3 gap-4 mt-3">
        <div class="stat-card bg-blue-800 p-4 rounded shadow text-center"> <!-- Changed color to blue -->
            <div class="text-lg font-semibold">TOTAL BOOKING</div>
            <div class="text-2xl font-bold mt-2">{{ $totalBooking }}</div>
        </div>
        <div class="stat-card bg-green-800 p-4 rounded shadow text-center"> <!-- Changed color to green -->
            <div class="text-lg font-semibold">KEUNTUNGAN</div>
            <div class="text-2xl font-bold mt-2">$4567</div> <!-- Replace 4567 with dynamic data -->
        </div>
        <div class="stat-card bg-red-800 p-4 rounded shadow text-center"> <!-- Changed color to red -->
            <div class="text-lg font-semibold">PESANAN MASUK</div>
            <div class="text-2xl font-bold mt-2">89</div> <!-- Replace 89 with dynamic data -->
        </div>
    </div>

    <div class="chart-area mt-5 bg-gray-800 p-4 rounded shadow">
        <h5 class="mb-4 font-semibold text-white">Chart Area</h5>
        <div id="chart" style="height: 300px;">
            <!-- Your chart implementation goes here -->
        </div>
    </div>

    <div class="table-container bg-gray-800 p-5 mt-5 rounded shadow">
        <h5 class="mb-4 font-semibold text-white">Data Transaksi</h5>
        <table class="w-full border-collapse border border-gray-600">
            <thead class="bg-gray-700">
                <tr>
                    <th class="border border-gray-600 p-2 text-white">No</th>
                    <th class="border border-gray-600 p-2 text-white">Nama Pelanggan</th>
                    <th class="border border-gray-600 p-2 text-white">Jenis Console</th>
                    <th class="border border-gray-600 p-2 text-white">Ruangan</th>
                    <th class="border border-gray-600 p-2 text-white">Tanggal</th>
                    <th class="border border-gray-600 p-2 text-white">Status</th>
                    <th class="border border-gray-600 p-2 text-white">Total</th>
                </tr>
            </thead>
            <tbody class="bg-gray-900 text-white">
                <!-- Data loop di sini -->
            </tbody>
        </table>
    </div>
</x-layouts.admin>
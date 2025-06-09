<x-layouts.admin>
    <style>
        body {
            background-color: black;
            color: white;
        }
    </style>

    <div class="grid grid-cols-3 gap-4 mt-3">
        <div class="stat-card bg-gray-800 p-4 rounded shadow text-white">TOTAL BOOKING</div>
        <div class="stat-card bg-gray-800 p-4 rounded shadow text-white">KEUNTUNGAN</div>
        <div class="stat-card bg-gray-800 p-4 rounded shadow text-white">PESANAN MASUK</div>
    </div>

    <div class="chart-area mt-5 bg-gray-800 p-4 rounded shadow">
        <!-- Replace with your chart code -->
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
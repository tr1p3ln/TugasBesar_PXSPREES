<x-layouts.admin>
    <div class="grid grid-cols-3 gap-4 mt-3">
        <div class="stat-card bg-white p-4 rounded shadow">TOTAL BOOKING</div>
        <div class="stat-card bg-white p-4 rounded shadow">KEUNTUNGAN</div>
        <div class="stat-card bg-white p-4 rounded shadow">PESANAN MASUK</div>
    </div>

    <div class="table-container bg-white p-5 mt-5 rounded shadow">
        <h5 class="mb-4 font-semibold">Data Transaksi</h5>
        <table class="w-full border-collapse border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-300 p-2">No</th>
                    <th class="border border-gray-300 p-2">Nama Pelanggan</th>
                    <th class="border border-gray-300 p-2">Jenis Console</th>
                    <th class="border border-gray-300 p-2">Ruangan</th>
                    <th class="border border-gray-300 p-2">Tanggal</th>
                    <th class="border border-gray-300 p-2">Status</th>
                    <th class="border border-gray-300 p-2">Total</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data loop di sini -->
            </tbody>
        </table>
    </div>

    <div class="chart-area mt-5 bg-white p-4 rounded shadow">
        <!-- Chart -->
    </div>
</x-layouts.admin>

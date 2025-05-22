<x-layouts.admin>
  <!-- Table -->
  <div class="table-container bg-white p-5 mt-5 rounded shadow">
    <h5 class="text-center mb-5 font-semibold">RIWAYAT TRANSAKSI</h5>
    <table class="w-full border-collapse border border-gray-200 text-center">
      <thead class="bg-gray-100">
        <tr>
          <th class="border border-gray-300 p-2">Nama</th>
          <th class="border border-gray-300 p-2">Tanggal Booking</th>
          <th class="border border-gray-300 p-2">Total</th>
          <th class="border border-gray-300 p-2">Jam</th>
        </tr>
      </thead>
      <tbody>
        <!-- Data loop di sini -->
      </tbody>
    </table>

    <div class="text-right mt-4">
      <button class="inline-block px-4 py-2 border border-gray-400 rounded hover:bg-gray-100">Eksport PDF</button>
    </div>
  </div>
</x-layouts.admin>

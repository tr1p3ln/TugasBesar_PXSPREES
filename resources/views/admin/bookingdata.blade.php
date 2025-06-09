<x-layouts.admin>
  <!-- TABLE DATA -->
  <div class="table-container bg-black p-5 mt-5 rounded shadow">
    <h5 class="mb-4 font-semibold text-white">Data Booking</h5>
    <table class="w-full border-collapse border border-gray-600">
      <thead class="bg-gray-800">
        <tr>
          <th class="border border-gray-600 p-2 text-white">Nama Pelanggan</th>
          <th class="border border-gray-600 p-2 text-white">Jenis Console</th>
          <th class="border border-gray-600 p-2 text-white">Ruangan</th>
          <th class="border border-gray-600 p-2 text-white">Tanggal</th>
          <th class="border border-gray-600 p-2 text-white">Status</th>
        </tr>
      </thead>
      <tbody class="bg-gray-900 text-white">
        <!-- Data loop di sini -->
      </tbody>
    </table>
  </div>
</x-layouts.admin>

<style>
  body {
    background-color: black; /* Sets global background color */
    color: white; /* Sets global text color */
  }
</style>
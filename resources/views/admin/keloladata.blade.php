<x-layouts.admin>
  <!-- TABLE DATA -->
  <div class="table-container bg-white p-5 mt-5 rounded shadow">
    <h5 class="mb-4 font-semibold">Kelola DATA</h5>

    <div class="text-right mt-3">
      <a href="create.html" class="inline-block px-4 py-2 border border-gray-400 rounded hover:bg-gray-100">Tambah Data</a>
    </div>

    <table class="w-full border-collapse border border-gray-200 mt-4">
      <thead class="bg-gray-100">
        <tr>
          <th class="border border-gray-300 p-2">Nama Ruangan</th>
          <th class="border border-gray-300 p-2">Jenis Console</th>
          <th class="border border-gray-300 p-2">Harga Sewa</th>
          <th class="border border-gray-300 p-2">Jam</th>
          <th class="border border-gray-300 p-2">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <!-- Loop data ruangan di sini -->
      </tbody>
    </table>
  </div>
</x-layouts.admin>

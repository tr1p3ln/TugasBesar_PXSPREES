<x-layouts.admin>
  <div class="content ml-52 p-5">
    <!-- CREATE DATA FORM -->
    <div class="form-container bg-black text-white p-8 mt-5 rounded shadow">
      <h5 class="text-lg font-semibold mb-5">Create Voucher</h5>
      <form action="process_create.php" method="POST" enctype="multipart/form-data">
        <div class="mb-4">
          <label for="voucher" class="block text-sm font-medium text-gray-300 mb-1">Nama Voucher</label>
          <input type="text" class="w-full px-3 py-2 border border-gray-600 bg-gray-800 text-white rounded" id="voucher" name="voucher" required>
        </div>
        <div class="mb-4">
          <label for="description" class="block text-sm font-medium text-gray-300 mb-1">Deskripsi</label>
          <input type="text" class="w-full px-3 py-2 border border-gray-600 bg-gray-800 text-white rounded" id="description" name="description" required>
        </div>
        <div class="mb-4">
          <label for="point" class="block text-sm font-medium text-gray-300 mb-1">Point</label>
          <input type="number" class="w-full px-3 py-2 border border-gray-600 bg-gray-800 text-white rounded" id="point" name="point" required min="0">
        </div>
        <div class="mb-4">
          <label for="code" class="block text-sm font-medium text-gray-300 mb-1">Voucher Code</label>
          <input type="text" class="w-full px-3 py-2 border border-gray-600 bg-gray-800 text-white rounded" id="code" name="code" required>
        </div>
        <div class="mb-4">
          <label for="valid_date" class="block text-sm font-medium text-gray-300 mb-1">Tanggal Berlaku</label>
          <input type="date" class="w-full px-3 py-2 border border-gray-600 bg-gray-800 text-white rounded" id="valid_date" name="valid_date" required>
        </div>

        <div class="text-right mt-5">
          <button type="submit" class="px-4 py-2 border border-gray-400 rounded hover:bg-gray-700">Save</button>
        </div>
      </form>
    </div>
  </div>
</x-layouts.admin>
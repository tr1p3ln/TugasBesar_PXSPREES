    <x-layouts.admin>
        <div class="form-container bg-black text-white p-8 mt-5 rounded shadow max-w-3xl mx-auto">
            <h5 class="text-lg font-semibold mb-5">Buat Voucher Baru</h5>

            {{-- Tampilkan Error Validasi --}}
            @if ($errors->any())
                <div class="bg-red-500 text-white p-4 rounded-lg mb-6">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form Input --}}
            <form action="{{ route('admin.vouchers.create') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                @csrf

                {{-- Nama Voucher --}}
                <div class="mb-4">
                    <label for="nama_voucher" class="block text-sm font-medium text-gray-300 mb-1">Nama Voucher</label>
                    <input type="text" name="nama_voucher" id="nama_voucher" required
                            class="w-full px-3 py-2 border border-gray-600 bg-gray-800 text-white rounded"
                            value="{{ old('nama_voucher') }}">
                </div>

                {{-- Deskripsi --}}
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-300 mb-1">Deskripsi</label>
                    <input type="text" name="description" id="description" required
                            class="w-full px-3 py-2 border border-gray-600 bg-gray-800 text-white rounded"
                            value="{{ old('description') }}">
                </div>

                {{-- Point Required --}}
                <div class="mb-4">
                    <label for="point_required" class="block text-sm font-medium text-gray-300 mb-1">Point Dibutuhkan</label>
                    <input type="number" name="point_required" id="point_required" required min="0"
                            class="w-full px-3 py-2 border border-gray-600 bg-gray-800 text-white rounded"
                            value="{{ old('point_required') }}">
                </div>

                {{-- Voucher Code --}}
                <div class="mb-4">
                    <label for="voucher_code" class="block text-sm font-medium text-gray-300 mb-1">Kode Voucher</label>
                    <input type="text" name="voucher_code" id="voucher_code" required
                            class="w-full px-3 py-2 border border-gray-600 bg-gray-800 text-white rounded"
                            value="{{ old('voucher_code') }}">
                </div>

                {{-- Discount Amount --}}
                <div class="mb-4">
                    <label for="discount_amount" class="block text-sm font-medium text-gray-300 mb-1">Jumlah Diskon</label>
                    <input type="number" name="discount_amount" id="discount_amount" required step="0.01" min="0"
                            class="w-full px-3 py-2 border border-gray-600 bg-gray-800 text-white rounded"
                            value="{{ old('discount_amount') }}">
                </div>

                {{-- Start Date --}}
                <div class="mb-4">
                    <label for="start_date" class="block text-sm font-medium text-gray-300 mb-1">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="start_date" required
                            class="w-full px-3 py-2 border border-gray-600 bg-gray-800 text-white rounded"
                            value="{{ old('start_date') }}">
                </div>

                {{-- End Date --}}
                <div class="mb-4">
                    <label for="end_date" class="block text-sm font-medium text-gray-300 mb-1">Tanggal Selesai</label>
                    <input type="date" name="end_date" id="end_date" required
                            class="w-full px-3 py-2 border border-gray-600 bg-gray-800 text-white rounded"
                            value="{{ old('end_date') }}">
                </div>

                {{-- Status Aktif --}}
                <div class="mb-4">
                    <label for="is_active" class="block text-sm font-medium text-gray-300 mb-1">Status</label>
                    <select name="is_active" id="is_active" required
                            class="w-full px-3 py-2 border border-gray-600 bg-gray-800 text-white rounded">
                        <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>

                {{-- Tombol --}}
                <div class="flex justify-end space-x-4 mt-6">
                    <a href="{{ route('admin.voucher') }}" 
                        class="px-6 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition duration-300">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition duration-300">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </x-layouts.admin>

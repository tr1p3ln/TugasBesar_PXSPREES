<x-layouts.admin>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-gray-800 rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold text-white mb-6">Edit Voucher</h2>

            @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded-lg mb-6">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('admin.vouchers.update', $voucher->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="nama_voucher" class="block text-white mb-2">Nama Voucher</label>
                    <input type="text" name="nama_voucher" id="nama_voucher"
                        class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600 focus:border-blue-500 focus:outline-none"
                        value="{{ old('nama_voucher', $voucher->nama_voucher) }}" required>
                </div>

                <div>
                    <label for="description" class="block text-white mb-2">Description</label>
                    <input type="text" name="description" id="description"
                        class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600 focus:border-blue-500 focus:outline-none"
                        value="{{ old('description', $voucher->description) }}" required>
                </div>

                <div>
                    <label for="voucher_code" class="block text-white mb-2">Kode Voucher</label>
                    <input type="text" name="voucher_code" id="voucher_code"
                        class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600 focus:border-blue-500 focus:outline-none"
                        value="{{ old('voucher_code', $voucher->voucher_code) }}" required>
                </div>

                <div>
                    <label for="discount_amount" class="block text-white mb-2">Diskon (Rp)</label>
                    <input type="number" name="discount_amount" id="discount_amount"
                        class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600 focus:border-blue-500 focus:outline-none"
                        value="{{ old('discount_amount', $voucher->discount_amount) }}" min="0" required>
                </div>

                <div>
                    <label for="point_required" class="block text-white mb-2">Poin Diperlukan</label>
                    <input type="number" name="point_required" id="point_required"
                        class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600 focus:border-blue-500 focus:outline-none"
                        value="{{ old('point_required', $voucher->point_required) }}" min="0" required>
                </div>

                <div>
                    <label for="start_date" class="block text-white mb-2">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="start_date"
                        class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600 focus:border-blue-500 focus:outline-none"
                        value="{{ old('start_date', $voucher->start_date) }}" required>
                </div>

                <div>
                    <label for="end_date" class="block text-white mb-2">Tanggal Berakhir</label>
                    <input type="date" name="end_date" id="end_date"
                        class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600 focus:border-blue-500 focus:outline-none"
                        value="{{ old('end_date', $voucher->end_date) }}" required>
                </div>

                <div>
                    <label for="is_active" class="block text-white mb-2">Aktif</label>
                    <select name="is_active" id="is_active"
                        class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600 focus:border-blue-500 focus:outline-none" required>
                        <option value="1" {{ old('is_active', $voucher->is_active) == 1 ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('is_active', $voucher->is_active) == 0 ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.vouchers.index') }}"
                        class="px-6 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition duration-300">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition duration-300">
                        Simpan Perubahan
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-layouts.admin>
<x-layouts.admin>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div
            class="max-w-3xl mx-auto bg-gray-800/80 backdrop-blur-sm rounded-2xl shadow-2xl shadow-purple-900/10 overflow-hidden">
            <div class="p-6 sm:p-8">
                <div class="mb-8 text-center">
                    <h2 class="text-3xl font-bold text-white">Tambah Voucher Baru</h2>
                    <p class="text-gray-400 mt-2">Isi detail di bawah untuk membuat voucher baru.</p>
                </div>

                {{-- Menampilkan pesan error validasi --}}
                @if ($errors->any())
                    <div class="bg-red-900/50 border border-red-700 text-red-300 px-4 py-3 rounded-lg mb-6"
                        role="alert">
                        <strong class="font-bold">Oops! Terjadi kesalahan.</strong>
                        <ul class="mt-2 list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Form untuk membuat voucher baru --}}
                <form action="{{ route('admin.vouchers.store') }}" method="POST" class="space-y-6"
                    enctype="multipart/form-data">
                    @csrf

                    {{-- Nama Voucher --}}
                    <div>
                        <label for="nama_voucher" class="block text-sm font-medium text-gray-300 mb-2">Nama
                            Voucher</label>
                        <input type="text" name="nama_voucher" id="nama_voucher"
                            class="w-full px-4 py-3 rounded-lg bg-gray-700/50 text-white border-2 border-gray-600 focus:border-purple-500 focus:ring-purple-500 focus:outline-none transition placeholder-gray-400"
                            placeholder="Contoh: Diskon Akhir Tahun" value="{{ old('nama_voucher') }}" required>
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-300 mb-2">Deskripsi</label>
                        <textarea name="description" id="description" rows="3"
                            class="w-full px-4 py-3 rounded-lg bg-gray-700/50 text-white border-2 border-gray-600 focus:border-purple-500 focus:ring-purple-500 focus:outline-none transition placeholder-gray-400"
                            placeholder="Jelaskan detail voucher ini..." required>{{ old('description') }}</textarea>
                    </div>

                    {{-- Grid untuk Point Dibutuhkan dan Jumlah Diskon --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Point Required --}}
                        <div>
                            <label for="point_required" class="block text-sm font-medium text-gray-300 mb-2">Point
                                Dibutuhkan</label>
                            <input type="number" name="point_required" id="point_required"
                                class="w-full px-4 py-3 rounded-lg bg-gray-700/50 text-white border-2 border-gray-600 focus:border-purple-500 focus:ring-purple-500 focus:outline-none transition placeholder-gray-400"
                                placeholder="Contoh: 100" value="{{ old('point_required') }}" min="0" required>
                        </div>

                        {{-- Discount Amount --}}
                        <div>
                            <label for="discount_amount" class="block text-sm font-medium text-gray-300 mb-2">Jumlah
                                Diskon</label>
                            <input type="number" name="discount_amount" id="discount_amount" step="0.01" min="0"
                                class="w-full px-4 py-3 rounded-lg bg-gray-700/50 text-white border-2 border-gray-600 focus:border-purple-500 focus:ring-purple-500 focus:outline-none transition placeholder-gray-400"
                                placeholder="Contoh: 10000" value="{{ old('discount_amount') }}" required>
                        </div>
                    </div>

                    {{-- Voucher Code --}}
                    <div>
                        <label for="voucher_code" class="block text-sm font-medium text-gray-300 mb-2">Kode
                            Voucher</label>
                        <input type="text" name="voucher_code" id="voucher_code"
                            class="w-full px-4 py-3 rounded-lg bg-gray-700/50 text-white border-2 border-gray-600 focus:border-purple-500 focus:ring-purple-500 focus:outline-none transition placeholder-gray-400"
                            placeholder="Contoh: VOUCHER50K" value="{{ old('voucher_code') }}" required>
                    </div>

                    {{-- Grid untuk Tanggal Mulai dan Tanggal Selesai --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Start Date --}}
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-300 mb-2">Tanggal
                                Mulai</label>
                            <input type="date" name="start_date" id="start_date"
                                class="w-full px-4 py-3 rounded-lg bg-gray-700/50 text-white border-2 border-gray-600 focus:border-purple-500 focus:ring-purple-500 focus:outline-none transition placeholder-gray-400"
                                value="{{ old('start_date') }}" min="{{ date('Y-m-d') }}" required>
                        </div>

                        {{-- End Date --}}
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-300 mb-2">Tanggal
                                Selesai</label>
                            <input type="date" name="end_date" id="end_date"
                                class="w-full px-4 py-3 rounded-lg bg-gray-700/50 text-white border-2 border-gray-600 focus:border-purple-500 focus:ring-purple-500 focus:outline-none transition placeholder-gray-400"
                                value="{{ old('end_date') }}" min="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    {{-- Status Aktif --}}
                    <div>
                        <label for="is_active" class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                        <select name="is_active" id="is_active"
                            class="w-full px-4 py-3 rounded-lg bg-gray-700/50 text-white border-2 border-gray-600 focus:border-purple-500 focus:ring-purple-500 focus:outline-none transition placeholder-gray-400"
                            required>
                            <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex justify-end space-x-4 pt-4">
                        <a href="{{ route('admin.voucher') }}"
                            class="px-8 py-3 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-300">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-8 py-3 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition duration-300">
                            Simpan Voucher
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.admin>

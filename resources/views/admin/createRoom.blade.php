<x-layouts.admin>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div
            class="max-w-3xl mx-auto bg-gray-800/80 backdrop-blur-sm rounded-2xl shadow-2xl shadow-purple-900/10 overflow-hidden">
            <div class="p-6 sm:p-8">
                <div class="mb-8 text-center">
                    <h2 class="text-3xl font-bold text-white">Tambah Ruangan Baru</h2>
                    <p class="text-gray-400 mt-2">Isi detail di bawah untuk menambahkan ruangan ke dalam sistem.</p>
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

                {{-- Form untuk menambah ruangan --}}
                <form action="{{ route('admin.rooms.store') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- Nama Ruangan --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Nama Ruangan</label>
                        <input type="text" name="name" id="name"
                            class="w-full px-4 py-3 rounded-lg bg-gray-700/50 text-white border-2 border-gray-600 focus:border-purple-500 focus:ring-purple-500 focus:outline-none transition"
                            placeholder="Contoh: Ruang PS-1 atau VIP Room A" value="{{ old('name') }}" required>
                    </div>

                    {{-- Grid untuk Tipe Konsol dan Harga --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Tipe Konsol --}}
                        <div>
                            <label for="console_type" class="block text-sm font-medium text-gray-300 mb-2">Tipe
                                Konsol</label>
                            <select name="console_type" id="console_type"
                                class="w-full px-4 py-3 rounded-lg bg-gray-700/50 text-white border-2 border-gray-600 focus:border-purple-500 focus:ring-purple-500 focus:outline-none transition"
                                required>
                                <option value="" disabled selected>Pilih Tipe</option>
                                <option value="Playstation" @if (old('console_type') == 'Playstation') selected @endif>
                                    Playstation</option>
                                <option value="Nintendo" @if (old('console_type') == 'Nintendo') selected @endif>Nintendo
                                </option>
                                <option value="VIP" @if (old('console_type') == 'VIP') selected @endif>VIP</option>
                            </select>
                        </div>

                        {{-- Harga per Jam --}}
                        <div>
                            <label for="price_per_hour" class="block text-sm font-medium text-gray-300 mb-2">Harga per
                                Jam (Rp)</label>
                            <input type="number" name="price_per_hour" id="price_per_hour"
                                class="w-full px-4 py-3 rounded-lg bg-gray-700/50 text-white border-2 border-gray-600 focus:border-purple-500 focus:ring-purple-500 focus:outline-none transition"
                                placeholder="Contoh: 50000" value="{{ old('price_per_hour') }}" min="0"
                                step="1000" required>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-300 mb-2">Deskripsi</label>
                        <textarea name="description" id="description" rows="4"
                            class="w-full px-4 py-3 rounded-lg bg-gray-700/50 text-white border-2 border-gray-600 focus:border-purple-500 focus:ring-purple-500 focus:outline-none transition"
                            placeholder="Jelaskan fasilitas yang ada di ruangan ini..." required>{{ old('description') }}</textarea>
                    </div>

                    {{-- Status --}}
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-300 mb-2">Status Awal</label>
                        <select name="status" id="status"
                            class="w-full px-4 py-3 rounded-lg bg-gray-700/50 text-white border-2 border-gray-600 focus:border-purple-500 focus:ring-purple-500 focus:outline-none transition"
                            required>
                            <option value="Available" @if (old('status', 'Available') == 'Available') selected @endif>Available
                            </option>
                            <option value="Maintenance" @if (old('status') == 'Maintenance') selected @endif>Maintenance
                            </option>
                            <option value="Disabled" @if (old('status') == 'Disabled') selected @endif>Disabled</option>
                        </select>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex justify-end space-x-4 pt-4">
                        <a href="{{ route('admin.keloladata') }}"
                            class="px-8 py-3 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-300">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-8 py-3 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition duration-300">
                            Simpan Ruangan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.admin>

    <x-layouts.admin>
        <div class="container mx-auto px-4 py-8">
            <div class="max-w-2xl mx-auto bg-gray-800 rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-bold text-white mb-6">Tambah Ruangan Baru</h2>

                @if ($errors->any())
                    <div class="bg-red-500 text-white p-4 rounded-lg mb-6">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.rooms.create') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                    @csrf
                    
                    <div>
                        <label for="name" class="block text-white mb-2">Nama Ruangan</label>
                        <input type="text" name="name" id="name" 
                            class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600 focus:border-blue-500 focus:outline-none"
                            value="{{ old('name') }}" required>
                    </div>

                    <div>
                        <label for="console_type" class="block text-white mb-2">Tipe Konsol</label>
                        <select name="console_type" id="console_type" 
                                class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600 focus:border-blue-500 focus:outline-none"
                                required>
                            <option value="">Pilih Tipe Konsol</option>
                            @foreach(App\Models\Room::CONSOLE_TYPES as $type)
                                <option value="{{ $type }}" {{ old('console_type') == $type ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="price_per_hour" class="block text-white mb-2">Harga per Jam (Rp)</label>
                        <input type="number" name="price_per_hour" id="price_per_hour" 
                            class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600 focus:border-blue-500 focus:outline-none"
                            value="{{ old('price_per_hour') }}" min="0" step="1000" required>
                    </div>

                    <!-- <div>
                        <label for="description" class="block text-white mb-2">Deskripsi</label>
                        <textarea name="description" id="description" rows="4"
                                class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600 focus:border-blue-500 focus:outline-none">{{ old('description') }}</textarea>
                    </div> -->

                    <div>
                        <label for="image" class="block text-white mb-2">Gambar Ruangan</label>
                        <input type="file" name="image" id="image" 
                            class="w-full px-4 py-2 rounded bg-gray-700 text-white border border-gray-600 focus:border-blue-500 focus:outline-none"
                            accept="image/*" required>
                        <p class="text-gray-400 text-sm mt-1">Format yang didukung: JPG, JPEG, PNG, GIF. Maksimal 2MB</p>
                    </div>

                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('admin.keloladata') }}" 
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
        </div>
    </x-layouts.admin>
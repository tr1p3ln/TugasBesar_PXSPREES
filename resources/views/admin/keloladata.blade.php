<x-layouts.admin>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header Halaman --}}
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-white">Kelola Data Ruangan</h2>
                <p class="text-gray-400 mt-1">Lihat, tambah, edit, dan kelola status semua ruangan.</p>
            </div>
            {{-- Tombol ini sekarang mengarah ke halaman create room yang benar --}}
            <a href="{{ route('admin.rooms.create') }}" class="px-6 py-3 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition duration-300 inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Tambah Ruangan Baru
            </a>
        </div>

        {{-- Notifikasi Sukses --}}
        @if (session('success'))
            <div class="bg-green-800/80 border border-green-600 text-green-200 px-4 py-3 rounded-lg mb-6" role="alert">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Tabel Data Ruangan --}}
        <div class="bg-gray-800/80 backdrop-blur-sm rounded-2xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-300">
                    <thead class="text-xs text-gray-400 uppercase bg-gray-700/50">
                        <tr>
                            <th scope="col" class="px-6 py-3">Nama Ruangan</th>
                            <th scope="col" class="px-6 py-3">Tipe Konsol</th>
                            <th scope="col" class="px-6 py-3">Harga/Jam</th>
                            <th scope="col" class="px-6 py-3">Status Saat Ini</th>
                            <th scope="col" class="px-6 py-3 text-center">Ubah Status</th>
                            <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rooms as $room)
                            <tr class="bg-gray-800 border-b border-gray-700 hover:bg-gray-700/60 transition">
                                <td class="px-6 py-4 font-medium text-white whitespace-nowrap">{{ $room->name }}</td>
                                <td class="px-6 py-4">{{ $room->console_type }}</td>
                                <td class="px-6 py-4">Rp{{ number_format($room->price_per_hour, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    {{-- Badge Status dengan warna dinamis --}}
                                    <span @class([
                                        'px-2 py-1 text-xs font-semibold rounded-full',
                                        'bg-green-500 text-green-900' => $room->status === 'Available',
                                        'bg-yellow-500 text-yellow-900' => $room->status === 'Booked',
                                        'bg-blue-500 text-blue-900' => $room->status === 'Maintenance',
                                        'bg-red-500 text-red-900' => $room->status === 'Disabled',
                                    ])>
                                        {{ $room->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    {{-- FORM UNTUK UPDATE STATUS --}}
                                    <form action="{{ route('admin.rooms.updateStatus', $room->id) }}" method="POST" class="flex items-center justify-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="w-36 px-2 py-1 text-xs rounded-md bg-gray-600 text-white border border-gray-500 focus:border-purple-500 focus:ring-purple-500">
                                            <option value="Available" @if($room->status == 'Available') selected @endif>Available</option>
                                            <option value="Maintenance" @if($room->status == 'Maintenance') selected @endif>Maintenance</option>
                                            <option value="Disabled" @if($room->status == 'Disabled') selected @endif>Disabled</option>
                                        </select>
                                        <button type="submit" class="p-1.5 bg-blue-600 hover:bg-blue-700 rounded-md" title="Simpan Status">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-center flex justify-center items-center gap-4">
                                    {{-- Tombol Edit dan Hapus dengan route yang benar --}}
                                    <a href="{{ route('admin.rooms.edit', $room->id) }}" class="font-medium text-blue-400 hover:underline">Edit</a>
                                    <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ruangan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-medium text-red-400 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-gray-800">
                                <td colspan="6" class="text-center py-8 text-gray-400">
                                    Belum ada data ruangan yang ditambahkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.admin>
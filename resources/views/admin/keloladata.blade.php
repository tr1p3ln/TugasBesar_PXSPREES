    <x-layouts.admin>
    <!-- TABLE DATA -->
    <div class="table-container bg-gray-900 text-white p-5 mt-5 rounded-lg shadow-lg">
        <h5 class="mb-4 text-2xl font-bold">Kelola DATA</h5>

    <div class="text-right mt-4">
        <a href="{{ route('rooms.create') }}" class="inline-block px-4 py-2 border border-gray-400 rounded hover:bg-gray-700 transition duration-300">Tambah Data</a>
    </div>

        <br>

        <table class="min-w-full bg-gray-800 rounded-lg overflow-hidden">
        <thead>
            <tr class="bg-gray-700 text-gray-300">
            <th class="border-b border-gray-600 px-4 py-2 text-center">Nama Ruangan</th>
            <th class="border-b border-gray-600 px-4 py-2 text-center">Tipe Konsol</th>
            <th class="border-b border-gray-600 px-4 py-2 text-center">Harga per Jam</th>
            <th class="border-b border-gray-600 px-4 py-2 text-center">Waktu</th>
            <th class="border-b border-gray-600 px-4 py-2 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-gray-800 text-gray-200">
            @if($rooms->isEmpty())
            <tr>
                <td colspan="5" class="border border-gray-600 p-2 text-center">Tidak ada data tersedia</td>
            </tr>
            @else
            @foreach ($rooms as $room)
                <tr class="hover:bg-gray-700 transition duration-300">
                <td class="border-b border-gray-600 p-4 text-center">{{ $room->name }}</td>
                <td class="border-b border-gray-600 p-4 text-center">{{ $room->console_type }}</td>
                <td class="border-b border-gray-600 p-4 text-center">Rp {{ number_format($room->price_per_hour, 0, ',', '.') }}</td>
                <td class="border-b border-gray-600 p-4 text-center">{{ now()->format('H:i') }}</td>
                <td class="border-b border-gray-600 px-4 py-2 text-center">
                            <a href="{{ route('rooms.edit', $room->id) }}" class="inline-block px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition duration-300">Edit</a>
                                <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus item ini?');" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ml-2 inline-block px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition duration-300">
                                        Hapus
                                    </button>
                                </form>
                        </td>
                </tr>
            @endforeach
            @endif
        </tbody>
        </table>
    </div>
    </x-layouts.admin>
<x-layouts.admin>
    <!-- TABLE DATA -->
    <div class="table-container bg-gray-900 text-white p-5 mt-5 rounded-lg shadow-lg">
        <h5 class="mb-4 text-2xl font-bold">Voucher</h5>

        <div class="text-right mt-4">
            <a href="{{ route('vouchers.create') }}" class="inline-block px-4 py-2 border border-gray-400 rounded hover:bg-gray-700 transition duration-300">Tambah Data</a>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header Halaman Kelola Data Voucher --}}
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-white">Kelola Data Voucher</h2>
                <p class="text-gray-400 mt-1">Lihat, tambah, edit, dan kelola semua voucher.</p>
            </div>
            {{-- Tombol Tambah Voucher Baru --}}
            <a href="{{ route('vouchers.create') }}" class="px-6 py-3 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition duration-300 inline-flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Tambah Voucher Baru
            </a>
        </div>

        {{-- Notifikasi Sukses (jika ada) --}}
        {{-- Menggunakan styling notifikasi sukses dari contoh ruangan --}}
        @if (session('success'))
            <div class="bg-green-800/80 border border-green-600 text-green-200 px-4 py-3 rounded-lg mb-6" role="alert">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Tabel Data Voucher --}}
        <div class="bg-gray-800/80 backdrop-blur-sm rounded-2xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-300">
                    <thead class="text-xs text-gray-400 uppercase bg-gray-700/50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-center">Nama Voucher</th>
                            <th scope="col" class="px-6 py-3 text-center">Deskripsi</th>
                            <th scope="col" class="px-6 py-3 text-center">Point Dibutuhkan</th>
                            <th scope="col" class="px-6 py-3 text-center">Jumlah Diskon</th>
                            <th scope="col" class="px-6 py-3 text-center">Kode Voucher</th>
                            <th scope="col" class="px-6 py-3 text-center">Tanggal Mulai</th>
                            <th scope="col" class="px-6 py-3 text-center">Tanggal Selesai</th>
                            <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($vouchers as $voucher)
                            <tr class="bg-gray-800 border-b border-gray-700 hover:bg-gray-700/60 transition">
                                <td class="px-6 py-4 font-medium text-white whitespace-nowrap">{{ $voucher->nama_voucher }}</td>
                                <td class="px-6 py-4">{{ $voucher->description }}</td>
                                <td class="px-6 py-4">{{ $voucher->point_required }}</td> {{-- Pastikan ini menampilkan point_required --}}
                                <td class="px-6 py-4">Rp{{ number_format($voucher->discount_amount, 0, ',', '.') }}</td> {{-- Menambahkan format mata uang --}}
                                <td class="px-6 py-4">{{ $voucher->voucher_code }}</td>
                                <td class="px-6 py-4 text-center">{{ $voucher->start_date->format('d-m-Y') }}</td>
                                <td class="px-6 py-4 text-center">{{ $voucher->end_date->format('d-m-Y') }}</td>
                                <td class="px-6 py-4 text-center flex justify-center items-center gap-4">
                                    <a href="{{ route('admin.vouchers.edit', $voucher->id) }}" class="font-medium text-blue-400 hover:underline">Edit</a>
                                    <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus voucher ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-medium text-red-400 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-gray-800">
                                <td colspan="8" class="text-center py-8 text-gray-400">
                                    Belum ada data voucher yang ditambahkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <br>

        <table class="min-w-full bg-gray-800 rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-gray-700 text-gray-300">
                    <th class="border-b border-gray-600 px-4 py-2 text-center">Nama Voucher</th>
                    <th class="border-b border-gray-600 px-4 py-2 text-center">Description</th>
                    <th class="border-b border-gray-600 px-4 py-2 text-center">Point Required</th>
                    <th class="border-b border-gray-600 px-4 py-2 text-center">Voucher Code</th>
                    <th class="border-b border-gray-600 px-4 py-2 text-center">Tanggal Mulai</th>
                    <th class="border-b border-gray-600 px-4 py-2 text-center">Tanggal Terakhir</th>
                    <th class="border-b border-gray-600 px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vouchers as $voucher)
                    <tr class="hover:bg-gray-600">
                        <td class="border-b border-gray-600 px-4 py-2 text-center">{{ $voucher->nama_voucher }}</td>
                        <td class="border-b border-gray-600 px-4 py-2 text-center">{{ $voucher->description }}</td>
                        <td class="border-b border-gray-600 px-4 py-2 text-center">{{ $voucher->discount_amount }}</td>
                        <td class="border-b border-gray-600 px-4 py-2 text-center">{{ $voucher->voucher_code }}</td>
                        <td class="border-b border-gray-600 px-4 py-2 text-center">{{ $voucher->start_date->format('d-m-Y') }}</td>
                        <td class="border-b border-gray-600 px-4 py-2 text-center">{{ $voucher->end_date->format('d-m-Y') }}</td>
                        <td class="border-b border-gray-600 px-4 py-2 text-center">
                            <a href="{{ route('vouchers.edit', $voucher->id) }}" class="inline-block px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition duration-300">Edit</a>
                                <form action="{{ route('vouchers.destroy', $voucher->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus item ini?');" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ml-2 inline-block px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition duration-300">
                                        Hapus
                                    </button>
                                </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layouts.admin>
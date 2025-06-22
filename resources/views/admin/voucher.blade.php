<x-layouts.admin>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header Halaman Kelola Data Voucher --}}
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-white">Kelola Data Voucher</h2>
                <p class="text-gray-400 mt-1">Lihat, tambah, edit, dan kelola semua voucher.</p>
            </div>
            {{-- Tombol Tambah Voucher Baru --}}
            <a href="{{ route('admin.voucher') }}" class="px-6 py-3 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition duration-300 inline-flex items-center">
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
    </div>
</x-layouts.admin>

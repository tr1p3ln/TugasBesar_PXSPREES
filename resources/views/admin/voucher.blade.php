<x-layouts.admin>
    <div class="content ml-52 p-5">
        <!-- TABLE DATA -->
        <div class="table-container bg-white p-5 mt-5 rounded shadow">
            <h5 class="mb-4 font-semibold">Kelola Voucher</h5>

            <div class="text-right mt-3">
                <a href="{{ route('admin.vouchercreate') }}" class="inline-block px-4 py-2 border border-gray-400 rounded hover:bg-gray-100">
                    Tambah Voucher
                </a>
            </div>
            
            <table class="w-full border-collapse border border-gray-200 mt-4">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-300 p-2">Nama Voucher</th>
                        <th class="border border-gray-300 p-2">Deskripsi</th>
                        <th class="border border-gray-300 p-2">Point</th>
                        <th class="border border-gray-300 p-2">Voucher Code</th>
                        <th class="border border-gray-300 p-2">Tanggal Berlaku</th>
                        <th class="border border-gray-300 p-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($vouchers as $voucher)
                        <tr>
                            <td class="border border-gray-300 p-2">{{ $voucher->nama }}</td>
                            <td class="border border-gray-300 p-2">{{ $voucher->deskripsi }}</td>
                            <td class="border border-gray-300 p-2">{{ $voucher->point }}</td>
                            <td class="border border-gray-300 p-2">{{ $voucher->kode }}</td>
                            <td class="border border-gray-300 p-2">{{ $voucher->tanggal_berlaku }}</td>
                            <td class="border border-gray-300 p-2">
                                <a href="#" class="text-blue-500 hover:underline">Edit</a> |
                                <a href="#" class="text-red-500 hover:underline">Hapus</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-3 text-gray-500">Belum ada voucher tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>

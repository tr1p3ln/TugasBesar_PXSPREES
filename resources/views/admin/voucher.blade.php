<x-layouts.admin>
    <!-- TABLE DATA -->
    <div class="table-container bg-gray-900 text-white p-5 mt-5 rounded-lg shadow-lg">
        <h5 class="mb-4 text-2xl font-bold">Voucher</h5>

        <div class="text-right mt-4">
            <a href="{{ route('vouchers.create') }}" class="inline-block px-4 py-2 border border-gray-400 rounded hover:bg-gray-700 transition duration-300">Tambah Data</a>
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
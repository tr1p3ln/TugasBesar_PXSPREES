<x-app-layout>
    <div class="mt-10 px-4 md:px-8 text-white">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
            <!-- Poin Section -->
            <div class="flex items-center gap-4 bg-gradient-to-br from-gray-900 to-gray-800 border border-purple-700 px-5 py-3 rounded-xl shadow-lg w-full md:w-auto">
                <div class="text-3xl text-purple-400 animate-pulse">✨</div>
                <div>
                    <p class="text-sm font-semibold text-gray-300">Poin Anda Sekarang</p>
                    <p class="text-3xl font-extrabold text-purple-500">100</p>
                </div>
            </div>

            <!-- Penjelasan Section -->
            <div class="w-full md:max-w-sm bg-gray-900 border border-red-700 p-4 rounded-xl shadow-md">
                <h2 class="font-bold text-lg mb-2 text-red-500 flex items-center">
                    <span class="mr-2 text-xl">⚠️</span> Penjelasan
                </h2>
                <p class="text-sm text-gray-300 leading-relaxed">
                    Tukarkan poin Anda jika sudah cukup. Segera klaim sebelum kehabisan! Voucher dapat digunakan untuk potongan harga booking ruangan.
                </p>
            </div>
        </div>

        <!-- Voucher Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($vouchers as $voucher)
            <div class="voucher-card bg-gray-800 rounded-xl overflow-hidden shadow-lg border border-gray-700 transform hover:scale-105 transition-all duration-300 ease-in-out">
                <img src="{{ $voucher->image_url ?? 'https://placehold.co/400x200/374151/ffffff?text=Voucher+Image' }}"
                     onerror="this.onerror=null;this.src='https://placehold.co/400x200/374151/ffffff?text=No+Image'"
                     alt="{{ $voucher->nama_voucher }}"
                     class="w-full h-40 object-cover">
                <div class="p-5">
                    <h3 class="text-xl font-bold mb-2">{{ $voucher->nama_voucher }}</h3>
                    <p class="text-sm text-gray-300 mb-4">{{ $voucher->description }}</p>
                    <div class="flex items-center text-lg font-semibold text-green-400 mb-4">
                        <span class="mr-2">💰</span> Potongan: Rp {{ number_format($voucher->discount_amount, 0, ',', '.') }}
                    </div>
                    <div class="flex items-center text-lg font-semibold text-yellow-400 mb-4">
                        <span class="mr-2">✨</span> Poin Diperlukan: {{ number_format($voucher->point_required, 0, ',', '.') }}
                    </div>
                    <button onclick="openModal('modal{{ $loop->index + 1 }}')"
                            class="w-full bg-purple-600 text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-purple-700 transition-colors duration-300 shadow-md">
                        Detail Voucher
                    </button>
                </div>
            </div>

            <!-- Modal for each voucher -->
            <div id="modal{{ $loop->index + 1 }}" class="fixed inset-0 bg-black bg-opacity-75 backdrop-blur-sm hidden items-center justify-center z-50">
                <div class="modal-content bg-gray-900 text-white p-8 rounded-xl max-w-md relative shadow-2xl border border-gray-700 transform scale-95 opacity-0 transition-all duration-300 ease-out">
                    <button onclick="closeModal('modal{{ $loop->index + 1 }}')" class="absolute top-4 right-4 text-3xl text-gray-400 hover:text-white transition-colors duration-200">&times;</button>
                    <h2 class="text-2xl font-bold mb-4 text-purple-400">{{ $voucher->nama_voucher }}</h2>
                    <img src="{{ $voucher->image_url ?? 'https://placehold.co/600x300/374151/ffffff?text=Voucher+Image' }}"
                         onerror="this.onerror=null;this.src='https://placehold.co/600x300/374151/ffffff?text=No+Image+Available'"
                         alt="{{ $voucher->nama_voucher }}"
                         class="w-full h-48 object-cover rounded-md mb-4">
                    <p class="mb-5 text-base text-gray-300">
                        {{ $voucher->description }}<br>
                        <strong class="text-green-400">Potongan: Rp {{ number_format($voucher->discount_amount, 0, ',', '.') }}</strong><br>
                        <strong class="text-yellow-400">Poin Diperlukan: {{ number_format($voucher->point_required, 0, ',', '.') }}</strong>
                    </p>
                    <button class="w-full bg-green-600 text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-green-700 transition-colors duration-300 shadow-md">
                        Klaim Voucher Ini
                    </button>
                </div>
            </div>
            @empty
                <p class="text-white text-lg col-span-full text-center">Tidak ada voucher tersedia saat ini.</p>
            @endforelse
        </div>
    </div>

    <!-- JS -->
    <script>
        function openModal(id) {
            const modal = document.getElementById(id);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            // Give a small delay for the transition to apply correctly
            setTimeout(() => {
                modal.querySelector('.modal-content').classList.remove('scale-95', 'opacity-0');
                modal.querySelector('.modal-content').classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            modal.querySelector('.modal-content').classList.remove('scale-100', 'opacity-100');
            modal.querySelector('.modal-content').classList.add('scale-95', 'opacity-0');
            // Wait for transition to finish before hiding
            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 300); // Matches the duration-300 transition
        }
    </script>
</x-app-layout>

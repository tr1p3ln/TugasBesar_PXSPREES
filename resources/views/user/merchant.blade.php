    <x-app-layout>
    <!-- Header -->
    <div class="top-flex flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-30">

        <!-- Poin -->
        <div class="bg-gradient-to-br to-blue-50 border border-blue-200 px-3 py-2 rounded-xl flex items-center gap-3 shadow text-blue-900 w-full md:w-auto">
        <div class="text-2xl animate-bounce">💠</div>
        <div>
            <p class="text-sm font-semibold">Poin Anda Sekarang</p>
            <p class="text-2xl font-extrabold text-blue-700">100</p>
        </div>
        </div>


        <!-- Penjelasan -->
        <div class="w-full md:max-w-sm">
        <h2 class="font-bold text-lg mb-1 text-red-600">⚠ Penjelasan</h2>
        <p class="text-sm text-red-600 leading-relaxed">
            Tukarkan poin Anda jika sudah cukup. Segera klaim sebelum kehabisan!
        </p>
        </div>
    </div>

    <!-- Voucher Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
        <!-- Voucher Card 1 -->
        <div class="bg-gray-800 text-white rounded-xl overflow-hidden shadow hover:shadow-lg transition">
        <img src="" alt="Voucher Diskon 10%" class="w-full h-40 object-cover">
        <div class="p-4">
            <h3 class="text-lg font-bold mb-1">Diskon 10%</h3>
            <p class="text-sm text-gray-300 mb-3">Potongan 10% untuk semua produk.</p>
            <button onclick="openModal('modal1')" class="bg-white text-gray-900 px-4 py-2 rounded hover:bg-gray-200 transition">Detail</button>
        </div>
        </div>

        <!-- Voucher Card 2 -->
        <div class="bg-gray-800 text-white rounded-xl overflow-hidden shadow hover:shadow-lg transition">
        <img src="" alt="Burger Gratis" class="w-full h-40 object-cover">
        <div class="p-4">
            <h3 class="text-lg font-bold mb-1">Burger Gratis</h3>
            <p class="text-sm text-gray-300 mb-3">1x burger gratis dari partner kami.</p>
            <button onclick="openModal('modal2')" class="bg-white text-gray-900 px-4 py-2 rounded hover:bg-gray-200 transition">Detail</button>
        </div>
        </div>

        <!-- Voucher Card 3 -->
        <div class="bg-gray-800 text-white rounded-xl overflow-hidden shadow hover:shadow-lg transition">
        <img src="" alt="Diskon 25%" class="w-full h-40 object-cover">
        <div class="p-4">
            <h3 class="text-lg font-bold mb-1">Diskon 25%</h3>
            <p class="text-sm text-gray-300 mb-3">Diskon 25% untuk item digital.</p>
            <button onclick="openModal('modal3')" class="bg-white text-gray-900 px-4 py-2 rounded hover:bg-gray-200 transition">Detail</button>
        </div>
        </div>
    </div>

    <!-- Modal 1 -->
    <div id="modal1" class="fixed inset-0 bg-black/70 backdrop-blur-sm hidden items-center justify-center z-50">
        <div class="bg-gray-900 text-white p-6 rounded-xl max-w-md relative shadow-2xl border border-gray-700">
        <button onclick="closeModal('modal1')" class="absolute top-3 right-4 text-2xl text-gray-400 hover:text-white">&times;</button>
        <h2 class="text-xl font-semibold mb-3">Diskon 10%</h2>
        <p class="mb-5 text-sm text-gray-300">
            Gunakan voucher ini untuk mendapatkan potongan sebesar 10% di semua produk.
        </p>
        <button class="bg-white text-gray-900 px-5 py-2 rounded hover:bg-gray-200 transition">Claim</button>
        </div>
    </div>

    <!-- Modal 2 -->
    <div id="modal2" class="fixed inset-0 bg-black/70 backdrop-blur-sm hidden items-center justify-center z-50">
        <div class="bg-gray-900 text-white p-6 rounded-xl max-w-md relative shadow-2xl border border-gray-700">
        <button onclick="closeModal('modal2')" class="absolute top-3 right-4 text-2xl text-gray-400 hover:text-white">&times;</button>
        <h2 class="text-xl font-semibold mb-3">Makanan Burger Gratis</h2>
        <p class="mb-5 text-sm text-gray-300">
            Tukarkan poin Anda untuk mendapatkan 1x burger gratis di gerai partner kami.
        </p>
        <button class="bg-white text-gray-900 px-5 py-2 rounded hover:bg-gray-200 transition">Claim</button>
        </div>
    </div>

    <!-- Modal 3 -->
    <div id="modal3" class="fixed inset-0 bg-black/70 backdrop-blur-sm hidden items-center justify-center z-50">
        <div class="bg-gray-900 text-white p-6 rounded-xl max-w-md relative shadow-2xl border border-gray-700">
        <button onclick="closeModal('modal3')" class="absolute top-3 right-4 text-2xl text-gray-400 hover:text-white">&times;</button>
        <h2 class="text-xl font-semibold mb-3">Diskon 25%</h2>
        <p class="mb-5 text-sm text-gray-300">
            Voucher ini memberikan potongan harga hingga 25% untuk pembelian item digital.
        </p>
        <button class="bg-white text-gray-900 px-5 py-2 rounded hover:bg-gray-200 transition">Claim</button>
        </div>
    </div>

    <!-- JS -->
    <script>
        function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.getElementById(id).classList.add('flex');
        }
        function closeModal(id) {
        document.getElementById(id).classList.remove('flex');
        document.getElementById(id).classList.add('hidden');
        }
    </script>
    </x-app-layout>
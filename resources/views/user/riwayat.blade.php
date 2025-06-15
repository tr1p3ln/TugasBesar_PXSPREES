    <x-app-layout>
    <div class="mt-10 px-4 md:px-8">
        <h1 class="text-2xl font-bold text-white mb-6">Riwayat Transaksi Pembayaran</h1>

        <!-- Tabs -->
        <div class="flex gap-4 mb-6">
        <button onclick="showTab('ongoing')" id="tab-ongoing"
            class="px-5 py-2 rounded-lg font-medium bg-gray-800 text-white border border-gray-600">
            Ongoing
        </button>
        <button onclick="showTab('past')" id="tab-past"
            class="px-5 py-2 rounded-lg font-medium bg-gray-700 text-gray-300 hover:text-white hover:bg-gray-600 transition">
            Past
        </button>
        </div>

        <!-- Ongoing Transactions -->
        <div id="ongoing" class="grid grid-cols-1 md:grid-cols-2 gap-5 transition-all duration-300">
        <div class="bg-gray-900 p-5 rounded-xl border border-gray-700 shadow">
            <p class="text-xs text-gray-400 mb-1">Transaksi #3</p>
            <p class="text-white font-semibold text-lg">Rp 1.200.000</p>
            <p class="text-sm text-gray-400">10 Juni 2025 • 14:30 WIB</p>
            <p class="text-sm text-blue-400">Room A-102</p>
        </div>
        </div>

        <!-- Past Transactions -->
        <div id="past" class=" grid-cols-1 md:grid-cols-2 gap-5 hidden transition-all duration-300">
        <div class="bg-gray-900 p-5 rounded-xl border border-gray-700 shadow">
            <p class="text-xs text-gray-400 mb-1">Transaksi #2</p>
            <p class="text-white font-semibold text-lg">Rp 950.000</p>
            <p class="text-sm text-gray-400">01 Mei 2025 • 10:15 WIB</p>
            <p class="text-sm text-blue-400">Room B-205</p>
        </div>
        <div class="bg-gray-900 p-5 rounded-xl border border-gray-700 shadow">
            <p class="text-xs text-gray-400 mb-1">Transaksi #1</p>
            <p class="text-white font-semibold text-lg">Rp 1.000.000</p>
            <p class="text-sm text-gray-400">15 April 2025 • 09:00 WIB</p>
            <p class="text-sm text-blue-400">Room C-310</p>
        </div>
        </div>
    </div>

    <!-- Tab Switching Script -->
    <script>
        function showTab(tab) {
        const ongoing = document.getElementById('ongoing');
        const past = document.getElementById('past');
        const tabOngoing = document.getElementById('tab-ongoing');
        const tabPast = document.getElementById('tab-past');

        if (tab === 'ongoing') {
            ongoing.classList.remove('hidden');
            past.classList.add('hidden');
            tabOngoing.classList.add('bg-gray-800', 'text-white');
            tabPast.classList.remove('bg-gray-800', 'text-white');
        } else {
            past.classList.remove('hidden');
            ongoing.classList.add('hidden');
            tabPast.classList.add('bg-gray-800', 'text-white');
            tabOngoing.classList.remove('bg-gray-800', 'text-white');
        }
        }
    </script>
    </x-app-layout>
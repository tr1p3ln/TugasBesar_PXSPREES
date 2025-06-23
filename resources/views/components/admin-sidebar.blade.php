<div class="sidebar fixed top-0 left-0 w-52 h-screen bg-gray-800 pt-5 border-r border-gray-700">
    <div class="flex justify-center mb-5">
        <div class="w-24 h-24 flex items-center justify-center bg-gray-700 rounded-full shadow-lg">
            <x-application-logo class="w-full h-full" />
        </div>
    </div>

    <nav class="flex flex-col space-y-2 px-2">
        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}" class="sidebar-item flex items-center py-3 px-4 text-white font-medium hover:bg-purple-600 transition duration-300 rounded-lg">
            <i class="fas fa-home mr-3 w-5 text-center"></i> Dashboard
        </a>

        {{-- Kelola Ruangan (Mengarah ke keloladata) --}}
        <a href="{{ route('admin.keloladata') }}" class="sidebar-item flex items-center py-3 px-4 text-white font-medium hover:bg-purple-600 transition duration-300 rounded-lg">
            <i class="fas fa-person-booth mr-3 w-5 text-center"></i> Kelola Ruangan
        </a>
        
        {{-- Kelola Voucher (Mengarah ke voucher) --}}
        <a href="{{ route('admin.voucher') }}" class="sidebar-item flex items-center py-3 px-4 text-white font-medium hover:bg-purple-600 transition duration-300 rounded-lg">
            <i class="fas fa-ticket-alt mr-3 w-5 text-center"></i> Kelola Voucher
        </a>

        {{-- Data Booking (Mengarah ke bookingdata) --}}
        <a href="{{ route('admin.bookingdata') }}" class="sidebar-item flex items-center py-3 px-4 text-white font-medium hover:bg-purple-600 transition duration-300 rounded-lg">
            <i class="fas fa-list-alt mr-3 w-5 text-center"></i> Data Booking
        </a>
        
        {{-- Konfirmasi Pembayaran (Mengarah ke payments.pending) --}}
        <a href="{{ route('admin.payments.pending') }}" class="sidebar-item flex items-center py-3 px-4 text-white font-medium hover:bg-purple-600 transition duration-300 rounded-lg">
            <i class="fas fa-check-circle mr-3 w-5 text-center"></i> Konfirmasi Bayar
        </a>

        {{-- Riwayat Pembayaran (Mengarah ke historydata) --}}
        <a href="{{ route('admin.historydata') }}" class="sidebar-item flex items-center py-3 px-4 text-white font-medium hover:bg-purple-600 transition duration-300 rounded-lg">
            <i class="fas fa-history mr-3 w-5 text-center"></i> Riwayat Transaksi
        </a>
    </nav>
</div>

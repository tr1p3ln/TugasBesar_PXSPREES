<div class="sidebar fixed top-0 left-0 w-52 h-screen bg-gray-800 pt-5 border-r border-gray-700"> <!-- Changed background to bg-gray-800 -->
    <div class="flex justify-center mb-5">
        <div class="w-24 h-24 flex items-center justify-center bg-gray-700 rounded-full shadow-lg"> <!-- Changed inner background -->
            <x-application-logo class="w-full h-full" />
        </div>
    </div>

    <nav class="flex flex-col space-y-2">
        {{-- Home --}}
        <a href="{{ route('admin.home') }}" class="sidebar-item flex items-center py-3 px-5 text-white font-medium hover:bg-blue-600 transition duration-300 rounded-lg">
            <i class="fas fa-home mr-2"></i> Home
        </a>

        {{-- Kelola Data Ruangan --}}
        <a href="{{ route('admin.rooms.create') }}" class="sidebar-item flex items-center py-3 px-5 text-white font-medium hover:bg-blue-600 transition duration-300 rounded-lg">
            <i class="fas fa-database mr-2"></i> Tambah Ruangan
        </a>

        <a href="{{ route('admin.keloladata') }}" class="sidebar-item flex items-center py-3 px-5 text-white font-medium hover:bg-blue-600 transition duration-300 rounded-lg">
            <i class="fas fa-database mr-2"></i> Kelola Ruangan
        </a>

        {{-- Booking Data --}}
        <a href="{{ route('admin.bookingdata') }}" class="sidebar-item flex items-center py-3 px-5 text-white font-medium hover:bg-blue-600 transition duration-300 rounded-lg">
            <i class="fas fa-list mr-2"></i> Booking
        </a>

        {{-- History / Transaksi --}}
        <a href="{{ route('admin.historydata') }}" class="sidebar-item flex items-center py-3 px-5 text-white font-medium hover:bg-blue-600 transition duration-300 rounded-lg">
            <i class="fas fa-handshake mr-2"></i> Transaksi
        </a>

        {{-- Voucher --}}
        <a href="{{ route('admin.voucher') }}" class="sidebar-item flex items-center py-3 px-5 text-white font-medium hover:bg-blue-600 transition duration-300 rounded-lg">
            <i class="fas fa-ticket mr-2"></i> Voucher
        </a>
    </nav>
</div>

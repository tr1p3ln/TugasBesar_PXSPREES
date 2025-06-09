<div class="sidebar fixed top-0 left-0 w-48 h-screen bg-black pt-5 border-r border-gray-300">
    <div class="flex justify-center mb-5"> <!-- Centering the logo -->
        <div class="w-24 h-24"> <!-- Adjust size as needed -->
            <x-application-logo class="w-full h-full" />
        </div>
    </div>

    {{-- Home --}}
    <a href="{{ route('admin.homepage') }}" class="sidebar-item block py-3 px-5 text-white font-medium hover:bg-gray-700">
        <i class="fas fa-home mr-2"></i> Home
    </a>

    {{-- Kelola Data --}}
    <a href="{{ route('admin.keloladata') }}" class="sidebar-item block py-3 px-5 text-white font-medium hover:bg-gray-700">
        <i class="fas fa-database mr-2"></i> Data
    </a>

    {{-- Booking Data --}}
    <a href="{{ route('admin.bookingdata') }}" class="sidebar-item block py-3 px-5 text-white font-medium hover:bg-gray-700">
        <i class="fas fa-list mr-2"></i> Booking
    </a>

    {{-- History / Transaksi --}}
    <a href="{{ route('admin.historydata') }}" class="sidebar-item block py-3 px-5 text-white font-medium hover:bg-gray-700">
        <i class="fas fa-handshake mr-2"></i> Transaksi
    </a>

    {{-- Voucher --}}
    <a href="{{ route('admin.voucher') }}" class="sidebar-item block py-3 px-5 text-white font-medium hover:bg-gray-700">
        <i class="fas fa-ticket mr-2"></i> Voucher
    </a>

    {{-- Tambah Voucher --}}
    <a href="{{ route('admin.vouchercreate') }}" class="sidebar-item block py-3 px-5 text-white font-medium hover:bg-gray-700">
        <i class="fas fa-plus mr-2"></i> Tambah Voucher
    </a>

</div>
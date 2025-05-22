<div class="sidebar fixed top-0 left-0 w-48 h-screen bg-gray-50 pt-5 border-r border-gray-300">
    <div class="mb-8">
        <div class="rounded-full bg-gray-200 mx-auto flex items-center justify-center w-14 h-14">Logo</div>
    </div>

    {{-- Home --}}
    <a href="{{ route('admin.homepage') }}" class="sidebar-item block py-3 px-5 text-black font-medium hover:bg-gray-300">
        <i class="fas fa-home mr-2"></i> Home
    </a>

    {{-- Kelola Data --}}
    <a href="{{ route('admin.keloladata') }}" class="sidebar-item block py-3 px-5 text-black font-medium hover:bg-gray-300">
        <i class="fas fa-database mr-2"></i> Data
    </a>

    {{-- Booking Data --}}
    <a href="{{ route('admin.bookingdata') }}" class="sidebar-item block py-3 px-5 text-black font-medium hover:bg-gray-300">
        <i class="fas fa-list mr-2"></i> Booking
    </a>

    {{-- History / Transaksi --}}
    <a href="{{ route('admin.historydata') }}" class="sidebar-item block py-3 px-5 text-black font-medium hover:bg-gray-300">
        <i class="fas fa-handshake mr-2"></i> Transaksi
    </a>

    {{-- Voucher --}}
    <a href="{{ route('admin.voucher') }}" class="sidebar-item block py-3 px-5 text-black font-medium hover:bg-gray-300">
        <i class="fas fa-ticket mr-2"></i> Voucher
    </a>

    {{-- Tambah Voucher --}}
    <a href="{{ route('admin.vouchercreate') }}" class="sidebar-item block py-3 px-5 text-black font-medium hover:bg-gray-300">
        <i class="fas fa-plus mr-2"></i> Tambah Voucher
    </a>

    {{-- Logout --}}
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full text-left block py-3 px-5 text-black font-medium hover:bg-gray-300">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
        </button>
    </form>
</div>

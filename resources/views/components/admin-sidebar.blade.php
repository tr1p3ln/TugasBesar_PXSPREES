<<<<<<< HEAD
<div class="sidebar fixed top-0 left-0 w-56 h-screen bg-white pt-5 border-r border-gray-200 shadow-sm">
    <!-- Logo Section -->
    <div class="mb-8 px-4">
        <div class="rounded-full bg-blue-100 mx-auto flex items-center justify-center w-12 h-12 text-blue-600 font-bold">
            <i class="fas fa-cog text-xl"></i>
        </div>
    </div>

    <!-- Menu Items -->
    <div class="space-y-1 px-2">
        {{-- Home --}}
        <x-responsive-nav-link :href="route('admin.homepage')" class="group flex items-center px-3 py-2.5 rounded-md hover:bg-blue-600">
            <i class="fas fa-home mr-3 text-gray-700 group-hover:text-white"></i>
            <span class="text-gray-700 group-hover:text-white font-medium">Dashboard</span>
        </x-responsive-nav-link>

        {{-- Kelola Data --}}
        <x-responsive-nav-link :href="route('admin.keloladata')" class="group flex items-center px-3 py-2.5 rounded-md hover:bg-blue-600">
            <i class="fas fa-database mr-3 text-gray-700 group-hover:text-white"></i>
            <span class="text-gray-700 group-hover:text-white font-medium">Kelola Data</span>
        </x-responsive-nav-link>

        {{-- Booking Data --}}
        <x-responsive-nav-link :href="route('admin.bookingdata')" class="group flex items-center px-3 py-2.5 rounded-md hover:bg-blue-600">
            <i class="fas fa-list mr-3 text-gray-700 group-hover:text-white"></i>
            <span class="text-gray-700 group-hover:text-white font-medium">Booking</span>
        </x-responsive-nav-link>

        {{-- History / Transaksi --}}
        <x-responsive-nav-link :href="route('admin.historydata')" class="group flex items-center px-3 py-2.5 rounded-md hover:bg-blue-600">
            <i class="fas fa-handshake mr-3 text-gray-700 group-hover:text-white"></i>
            <span class="text-gray-700 group-hover:text-white font-medium">Transaksi</span>
        </x-responsive-nav-link>

        {{-- Voucher --}}
        <x-responsive-nav-link :href="route('admin.voucher')" class="group flex items-center px-3 py-2.5 rounded-md hover:bg-blue-600">
            <i class="fas fa-ticket-alt mr-3 text-gray-700 group-hover:text-white"></i>
            <span class="text-gray-700 group-hover:text-white font-medium">Voucher</span>
        </x-responsive-nav-link>

        {{-- Tambah Voucher --}}
        <x-responsive-nav-link :href="route('admin.vouchercreate')" class="group flex items-center px-3 py-2.5 rounded-md hover:bg-blue-600">
            <i class="fas fa-plus-circle mr-3 text-gray-700 group-hover:text-white"></i>
            <span class="text-gray-700 group-hover:text-white font-medium">Tambah Voucher</span>
        </x-responsive-nav-link>
    </div>

    <!-- Logout Section -->
    <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-responsive-nav-link :href="route('logout')"
                onclick="event.preventDefault();
                        this.closest('form').submit();"
                class="group flex items-center px-3 py-2.5 rounded-md hover:bg-red-100 text-gray-700 hover:text-red-700">
                <i class="fas fa-sign-out-alt mr-3"></i>
                <span class="font-medium">
                    {{ __('Log Out') }}
                </span>
            </x-responsive-nav-link>
        </form>
    </div>
=======
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

>>>>>>> 711228d168e5adce93674bb55b2adefa84a790aa
</div>
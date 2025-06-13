<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>Admin - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script> <!-- Include Alpine.js for dropdown -->
</head>

<body class="bg-black text-white antialiased font-sans">
    @include('components.admin-sidebar')

    <div class="ml-52 p-5">
        {{-- <div class="topbar flex justify-end items-center bg-gray-800 py-2 px-5 rounded-md">
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center focus:outline-none">
                    <i class="fas fa-user mr-2 text-white"></i> Admin
                </button>

                <div x-show="open" @click.away="open = false"
                    class="absolute right-0 mt-2 w-48 bg-gray-700 rounded-md shadow-lg z-20" style="display: none;">
                    <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-white hover:bg-gray-600"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Log Out') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
            <i class="fas fa-bell mr-4 text-white"></i>
        </div> --}}

        <main class="mt-4">
            {{ $slot }} 
        </main>
    </div>
</body>

</html>

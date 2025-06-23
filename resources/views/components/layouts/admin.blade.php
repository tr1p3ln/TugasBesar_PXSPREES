<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Admin - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Add Font Awesome -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Add Font Awesome -->
</head>
<body class="bg-gray-900 text-white antialiased font-sans transition-colors duration-300">
    @include('components.admin-sidebar')

    <div class="ml-52 p-5 transition-all duration-300">
        <div class="topbar flex justify-between items-center bg-gray-800 py-2 px-5 rounded-md shadow-lg">
            <div class="flex items-center space-x-6 ml-auto"> <!-- Increased space between icons -->
                <!-- Notification Icon -->
                <div class="relative" x-data="{ open: false }">
                    <i class="fas fa-bell text-white cursor-pointer transition-transform duration-300 transform hover:scale-110" @click="open = !open"></i>
                    <span x-show="true" class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center transform translate-x-1/2 -translate-y-1/2" style="display: none;">1</span> <!-- Notification Badge -->
                    <!-- Notification Menu -->
                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95" 
                        class="absolute right-0 mt-2 w-48 bg-gray-700 rounded-md shadow-lg z-20">
                        <p class="p-2 text-sm text-white animate-pulse">No new notifications</p> <!-- Animation for the notification message -->
                    </div>
                </div>

                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center focus:outline-none transition-transform duration-300 transform hover:scale-105">
                        <span class="mr-2">Admin</span>
                        <i :class="open ? 'fas fa-chevron-up' : 'fas fa-chevron-down'" class="text-white"></i> <!-- Conditional class for arrow direction -->
                    </button>
                    
                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95" 
                        class="absolute right-0 mt-2 w-48 bg-gray-700 rounded-md shadow-lg z-20">
                        <a href="{{ route('logout') }}" 
                        class="block px-4 py-2 text-sm text-white hover:bg-gray-600 transition duration-200"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Log Out') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <main class="mt-4">
            {{ $slot }}
        </main>
    </div>

    <style>
        body {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</body>
</html>
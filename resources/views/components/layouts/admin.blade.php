<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Meta tags dan lainnya tetap sama -->
    <title>Admin - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-300 text-gray-900 antialiased font-sans">
    @include('components.admin-sidebar')
    
    <div class="ml-52 p-5">
        <div class="topbar flex justify-end items-center bg-gray-300 py-2 px-5">
            <div class="flex items-center">
                <i class="fas fa-bell mr-4"></i>
                <i class="fas fa-user mr-2"></i> Admin
            </div>
        </div>

        <main>
            {{ $slot }}  <!-- Ganti @yield('content') dengan $slot -->
        </main>
    </div>
</body>
</html>
<section>
    <nav class="bg-white dark:bg-black w-full z-20 top-0 border-b border-gray-200 dark:border-gray-600 shadow">
        <div class="max-w-screen-xl mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <a href="/" class="text-2xl font-bold tracking-wide uppercase text-purple-500 dark:text-purple-400">
                    PSXPRESS
                </a>

                <!-- Auth + Mobile Menu Button -->
                <div class="flex items-center space-x-2 md:space-x-4 md:order-2">
                    @if (Route::has('login'))
                    @auth
                    <a href="{{ url('/dashboard') }}"
                        class="px-4 py-2 rounded-md text-purple-500 hover:text-white border border-purple-500 hover:bg-purple-500 transition">
                        Dashboard
                    </a>
                    @else
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 rounded-md text-purple-500 hover:text-white border border-purple-500 hover:bg-purple-500 transition">
                        Login
                    </a>
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="px-4 py-2 rounded-md text-purple-500 hover:text-white border border-purple-500 hover:bg-purple-500 transition">
                        Register
                    </a>
                    @endif
                    @endauth
                    @endif

                    <!-- Hamburger (Mobile) -->
                    <button data-collapse-toggle="navbar-sticky" type="button"
                        class="md:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 focus:outline-none"
                        aria-controls="navbar-sticky" aria-expanded="false">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 17 14">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 1h15M1 7h15M1 13h15" />
                        </svg>
                    </button>
                </div>

                <!-- Menu Items -->
                <div class="hidden md:flex md:items-center md:space-x-8 md:order-1" id="navbar-sticky">
                    <a href="#home" class="text-purple-500 hover:text-purple-700 dark:hover:text-purple-300 transition">
                        Home
                    </a>
                    <a href="#room" class="text-purple-500 hover:text-purple-700 dark:hover:text-purple-300 transition">
                        Room
                    </a>
                    <a href="#game" class="text-purple-500 hover:text-purple-700 dark:hover:text-purple-300 transition">
                        Games
                    </a>
                    <a href="#rules" class="text-purple-500 hover:text-purple-700 dark:hover:text-purple-300 transition">
                        Rules
                    </a>
                    <a href="#location" class="text-purple-500 hover:text-purple-700 dark:hover:text-purple-300 transition">
                        Location
                    </a>
                </div>
            </div>
        </div>
    </nav>
</section>
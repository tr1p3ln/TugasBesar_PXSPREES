<!-- <section>
<nav class="bg-white dark:bg-black w-full z-20 top-0 start-0 border-b border-gray-200 dark:border-gray-600 shadow">
    <div class="max-w-screen-xl mx-auto px-4">
        <div class="relative flex items-center justify-between h-16">
            Logo
            <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
                <span class="text-2xl font-semibold dark:text-purple-400 uppercase">psxpress</span>
            </a>

            Mobile Menu Button
            <div class="flex md:order-2">
                @auth
                <a href="{{ route('dashboard') }}"
                    class="font-medium py-2 px-3 text-purple-400 hover:text-white border border-gray-100 rounded-lg bg-gray-50 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700 transition-colors">
                    Dashboard
                </a>
                Primary Navigation Menu
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                Logo
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                Navigation Links
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            Settings Dropdown
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        Authentication
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            Hamburger
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

     <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        Responsive Settings Options
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                Authentication
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
     <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        Responsive Settings Options
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                Authentication
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>

                @else
                <a href="{{ route('login') }}"
                    class="font-medium py-2 px-3 text-purple-400 hover:text-white border border-gray-100 rounded-lg bg-gray-50 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700 transition-colors mr-4">
                    Login
                </a>
                <a href="{{ route('register') }}"
                    class="font-medium py-2 px-3 text-purple-400 hover:text-white border border-gray-100 rounded-lg bg-gray-50 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700 transition-colors">
                    Register
                </a>
                @endauth

                <button data-collapse-toggle="navbar-sticky" type="button"
                    class="ml-2 inline-flex items-center p-2 w-10 h-10 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                    aria-controls="navbar-sticky" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 17 14">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
                    </svg>
                </button>
            </div>

            Menu Items
            <div class="hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
                <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                    <li><a href="#" class="block py-2 px-3 text-purple-400 hover:text-white rounded hover:bg-purple-500 md:hover:bg-transparent md:hover:text-purple-700 md:p-0 md:dark:hover:text-purple-400 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Home</a></li>
                    <li><a href="#" class="block py-2 px-3 text-purple-400 hover:text-white rounded hover:bg-purple-500 md:hover:bg-transparent md:hover:text-purple-700 md:p-0 md:dark:hover:text-purple-400 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Package</a></li>
                    <li><a href="#" class="block py-2 px-3 text-purple-400 hover:text-white rounded hover:bg-purple-500 md:hover:bg-transparent md:hover:text-purple-700 md:p-0 md:dark:hover:text-purple-400 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Price</a></li>
                    <li><a href="#" class="block py-2 px-3 text-purple-400 hover:text-white rounded hover:bg-purple-500 md:hover:bg-transparent md:hover:text-purple-700 md:p-0 md:dark:hover:text-purple-400 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Room</a></li>
                    <li><a href="#" class="block py-2 px-3 text-purple-400 hover:text-white rounded hover:bg-purple-500 md:hover:bg-transparent md:hover:text-purple-700 md:p-0 md:dark:hover:text-purple-400 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Rules</a></li>
                    <li><a href="#" class="block py-2 px-3 text-purple-400 hover:text-white rounded hover:bg-purple-500 md:hover:bg-transparent md:hover:text-purple-700 md:p-0 md:dark:hover:text-purple-400 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Games</a></li>
                    <li><a href="#" class="block py-2 px-3 text-purple-400 hover:text-white rounded hover:bg-purple-500 md:hover:bg-transparent md:hover:text-purple-700 md:p-0 md:dark:hover:text-purple-400 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Location</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
</section> -->

<nav class="bg-white dark:bg-black  w-full z-20 top-0 start-0 border-b border-gray-200 dark:border-gray-600 shadow">
    <div class="max-w-screen-xl mx-auto px-4">
        <div class="relative flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
                <span class="text-2xl font-semibold dark:text-purple-400 uppercase">psxpress</span>
            </a>

            <!-- Menu Items -->
            <div class="hidden md:flex md:items-center md:space-x-8 md:order-1" id="navbar-sticky">
                <a href="{{ route('home') }}" class="text-purple-500 hover:text-purple-700 dark:hover:text-purple-300 transition">
                    Home
                </a>
                <a href="{{ route('home') }}#package" class="text-purple-500 hover:text-purple-700 dark:hover:text-purple-300 transition">
                    Package
                </a>
                <a href="{{ route('home') }}#room" class="text-purple-500 hover:text-purple-700 dark:hover:text-purple-300 transition">
                    Room
                </a>
                <a href="{{ route('home') }}#game" class="text-purple-500 hover:text-purple-700 dark:hover:text-purple-300 transition">
                    Games
                </a>
                <a href="{{ route('home') }}#rules" class="text-purple-500 hover:text-purple-700 dark:hover:text-purple-300 transition">
                    Rules
                </a>

                <a href="{{ route('booking') }}" class="text-purple-500 hover:text-purple-700 dark:hover:text-purple-300 transition">
                    Booking
                </a>
                <a href="{{ route('home') }}#location" class="text-purple-500 hover:text-purple-700 dark:hover:text-purple-300 transition">
                    Location
                </a>
            </div>

            <!-- Mobile Menu Button and Auth Links -->
            <div class="flex md:order-2 items-center gap-2">
                @auth
                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-purple-400 dark:text-purple-400 hover:text-white dark:hover:text-white focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Hamburger for mobile -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                @else
                <a href="{{ route('login') }}"
                    class="font-medium py-2 px-3 text-purple-400 hover:text-white border border-gray-100 rounded-lg bg-gray-50 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700 transition-colors">
                    Login
                </a>
                <a href="{{ route('register') }}"
                    class="font-medium py-2 px-3 text-purple-400 hover:text-white border border-gray-100 rounded-lg bg-gray-50 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700 transition-colors">
                    Register
                </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    @auth
    <div x-show="open" class="sm:hidden bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-600">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                            this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
    @endauth
</nav>
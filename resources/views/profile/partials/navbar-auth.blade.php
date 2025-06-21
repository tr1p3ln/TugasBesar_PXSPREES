<nav class="bg-white dark:bg-black w-full z-20 top-0 start-0 border-b border-gray-200 dark:border-gray-600 shadow">
    <div class="max-w-screen-xl mx-auto px-4">
        <div class="relative flex items-center justify-between h-16">
            <a href="{{ route('home') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
                <span class="text-2xl font-semibold dark:text-purple-400 uppercase">psxpress</span>
            </a>

            <div class="hidden md:flex md:items-center md:space-x-8" id="navbar-sticky">
                <a href="{{ route('home') }}" class="text-purple-500 hover:text-purple-700 dark:hover:text-purple-300 transition">Home</a>
                <a href="{{ route('home') }}#package" class="text-purple-500 hover:text-purple-700 dark:hover:text-purple-300 transition">Package</a>
                <a href="{{ route('home') }}#room" class="text-purple-500 hover:text-purple-700 dark:hover:text-purple-300 transition">Room</a>
                <a href="{{ route('user.booking.create') }}" class="text-purple-500 hover:text-purple-700 dark:hover:text-purple-300 transition">Booking</a>
                <a href="{{ route('user.vouchers.index') }}" class="text-purple-500 hover:text-purple-700 dark:hover:text-purple-300 transition">Merchant</a>
            </div>

            <div class="flex items-center md:order-2 gap-2">
                @auth
                    <div class="hidden sm:flex sm:items-center">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ Auth::user()->name }}</div>
                                    <div class="ms-1"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                                <x-dropdown-link :href="route('user.booking.history')">{{ __('Riwayat') }}</x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="font-medium py-2 px-3 text-purple-400 hover:text-white border border-gray-100 rounded-lg">Login</a>
                    <a href="{{ route('register') }}" class="font-medium py-2 px-3 text-purple-400 hover:text-white border border-gray-100 rounded-lg">Register</a>
                @endauth

                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 focus:outline-none">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    @auth
        <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('user.dashboard')" :active="request()->routeIs('user.dashboard')">{{ __('Dashboard') }}</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('user.booking.create')" :active="request()->routeIs('user.booking.create')">{{ __('Booking') }}</x-responsive-nav-link>
            </div>
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">{{ __('Profile') }}</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('user.booking.history')">{{ __('Riwayat') }}</x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
    @endauth
</nav>
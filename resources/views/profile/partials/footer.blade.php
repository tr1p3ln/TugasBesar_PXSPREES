<!-- 
    <footer class="bg-black shadow-sm dark:bg-black mt-10">
        <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
            <div class="sm:flex sm:items-center sm:justify-between">
                <a href="#" class="flex items-center mb-4 sm:mb-0 space-x-3">
                    <span class="text-2xl font-semibold text-white uppercase">psxpress</span>
                </a>

                <ul class="flex flex-col sm:flex-row items-center gap-4 text-sm font-medium text-gray-400">
                    <li>
                        <a href="#" class="hover:underline flex items-center gap-2">
                            <img src="{{ asset('assets/picture/instagram.png') }}" alt="Instagram" class="w-5 h-5">
                            Instagram
                        </a>
                    </li>
                    <li>
                        <a href="#" class="hover:underline flex items-center gap-2">
                            <img src="{{ asset('assets/picture/facebook.png') }}" alt="Facebook" class="w-5 h-5">
                            Facebook
                        </a>
                    </li>
                    <li>
                        <a href="#" class="hover:underline flex items-center gap-2">
                            <img src="{{ asset('assets/picture/twitter.png') }}" alt="Twitter" class="w-5 h-5">
                            Twitter
                        </a>
                    </li>
                </ul>
            </div>

            <hr class="my-6 border-gray-700" />
            <span class="block text-sm text-gray-500 text-center">© 2025 <a href="#" class="hover:underline uppercase">psxpress™</a>. All Rights Reserved.</span>
        </div>
    </footer> -->

<footer class="bg-black text-white mt-auto"> <!-- mt-auto untuk footer di bawah -->
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <!-- Logo -->
            <div class="mb-6 md:mb-0">
                <a href="/" class="flex items-center gap-3">
                    <span class="text-2xl font-semibold uppercase">PSXPRESS</span>
                </a>
            </div>

            <!-- Social Media Links -->
            <ul class="flex flex-wrap justify-center gap-6 sm:gap-8">
                <li>
                    <a href="#" class="hover:text-purple-400 transition-colors flex items-center gap-2">
                        <img src="{{ asset('assets/picture/instagram.png') }}"
                            alt="Instagram"
                            class="w-5 h-5"
                            loading="lazy">
                        <span class="hidden sm:inline">Instagram</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="hover:text-purple-400 transition-colors flex items-center gap-2">
                        <img src="{{ asset('assets/picture/facebook.png') }}"
                            alt="Facebook"
                            class="w-5 h-5"
                            loading="lazy">
                        <span class="hidden sm:inline">Facebook</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="hover:text-purple-400 transition-colors flex items-center gap-2">
                        <img src="{{ asset('assets/picture/twitter.png') }}"
                            alt="Twitter"
                            class="w-5 h-5"
                            loading="lazy">
                        <span class="hidden sm:inline">Twitter</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Divider -->
        <hr class="my-6 border-gray-700">

        <!-- Copyright -->
        <div class="text-center text-gray-400 text-sm">
            © {{ now()->year }} <a href="/" class="hover:text-purple-400 hover:underline">PSXPRESS™</a>.
            All Rights Reserved.
        </div>
    </div>
</footer>
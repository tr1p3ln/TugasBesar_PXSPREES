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
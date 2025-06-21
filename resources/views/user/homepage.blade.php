<x-app-layout>
    <div class="mt-16">
        <!-- Konten carousel Anda -->
        <div class="slide_Image relative z-10 pt-30 pb-20" id="home">
            <div id="default-carousel" class="relative w-full" data-carousel="slide">
                <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                    <div class="duration-700 ease-in-out" data-carousel-item>
                        <img src="{{ asset('assets/picture/roomvip.png') }}" alt="Slide 2"
                            class="absolute block w-full h-full object-contain top-0 left-0" />
                    </div>
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="{{ asset('assets/picture/roombasic.png') }}" alt="Slide 2"
                            class="absolute block w-full h-full object-contain top-0 left-0" />
                    </div>
                </div>

                <!-- Tombol carousel -->
                <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3">
                    <button type="button" class="w-3 h-3 rounded-full bg-white" data-carousel-slide-to="0"></button>
                    <button type="button" class="w-3 h-3 rounded-full bg-white" data-carousel-slide-to="1"></button>
                </div>

                <!-- Tombol navigasi -->
                <button type="button"
                    class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4"
                    data-carousel-prev>
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button type="button"
                    class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4"
                    data-carousel-next>
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Package section -->
        <div class="package" id="package">
            <h2 class="text-white text-center font-bold text-5xl pt-8 uppercase">Package</h2>
            <div class="flex flex-wrap justify-center gap-10 md:gap-40 pt-5">
                <img src="{{ asset('assets/picture/playstasion.png') }}" alt="PlayStation" class="w-24 md:w-32" />
                <img src="{{ asset('assets/picture/nitendo.png') }}" alt="Nintendo" class="w-24 md:w-32" />
                <img src="{{ asset('assets/picture/vip.png') }}" alt="VIP Room" class="w-24 md:w-32" />
            </div>
        </div>
        

        <!-- Room section -->
        <div class="room" id="room">
            <h2 class="text-white text-center font-bold text-5xl pt-8 uppercase">Room</h2>

            <div class="relative w-full h-[400px] pt-4">
                <img src="{{ asset('assets/picture/roombasic.png') }}" alt="Room Basic" class="w-full h-full object-contain" />
            </div>

            <div class="relative w-full h-[400px] mt-4 pt-4">
                <img src="{{ asset('assets/picture/roomvip.png') }}" alt="Room VIP" class="w-full h-full object-contain" />
            </div>
        </div>
        <br>

        <!-- Booking section -->
        <section class="bg-contain bg-center bg-no-repeat bg-[url('https://images.pexels.com/photos/7773720/pexels-photo-7773720.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1')] ">
            <div class="px-4 mx-auto max-w-screen-xl text-center py-24 lg:py-56">
                <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl uppercase">booking now!</h1>
                <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0">
                    <a href="{{ route('user.booking.create') }}" class="px-6 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition">Booking</a>
                </div>
            </div>
        </section>

        <!-- Rules section -->
        <div class="rules" id="rules">
            <h2 class="text-white text-center font-bold text-5xl pt-8 uppercase">Rules</h2>
            <ul class="text-white pt-4 max-w-md mx-auto space-y-2 list-disc list-inside">
                <li class="capitalize">Dilarang merokok</li>
                <li class="capitalize">Dilarang membawa makanan dan minuman dari luar</li>
                <li class="capitalize">Dilarang membuang sampah sembarangan</li>
                <li class="capitalize">Dilarang merusak properti</li>
                <li class="capitalize">Dilarang download / hapus game</li>
            </ul>
        </div>

        <!-- Games section -->
        <div class="games" id="game">
            <h2 class="text-white text-center font-bold text-5xl pt-8 uppercase">games</h2>
            <img src="{{ asset('assets/picture/bannerPlaystasion.png') }}" alt="Room VIP" class="w-full h-full object-contain pt-4  pb-4" />
            <br>
            <img src="{{ asset('assets/picture/bannerNitendo.png') }}" alt="Room VIP" class="w-full h-full object-contain" />
        </div>

        <!-- Location section -->
        <div class="location-section bg-black py-12 px-4 sm:px-6 lg:px-8" id="location">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-3xl font-bold text-white mb-8 text-center capitalize">Di mana kami berada?</h2>
                <div class="grid md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <h3 class="text-2xl font-semibold text-white">Kunjungi kami</h3>
                        <div class="space-y-2">
                            <p class="text-lg font-medium text-white">Institut Teknologi Nasional Bandung (ITENAS)</p>
                            <p class="text-white">Jl. Khp Hasan Mustopa No.23, Neglasari, Kec. Cibeunying Kaler, Kota Bandung, Jawa Barat 40124</p>
                            <p class="text-white"><span class="font-medium">Open:</span> Mon - Sun, 07PM - 10PM</p>
                        </div>
                        <div class="pt-4">
                            <h4 class="text-xl font-semibold text-white mb-2">Kunjungi</h4>
                            <a href="#" class="text-purple-600 hover:text-purple-800 underline">View larger map</a>
                        </div>
                    </div>
                    <div class="h-96 bg-black  rounded-lg overflow-hidden ">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.936905122385!2d107.63580999999999!3d-6.898149999999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e7bb26b63b69%3A0x9ed5cea73b538ee0!2sInstitut%20Teknologi%20Nasional%20Bandung%20(ITENAS)!5e0!3m2!1sid!2sid!4v1747028658374!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                            width="100%"
                            height="100%"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            class="w-full h-full"></iframe>
                    </div>
                </div>
                <br>
            </div>
        </div>
        
        <!-- PS Plus section -->
        <div class="platStasionPlus">
            <img src="{{ asset('assets/picture/psPlus.png') }}" alt="Room VIP" class="w-full h-full object-contain" />
        </div>
    </div>
</x-app-layout>
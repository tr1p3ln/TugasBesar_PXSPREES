\<x-app-layout>
    <div class="mt-16">
        <div class="slide_Image relative z-10 pt-30 pb-20">
            <div id="default-carousel" class="relative w-full" data-carousel="slide">
                <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                    <div class="duration-700 ease-in-out" data-carousel-item>
                        <img src="{{ asset('assets/picture/roomvip.png') }}" alt="Slide 2" class="absolute block w-full h-full object-contain top-0 left-0" />
                    </div>
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="{{ asset('assets/picture/roombasic.png') }}" alt="Slide 2" class="absolute block w-full h-full object-contain top-0 left-0" />
                    </div>
                </div>
                </div>
        </div>

        <div class="package" id="package">
            <h2 class="text-white text-center font-bold text-5xl pt-8 uppercase">Package</h2>
            <div class="flex flex-wrap justify-center gap-10 md:gap-40 pt-5">
                <img src="{{ asset('assets/picture/playstasion.png') }}" alt="PlayStation" class="w-24 md:w-32" />
                <img src="{{ asset('assets/picture/nitendo.png') }}" alt="Nintendo" class="w-24 md:w-32" />
                <img src="{{ asset('assets/picture/vip.png') }}" alt="VIP Room" class="w-24 md:w-32" />
            </div>
        </div>
        
        <section class="bg-contain bg-center bg-no-repeat bg-[url('https://images.pexels.com/photos/7773720/pexels-photo-7773720.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1')]">
            <div class="px-4 mx-auto max-w-screen-xl text-center py-24 lg:py-56">
                <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl uppercase">booking now!</h1>
                <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0">
                    {{-- SUDAH DIPERBAIKI --}}
                    <a href="{{ route('user.booking.create') }}" class="px-6 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition">Booking</a>
                </div>
            </div>
        </section>

        </div>
</x-app-layout>
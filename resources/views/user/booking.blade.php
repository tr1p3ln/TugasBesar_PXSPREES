<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Booking Ruangan Gaming') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-black">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Konten Booking -->
            <section class="text-white">
                <div class="container mx-auto px-4">
                    <h2 class="text-3xl font-bold text-center mb-8 uppercase">Pilih Layanan</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Card Layanan -->
                        <div class="service-card cursor-pointer" data-service="playstation">
                            <img src="{{ asset('assets/picture/playstasion.png') }}" alt="PlayStation"
                                class="mx-auto h-40 object-contain hover:scale-105 transition">
                            <h3 class="text-xl font-semibold text-center mt-4">PLAYSTATION</h3>
                        </div>
                        <div class="service-card cursor-pointer" data-service="nintendo">
                            <img src="{{ asset('assets/picture/nitendo.png') }}" alt="Nintendo"
                                class="mx-auto h-40 object-contain hover:scale-105 transition">
                            <h3 class="text-xl font-semibold text-center mt-4">NINTENDO SWITCH</h3>
                        </div>
                        <div class="service-card cursor-pointer" data-service="vip">
                            <img src="{{ asset('assets/picture/vip.png') }}" alt="VIP Room"
                                class="mx-auto h-40 object-contain hover:scale-105 transition">
                            <h3 class="text-xl font-semibold text-center mt-4">RUANGAN VIP</h3>
                        </div>
                    </div>

                    <!-- Form Booking -->
                    <div id="booking-form" class=" mt-12 max-w-2xl mx-auto bg-gray-900 p-8 rounded-xl">
                        <!-- ... (form booking yang sama) ... -->
                        <h3 id="form-title" class="text-2xl font-bold mb-6 text-center text-purple-400"></h3>
                        <form id="booking-data">
                            <input type="hidden" id="service-type" name="service_type">
                            <input type="hidden" id="selected-time" name="booking_time">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="mb-4">
                                    <label for="booking-date" class="block mb-2 font-medium">Tanggal Booking</label>
                                    <input type="date" id="booking-date" name="booking_date"
                                        class="w-full p-3 rounded-lg bg-gray-800 border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500"
                                        min="{{ date('Y-m-d') }}" required>
                                </div>
                                <br>
                                <div class="mb-4">
                                    <label class="block mb-2 font-medium">Jam Booking</label>
                                    <div class="grid grid-cols-2 gap-2" id="time-slots-container"></div>
                                </div>

                                <div class="mb-4 md:col-span-2">
                                    <label for="room-number" class="block mb-2 font-medium">Nomor Ruangan</label>
                                    <select id="room-number" name="room_number"
                                        class="w-full p-3 rounded-lg bg-gray-800 border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500"
                                        required>
                                        <option value="" disabled selected>Pilih Ruangan</option>
                                    </select>
                                </div>

                                <div class="mb-4 md:col-span-2">
                                    <label for="customer-name" class="block mb-2 font-medium">Nama Pemesan</label>
                                    <input type="text" id="customer-name" name="customer_name"
                                        class="w-full p-3 rounded-lg bg-gray-800 border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500"
                                        placeholder="Masukkan nama lengkap" required>
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full mt-6 bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300 capitalize">
                                pesan sekarang
                            </button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>

    @push('styles')
    <style>
        .service-card {
            transition: all 0.3s ease;
            border: 2px solid transparent;
            padding: 1.5rem;
            border-radius: 0.75rem;
            background-color: rgba(31, 41, 55, 0.8);
        }

        .service-card:hover {
            transform: translateY(-5px);
            border-color: rgba(147, 51, 234, 0.5);
        }

        .service-card.selected {
            border-color: #9333ea;
            box-shadow: 0 4px 6px -1px rgba(147, 51, 234, 0.3);
            background-color: rgba(17, 24, 39, 0.8);
        }

        .time-slot {
            padding: 0.5rem;
            border-radius: 0.5rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid #4b5563;
        }

        .time-slot:hover {
            transform: scale(1.05);
        }

        .time-slot.selected {
            background-color: #9333ea;
            color: white;
            border-color: #9333ea;
        }

        .time-slot.unavailable {
            background-color: #6b7280;
            color: #9ca3af;
            cursor: not-allowed;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi variabel
            const serviceCards = document.querySelectorAll('.service-card');
            const bookingForm = document.getElementById('booking-form');
            const formTitle = document.getElementById('form-title');
            const serviceType = document.getElementById('service-type');
            const roomSelect = document.getElementById('room-number');
            const timeSlotsContainer = document.getElementById('time-slots-container');
            const selectedTimeInput = document.getElementById('selected-time');
            const bookingDateInput = document.getElementById('booking-date');

            // Data ruangan
            const roomData = {
                playstation: ['PS-1', 'PS-2', 'PS-3', 'PS-4', 'PS-5'],
                nintendo: ['NS-1', 'NS-2', 'NS-3', 'NS-4', 'NS-5'],
                vip: ['VIP-1', 'VIP-2', 'VIP-3', 'VIP-4', 'VIP-5']
            };

            let selectedSlots = [];

            // Fungsi untuk generate time slots
            function generateTimeSlots() {
                timeSlotsContainer.innerHTML = '';
                selectedSlots = [];

                // Generate slots dari jam 10:00 sampai 22:00
                for (let hour = 10; hour < 22; hour++) {
                    const startTime = hour.toString().padStart(2, '0') + ':00';
                    const endTime = (hour + 1).toString().padStart(2, '0') + ':00';
                    const timeRange = `${startTime}-${endTime}`;

                    const timeSlot = document.createElement('div');
                    timeSlot.className = 'time-slot';
                    timeSlot.textContent = timeRange;
                    timeSlot.dataset.time = timeRange;

                    // Event listener untuk memilih slot waktu
                    timeSlot.addEventListener('click', function() {
                        if (this.classList.contains('unavailable')) return;

                        if (this.classList.contains('selected')) {
                            this.classList.remove('selected');
                            selectedSlots = selectedSlots.filter(t => t !== this.dataset.time);
                        } else {
                            this.classList.add('selected');
                            selectedSlots.push(this.dataset.time);
                        }
                        selectedTimeInput.value = selectedSlots.join(', ');
                    });

                    timeSlotsContainer.appendChild(timeSlot);
                }
            }

            // Event listener untuk card layanan
            serviceCards.forEach(card => {
                card.addEventListener('click', function() {
                    // Reset seleksi sebelumnya
                    serviceCards.forEach(c => c.classList.remove('selected'));

                    // Set seleksi baru
                    this.classList.add('selected');
                    const service = this.dataset.service;
                    const serviceName = this.querySelector('h3').textContent;

                    // Update form title dan service type
                    formTitle.textContent = `Booking ${serviceName}`;
                    serviceType.value = service;

                    // Update pilihan ruangan
                    roomSelect.innerHTML = '<option value="" disabled selected>Pilih Ruangan</option>';
                    roomData[service].forEach(room => {
                        const option = document.createElement('option');
                        option.value = room;
                        option.textContent = room;
                        roomSelect.appendChild(option);
                    });

                    // Tampilkan form dan scroll ke form
                    bookingForm.classList.remove('hidden');
                    bookingForm.scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });

            // Event listener untuk submit form
            document.getElementById('booking-data').addEventListener('submit', function(e) {
                e.preventDefault();

                // Validasi slot waktu terpilih
                if (!selectedSlots.length) {
                    alert('Silakan pilih setidaknya satu jam booking.');
                    return;
                }

                // Simulasi proses booking
                const formData = new FormData(this);
                const bookingDetails = Object.fromEntries(formData.entries());

                // Tampilkan hasil booking (sementara)
                alert(`Booking berhasil!\nLayanan: ${bookingDetails.service_type}\nTanggal: ${bookingDetails.booking_date}\nJam: ${bookingDetails.booking_time}\nRuangan: ${bookingDetails.room_number}\nAtas nama: ${bookingDetails.customer_name}`);

                // Reset form
                this.reset();
                selectedTimeInput.value = '';
                selectedSlots = [];
                document.querySelectorAll('.time-slot').forEach(slot => slot.classList.remove('selected'));
                serviceCards.forEach(c => c.classList.remove('selected'));
                bookingForm.classList.add('hidden');
                generateTimeSlots();
            });

            // Inisialisasi pertama kali
            generateTimeSlots();
            bookingDateInput.addEventListener('change', generateTimeSlots);
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('a[href*="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    if (this.getAttribute('href').startsWith('#')) {
                        // Handle anchor links di halaman yang sama
                        e.preventDefault();
                        const target = document.querySelector(this.getAttribute('href'));
                        if (target) {
                            target.scrollIntoView({
                                behavior: 'smooth'
                            });
                        }
                    }
                    // Untuk link dengan route + anchor, biarkan default behavior
                });
            });
        });
    </script>
    @endpush

</x-app-layout>
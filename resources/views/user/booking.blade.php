<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Booking Ruangan Gaming') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-black">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <section class="text-white">
                <div class="container mx-auto px-4">
                    <h2 class="text-3xl font-bold text-center mb-8 uppercase">Pilih Layanan</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
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

                    <div id="booking-form" class="mt-12 max-w-2xl mx-auto bg-gray-900 p-8 rounded-xl ">
                        <h3 id="form-title" class="text-2xl font-bold mb-6 text-center text-purple-400"></h3>
                        <form id="booking-data" action="{{ route('user.booking.store') }}" method="POST">
                            @csrf

                            <input type="hidden" id="service-type-input" name="console_type">

                            <input type="hidden" id="selected-time-slots-string" name="selected_slots_string_for_debug">


                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="mb-4">
                                    <label for="booking-date" class="block mb-2 font-medium">Tanggal Booking</label>
                                    <input type="date" id="booking-date" name="booking_date"
                                        class="w-full p-3 rounded-lg bg-gray-800 border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500"
                                        min="{{ date('Y-m-d') }}" required>
                                </div>

                                <div class="mb-4">
                                    <label class="block mb-2 font-medium">Jam Booking</label>
                                    <div class="grid grid-cols-2 gap-2" id="time-slots-container">
                                        
                                    </div>
                                    <p id="time-error" class="text-red-500 text-sm mt-1 hidden">Jam harus berurutan!</p>
                                </div>

                                <div class="mb-4 md:col-span-2">
                                    <label for="room-select" class="block mb-2 font-medium">Nomor Ruangan</label>

                                    <select id="room-select" name="room_id"
                                        class="w-full p-3 rounded-lg bg-gray-800 border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500"
                                        required>
                                        <option value="" disabled selected>Pilih Layanan & Tanggal Dahulu</option>
                                    </select>
                                </div>

                                <div class="mb-4 md:col-span-2">
                                    <label for="customer-name" class="block mb-2 font-medium">Nama Pemesan</label>
                                    <input type="text" id="customer-name" name="customer_name"
                                        value="{{ Auth::user()->name ?? '' }}" {{-- Auto-fill jika user login --}}
                                        class="w-full p-3 rounded-lg bg-gray-800 border border-gray-700 focus:border-purple-500 focus:ring-1 focus:ring-purple-500"
                                        placeholder="Masukkan nama lengkap" required>
                                </div>

                                <div class="mb-4">
                                    <label class="block mb-2 font-medium">Durasi Booking</label>
                                    <div class="p-3 bg-gray-800 rounded-lg">
                                        <span id="total-duration">0</span> jam
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="block mb-2 font-medium">Total Harga</label>
                                    <div class="p-3 bg-gray-800 rounded-lg">
                                        Rp <span id="total-price">0</span>
                                    </div>
                                </div>

                                <div class="mb-4 md:col-span-2">
                                    <label for="voucher-code" class="block mb-2 font-medium">Kode Voucher (Opsional)</label>
                                    <input type="text" id="voucher-code" name="voucher_code"
                                        class="w-full p-3 rounded-lg bg-gray-800 border border-gray-700 focus:border-purple-500">
                                    <p id="voucher-message" class="text-sm mt-1"></p>
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full mt-6 bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300 capitalize">
                                Pesan Sekarang
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

        .time-slot:hover:not(.unavailable) {
            transform: scale(1.05);
        }

        .time-slot.selected {
            background-color: #9333ea;
            color: white;
            border-color: #9333ea;
        }

        .time-slot.unavailable {
            background-color: #374151;
            /* Darker gray for unavailable */
            color: #6b7280;
            cursor: not-allowed;
            opacity: 0.7;
        }

        #loading-indicator {
            /* Basic styling for loading, improve as needed */
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 20px;
            border-radius: 8px;
            z-index: 1000;
        }
    </style>
    @endpush

    @push('scripts')
    <div id="loading-indicator" class="hidden">Memuat data...</div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // DOM elements
            const serviceCards = document.querySelectorAll('.service-card');
            const bookingFormDiv = document.getElementById('booking-form');
            const formTitle = document.getElementById('form-title');
            const consoleTypeInput = document.getElementById('service-type-input'); // Updated ID
            const roomSelect = document.getElementById('room-select'); // Updated ID
            const timeSlotsContainer = document.getElementById('time-slots-container');
            const bookingDateInput = document.getElementById('booking-date');
            const timeError = document.getElementById('time-error');
            const customerNameInput = document.getElementById('customer-name');
            const loadingIndicator = document.getElementById('loading-indicator');

            // Debug input
            const selectedTimeSlotsStringInput = document.getElementById('selected-time-slots-string');


            let selectedTimeRanges = []; // Menyimpan range waktu yg dipilih, misal ["10:00-11:00", "11:00-12:00"]
            window.roomAvailabilityData = {
                rooms: [],
                booked_slots: {}
            }; // Global store for AJAX data
            let currentSelectedPricePerHour = 0;

            const dbConsoleTypeMap = {
                playstation: 'Playstation',
                nintendo: 'Nintendo',
                vip: 'VIP'
            };

            function showLoading(isLoading) {
                loadingIndicator.classList.toggle('hidden', !isLoading);
            }

            async function fetchRoomDataAndAvailability() {
                const selectedConsoleType = consoleTypeInput.value;
                const selectedDate = bookingDateInput.value;

                if (!selectedConsoleType || !selectedDate) {
                    roomSelect.innerHTML = '<option value="" disabled selected>Pilih Layanan & Tanggal Dahulu</option>';
                    clearTimeSlots();
                    updateBookingSummary();
                    return;
                }
                showLoading(true);

                try {
                    const response = await fetch(`/booking/check-availability?console_type=${selectedConsoleType}&date=${selectedDate}`, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    if (!response.ok) {
                        console.error('Error fetching availability:', response.status, await response.text());
                        alert('Gagal mengambil data ketersediaan ruangan. Silakan coba lagi.');
                        roomSelect.innerHTML = '<option value="" disabled selected>Error mengambil data</option>';
                        clearTimeSlots();
                        return;
                    }

                    const data = await response.json();
                    window.roomAvailabilityData = data;
                    populateRoomSelect(data.rooms);
                    // Setelah populateRoomSelect, jika ada ruangan terpilih, panggil updateDisplayedTimeSlots
                    // Jika tidak, kosongkan slot waktu
                    if (roomSelect.value) {
                        updateDisplayedTimeSlotsForSelectedRoom();
                    } else {
                        clearTimeSlots();
                    }

                } catch (error) {
                    console.error('Failed to fetch room availability:', error);
                    alert('Terjadi kesalahan saat mengambil data.');
                    roomSelect.innerHTML = '<option value="" disabled selected>Kesalahan jaringan</option>';
                    clearTimeSlots();
                } finally {
                    showLoading(false);
                }
            }

            function populateRoomSelect(roomsData) {
                roomSelect.innerHTML = ''; // Kosongkan dulu
                if (roomsData && roomsData.length > 0) {
                    const defaultOption = document.createElement('option');
                    defaultOption.value = "";
                    defaultOption.textContent = "Pilih Ruangan";
                    defaultOption.disabled = true;
                    defaultOption.selected = true;
                    roomSelect.appendChild(defaultOption);

                    roomsData.forEach(room => {
                        const option = document.createElement('option');
                        option.value = room.id;
                        option.textContent = `${room.name} (Rp ${parseFloat(room.price_per_hour).toLocaleString('id-ID')}/jam)`;
                        option.dataset.pricePerHour = room.price_per_hour;
                        option.dataset.roomName = room.name; // Simpan nama untuk referensi jika perlu
                        roomSelect.appendChild(option);
                    });
                } else {
                    const noRoomOption = document.createElement('option');
                    noRoomOption.value = "";
                    noRoomOption.textContent = "Tidak ada ruangan tersedia";
                    noRoomOption.disabled = true;
                    noRoomOption.selected = true;
                    roomSelect.appendChild(noRoomOption);
                }
                updateBookingSummary(); // Update summary jika pilihan ruangan berubah
            }

            function updateDisplayedTimeSlotsForSelectedRoom() {
                const selectedRoomId = roomSelect.value;
                if (!selectedRoomId || !window.roomAvailabilityData.booked_slots) {
                    clearTimeSlots();
                    return;
                }

                const bookedTimeRangesForRoom = window.roomAvailabilityData.booked_slots[selectedRoomId] || [];
                generateAndDisplayTimeSlots(bookedTimeRangesForRoom);
            }

            function clearTimeSlots() {
                timeSlotsContainer.innerHTML = '<p class="text-gray-500 col-span-2 text-center">Pilih ruangan untuk melihat jam tersedia.</p>';
                selectedTimeRanges = [];
                updateBookingSummary();
            }


            function generateAndDisplayTimeSlots(bookedTimeRanges = []) {
                timeSlotsContainer.innerHTML = ''; // Kosongkan container
                selectedTimeRanges = []; // Reset pilihan jam pengguna

                for (let hour = 10; hour < 22; hour++) {
                    const startTime = hour.toString().padStart(2, '0') + ':00';
                    const endTime = (hour + 1).toString().padStart(2, '0') + ':00';
                    const timeRange = `${startTime}-${endTime}`;

                    const timeSlotDiv = document.createElement('div');
                    timeSlotDiv.className = 'time-slot';
                    timeSlotDiv.textContent = timeRange;
                    timeSlotDiv.dataset.timeRange = timeRange; // `data-time-range`
                    timeSlotDiv.dataset.startTime = startTime; // `data-start-time`

                    if (bookedTimeRanges.includes(timeRange)) {
                        timeSlotDiv.classList.add('unavailable');
                    }

                    timeSlotDiv.addEventListener('click', function() {
                        if (this.classList.contains('unavailable')) return;

                        timeError.classList.add('hidden'); // Sembunyikan error dulu
                        const clickedTimeRange = this.dataset.timeRange;

                        if (this.classList.contains('selected')) {
                            this.classList.remove('selected');
                            selectedTimeRanges = selectedTimeRanges.filter(tr => tr !== clickedTimeRange);
                        } else {
                            // Validasi urutan saat MENAMBAHKAN slot baru
                            if (selectedTimeRanges.length > 0) {
                                // Urutkan dulu untuk validasi yang benar
                                const tempSortedSelected = [...selectedTimeRanges, clickedTimeRange].sort((a, b) => a.localeCompare(b));
                                let sequential = true;
                                for (let i = 0; i < tempSortedSelected.length - 1; i++) {
                                    const currentSlotEnd = tempSortedSelected[i].split('-')[1];
                                    const nextSlotStart = tempSortedSelected[i + 1].split('-')[0];
                                    if (currentSlotEnd !== nextSlotStart) {
                                        sequential = false;
                                        break;
                                    }
                                }
                                if (!sequential) {
                                    // Jika slot yang diklik membuat tidak berurutan dengan yang sudah ada
                                    const lastSelectedEnd = selectedTimeRanges[selectedTimeRanges.length - 1].split('-')[1];
                                    const firstSelectedStart = selectedTimeRanges[0].split('-')[0];
                                    const currentClickedStart = clickedTimeRange.split('-')[0];
                                    const currentClickedEnd = clickedTimeRange.split('-')[1];

                                    // Cek apakah bisa ditempel di akhir atau di awal
                                    const canPrepend = currentClickedEnd === firstSelectedStart;
                                    const canAppend = currentClickedStart === lastSelectedEnd;

                                    if (!(canPrepend || canAppend)) {
                                        timeError.classList.remove('hidden');
                                        return; // Jangan tambahkan jika merusak urutan
                                    }
                                }
                            }
                            this.classList.add('selected');
                            selectedTimeRanges.push(clickedTimeRange);
                        }
                        // Selalu urutkan setelah modifikasi
                        selectedTimeRanges.sort((a, b) => a.localeCompare(b));
                        selectedTimeSlotsStringInput.value = selectedTimeRanges.join(','); // Untuk debug atau referensi
                        updateBookingSummary();
                    });
                    timeSlotsContainer.appendChild(timeSlotDiv);
                }
                if (timeSlotsContainer.innerHTML === '') {
                    timeSlotsContainer.innerHTML = '<p class="text-gray-500 col-span-2 text-center">Tidak ada jam tersedia untuk kombinasi ini.</p>';
                }
            }


            function updateBookingSummary() {
                const selectedRoomOption = roomSelect.options[roomSelect.selectedIndex];
                currentSelectedPricePerHour = 0;
                if (selectedRoomOption && selectedRoomOption.dataset.pricePerHour) {
                    currentSelectedPricePerHour = parseFloat(selectedRoomOption.dataset.pricePerHour);
                }

                const duration = selectedTimeRanges.length;
                const totalPrice = duration * currentSelectedPricePerHour;

                document.getElementById('total-duration').textContent = duration;
                document.getElementById('total-price').textContent = totalPrice.toLocaleString('id-ID');
            }

            // Service card selection
            serviceCards.forEach(card => {
                card.addEventListener('click', function() {
                    serviceCards.forEach(c => c.classList.remove('selected'));
                    this.classList.add('selected');

                    const serviceKey = this.dataset.service.toLowerCase(); // playstation, nintendo, vip
                    const serviceName = this.querySelector('h3').textContent;

                    consoleTypeInput.value = dbConsoleTypeMap[serviceKey] || ''; // Set hidden input console_type
                    formTitle.textContent = `Booking ${serviceName}`;
                    bookingFormDiv.classList.remove('hidden'); // Tampilkan form

                    // Reset room select dan time slots sebelum fetch baru
                    roomSelect.innerHTML = '<option value="" disabled selected>Memuat ruangan...</option>';
                    clearTimeSlots();

                    fetchRoomDataAndAvailability(); // Panggil AJAX
                    bookingFormDiv.scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });

            bookingDateInput.addEventListener('change', fetchRoomDataAndAvailability);
            roomSelect.addEventListener('change', function() {
                updateDisplayedTimeSlotsForSelectedRoom();
                updateBookingSummary(); // Harga mungkin berubah jika ada variasi harga per ruangan
            });


            // Form submission
            document.getElementById('booking-data').addEventListener('submit', async function(e) {
                e.preventDefault();
                timeError.classList.add('hidden');

                if (selectedTimeRanges.length === 0) {
                    alert('Silakan pilih setidaknya satu jam booking.');
                    return;
                }

                // Validasi akhir urutan waktu (seharusnya sudah terjaga, tapi double check)
                if (selectedTimeRanges.length > 1) {
                    let sequential = true;
                    for (let i = 0; i < selectedTimeRanges.length - 1; i++) {
                        if (selectedTimeRanges[i].split('-')[1] !== selectedTimeRanges[i + 1].split('-')[0]) {
                            sequential = false;
                            break;
                        }
                    }
                    if (!sequential) {
                        timeError.classList.remove('hidden');
                        alert('Jam booking yang dipilih tidak berurutan. Harap perbaiki.');
                        return;
                    }
                }


                const bookingDate = bookingDateInput.value;
                const firstSlotStartTime = selectedTimeRanges[0].split('-')[0]; // Ambil jam mulai dari slot pertama
                const finalStartTime = `${bookingDate} ${firstSlotStartTime}:00`; // Format YYYY-MM-DD HH:MM:SS

                const duration = selectedTimeRanges.length;

                const formData = new FormData(this); // 'this' adalah form
                formData.set('start_time', finalStartTime); // Ini yang akan dikirim ke backend
                formData.set('duration_hour', duration);
                // Total price juga bisa dihitung di backend untuk keamanan, tapi kita set dari frontend
                formData.set('total_price', parseFloat(document.getElementById('total-price').textContent.replace(/\./g, '').replace(/,/g, '.'))); // Pastikan format angka benar
                // room_id sudah otomatis terambil dari select name="room_id"
                // console_type sudah otomatis terambil dari input hidden name="console_type"


                showLoading(true);
                try {
                    const response = await fetch("{{ route('user.booking.store') }}", { // Menggunakan route Laravel
                        method: 'POST',
                        headers: {
                            // 'Content-Type': 'application/json', // Tidak perlu jika pakai FormData
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: formData // FormData akan otomatis set Content-Type ke multipart/form-data
                    });

                    const responseData = await response.json(); // Selalu coba parse JSON

                    if (response.ok) {
                        // Berhasil, redirect atau tampilkan pesan sukses
                        // window.location.href = `/user/bookings/${responseData.booking_id}`; 
                        window.location.href = `/user/payment/${responseData.booking_id}`; 
                    } else {
                        // Tangani error validasi atau error server lainnya
                        let errorMessage = "Booking gagal!";
                        if (responseData.message) {
                            errorMessage = responseData.message;
                        }
                        if (responseData.errors) {
                            // Jika ada error validasi dari Laravel
                            const errors = Object.values(responseData.errors).map(errArray => errArray.join('\n')).join('\n');
                            errorMessage += `\n\nDetail:\n${errors}`;
                        }
                        alert(errorMessage);
                    }
                } catch (error) {
                    console.error("Submit error:", error);
                    alert("Terjadi kesalahan saat mengirim data booking.");
                } finally {
                    showLoading(false);
                }
            });

            // Initialize
            // Tidak generate slot waktu di awal, tunggu user memilih layanan dan tanggal
            clearTimeSlots();
            // Jika ada nilai awal untuk tanggal (misalnya dari old input), bisa picu fetch di sini
            if (consoleTypeInput.value && bookingDateInput.value) {
                fetchRoomDataAndAvailability();
            }

        });
    </script>
    @endpush
</x-app-layout>
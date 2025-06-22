<x-layouts.admin>
    {{-- Diasumsikan Anda sudah memuat JavaScript Flowbite di layout utama --}}

    <style>
        .stat-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        /* Style untuk tooltip chart agar sesuai tema gelap */
        .apexcharts-tooltip.apexcharts-theme-dark {
            background: #1F2937;
            /* bg-gray-800 */
            border-color: #111827;
            /* bg-gray-900 */
        }
    </style>

    {{-- STATISTIC CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-3">
        <div class="stat-card bg-blue-800 p-6 rounded-lg shadow-lg text-center">
            <div class="text-lg font-semibold text-blue-200">TOTAL BOOKING SUKSES</div>
            <div class="text-3xl font-bold mt-2">{{ $totalBooking }}</div>
        </div>
        <div class="stat-card bg-green-800 p-6 rounded-lg shadow-lg text-center">
            <div class="text-lg font-semibold text-green-200">KEUNTUNGAN</div>
            <div class="text-3xl font-bold mt-2">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card bg-red-800 p-6 rounded-lg shadow-lg text-center">
            <div class="text-lg font-semibold text-red-200">PERLU KONFIRMASI</div>
            <div class="text-3xl font-bold mt-2">{{ $pendingPayments }}</div>
        </div>
    </div>

    {{-- CHART AREA (Menggunakan komponen Flowbite) --}}
    <div class="chart-area mt-8">
        <div class="w-full bg-gray-800 rounded-lg shadow-lg p-4 md:p-6">
            <div class="flex justify-between items-start w-full">
                <div class="flex-col items-center">
                    <div class="flex items-center mb-1">
                        <h5 class="text-xl font-bold leading-none text-white me-1">Grafik Keuntungan</h5>
                    </div>
                </div>
                {{-- Opsi dropdown dari Flowbite bisa ditambahkan di sini jika diperlukan --}}
            </div>

            <!-- Area untuk render Line Chart -->
            <div class="py-6" id="revenue-chart"></div>

            <div class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between">
                <div class="flex justify-between items-center pt-5">
                    <!-- Tombol Dropdown (opsional) -->
                    <button id="dropdownDefaultButton" data-dropdown-toggle="lastDaysdropdown"
                        data-dropdown-placement="bottom"
                        class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white"
                        type="button">
                        Last 7 days
                        <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <div id="lastDaysdropdown"
                        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                            aria-labelledby="dropdownDefaultButton">
                            <li>
                                <a href="#"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Yesterday</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Today</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last
                                    7 days</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- RECENT TRANSACTIONS TABLE --}}
    <div class="table-container bg-gray-800 p-5 mt-8 rounded-lg shadow-lg">
        <h5 class="mb-4 text-xl font-semibold text-white">5 Transaksi Terakhir yang Berhasil</h5>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="border-b border-gray-600 p-3 text-left text-sm font-semibold text-gray-300">No</th>
                        <th class="border-b border-gray-600 p-3 text-left text-sm font-semibold text-gray-300">Nama
                            Pelanggan</th>
                        <th class="border-b border-gray-600 p-3 text-left text-sm font-semibold text-gray-300">Jenis
                            Console</th>
                        <th class="border-b border-gray-600 p-3 text-left text-sm font-semibold text-gray-300">Ruangan
                        </th>
                        <th class="border-b border-gray-600 p-3 text-left text-sm font-semibold text-gray-300">Tanggal
                            Bayar</th>
                        <th class="border-b border-gray-600 p-3 text-right text-sm font-semibold text-gray-300">Total
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800 text-white">
                    @forelse ($recentTransactions as $payment)
                        <tr class="hover:bg-gray-700/50">
                            <td class="p-3 border-b border-gray-700">{{ $loop->iteration }}</td>
                            <td class="p-3 border-b border-gray-700">{{ $payment->booking->user->name }}</td>
                            <td class="p-3 border-b border-gray-700">{{ $payment->booking->room->console_type }}</td>
                            <td class="p-3 border-b border-gray-700">{{ $payment->booking->room->name }}</td>
                            <td class="p-3 border-b border-gray-700">
                                {{ $payment->paid_at ? $payment->paid_at->format('d M Y, H:i') : '-' }}</td>
                            <td class="p-3 border-b border-gray-700 text-right font-mono">
                                Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center p-5 text-gray-500">
                                Belum ada transaksi yang berhasil.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
        {{-- Import library ApexCharts --}}
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const options = {
                    chart: {
                        type: 'area',
                        height: "345px",
                        width: "100%",
                        fontFamily: "Inter, sans-serif",
                        dropShadow: {
                            enabled: false
                        },
                        toolbar: {
                            show: false
                        },
                        foreColor: '#9CA3AF'
                    },
                    series: [{
                        name: 'Pendapatan',
                        data: @json($chartData),
                        color: "#8B5CF6",
                    }],
                    xaxis: {
                        categories: @json($chartLabels),
                        labels: {
                            style: {
                                colors: '#9CA3AF'
                            }
                        },
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        },
                    },
                    yaxis: {
                        show: true,
                        labels: {
                            style: {
                                colors: '#9CA3AF'
                            },
                            formatter: function(value) {
                                if (value >= 1000) {
                                    return 'Rp' + (value / 1000) + 'k';
                                }
                                return 'Rp' + value;
                            }
                        }
                    },
                    grid: {
                        borderColor: '#374151',
                        strokeDashArray: 5,
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth'
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            opacityFrom: 0.55,
                            opacityTo: 0,
                        }
                    },
                    tooltip: {
                        theme: 'dark',
                        y: {
                            formatter: function(value) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                            }
                        }
                    },
                };

                // Pastikan elemen target ada sebelum render
                if (document.getElementById("revenue-chart")) {
                    const chart = new ApexCharts(document.getElementById("revenue-chart"), options);
                    chart.render();
                }
            });
        </script>
    @endpush
</x-layouts.admin>

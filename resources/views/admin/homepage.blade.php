<x-layouts.admin>
    {{-- Style tidak berubah --}}
    <style>
        .stat-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
    </style>

    {{-- FILTER TANGGAL GLOBAL --}}
    <div class="bg-gray-800 rounded-lg shadow-lg p-4 mb-6">
        <div class="flex flex-col sm:flex-row justify-between items-center">
            <h4 class="text-lg font-semibold text-white mb-3 sm:mb-0">Tampilkan Laporan untuk:</h4>
            {{-- Pastikan nama route 'admin.homepage' sudah benar di web.php --}}
            <form action="{{ route('admin.home') }}" method="GET" class="flex items-center space-x-2">
                <div>
                    <label for="start_date" class="sr-only">Mulai:</label>
                    <input type="date" name="start_date" id="start_date" value="{{ $start_date }}"
                        class="bg-gray-700 border-gray-600 text-white text-sm rounded-lg p-2">
                </div>
                <div>
                    <label for="end_date" class="sr-only">Selesai:</label>
                    <input type="date" name="end_date" id="end_date" value="{{ $end_date }}"
                        class="bg-gray-700 border-gray-600 text-white text-sm rounded-lg p-2">
                </div>
                <button type="submit"
                    class="self-end px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">Filter</button>
            </form>
        </div>
    </div>


    {{-- KARTU STATISTIK DENGAN JUDUL DINAMIS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-3">
        <div class="stat-card bg-blue-800 p-6 rounded-lg shadow-lg text-center">
            <div class="text-lg font-semibold text-blue-200">BOOKING SUKSES <br> <span
                    class="text-base">({{ $dateTitle }})</span></div>
            <div class="text-3xl font-bold mt-2">{{ $totalBooking }}</div>
        </div>
        <div class="stat-card bg-green-800 p-6 rounded-lg shadow-lg text-center">
            <div class="text-lg font-semibold text-green-200">KEUNTUNGAN <br> <span
                    class="text-base">({{ $dateTitle }})</span></div>
            <div class="text-3xl font-bold mt-2">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card bg-red-800 p-6 rounded-lg shadow-lg text-center">
            <div class="text-lg font-semibold text-red-200">PERLU KONFIRMASI</div>
            <div class="text-3xl font-bold mt-2">{{ $pendingPayments }}</div>
        </div>
    </div>

    {{-- KONTEN UTAMA DENGAN DUA GRAFIK --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-8">
        {{-- KOLOM KIRI UNTUK PIE CHART --}}
        <div class="lg:col-span-1">
            <div class="w-full bg-gray-800 rounded-lg shadow-lg p-4 md:p-6">
                <div class="flex justify-between items-center mb-4">
                    <h5 class="text-xl font-bold leading-none text-white">Pendapatan per Konsol <span
                            class="text-base font-normal">({{ $dateTitle }})</span></h5>
                </div>
                <div class="py-3 min-h-[350px] flex items-center justify-center" id="console-pie-chart"></div>
                <div class="grid grid-cols-1 items-center border-t border-gray-700 justify-between pt-5">
                    <p class="text-center text-sm font-medium text-gray-400">Total pendapatan berdasarkan jenis konsol.
                    </p>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN UNTUK GRAFIK AREA --}}
        <div class="lg:col-span-2">
            <div class="w-full bg-gray-800 rounded-lg shadow-lg p-4 md:p-6">
                <div class="flex justify-between items-center w-full mb-4">
                    <h5 class="text-xl font-bold leading-none text-white me-1">Grafik Keuntungan Harian</h5>
                </div>
                <div class="py-6" id="revenue-area-chart"></div>
            </div>
        </div>
    </div>

    {{-- TABEL TRANSAKSI (Tidak diubah) --}}
    <div class="table-container bg-gray-800 p-5 mt-8 rounded-lg shadow-lg">
        <h5 class="mb-4 text-xl font-semibold text-white">5 Transaksi Terakhir yang Berhasil</h5>
        {{-- ... isi tabel sama seperti sebelumnya ... --}}
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
                        <th class="border-b border-gray-600 p-3 text-left text-sm font-semibold text-gray-300">Status
                        </th>
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
                            <td class="p-3 border-b border-gray-700">{{ $payment->paid_at->format('d M Y, H:i') }}</td>
                            <td class="p-3 border-b border-gray-700">
                                <span
                                    class="px-2 py-1 text-xs font-bold rounded-full bg-green-500 text-green-900">{{ ucfirst($payment->payment_status) }}</span>
                            </td>
                            <td class="p-3 border-b border-gray-700 text-right font-mono">
                                Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center p-5 text-gray-500">Belum ada transaksi yang berhasil.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- SKRIP JAVASCRIPT (Tidak ada perubahan) --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        // ... kode javascript sama persis seperti sebelumnya ...
        document.addEventListener("DOMContentLoaded", () => {
            const areaChartEl = document.querySelector("#revenue-area-chart");
            if (areaChartEl) {
                const areaChartOptions = {
                    chart: {
                        type: 'area',
                        height: '400px',
                        background: 'transparent',
                        toolbar: {
                            show: false
                        }
                    },
                    theme: {
                        mode: 'dark'
                    },
                    series: [{
                        name: "Pendapatan",
                        data: {!! json_encode($areaChartData) !!}
                    }],
                    xaxis: {
                        categories: {!! json_encode($areaChartLabels) !!}
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 3
                    },
                    tooltip: {
                        y: {
                            formatter: (value) => `Rp${new Intl.NumberFormat('id-ID').format(value)}`
                        }
                    },
                    yaxis: {
                        labels: {
                            formatter: (value) => {
                                if (value >= 1000) {
                                    return `Rp${value/1000}K`
                                }
                                return `Rp${value}`;
                            }
                        }
                    },
                    grid: {
                        borderColor: '#374151'
                    },
                };
                const areaChart = new ApexCharts(areaChartEl, areaChartOptions);
                areaChart.render();
            }

            const pieChartEl = document.querySelector("#console-pie-chart");

            if (pieChartEl) {
                const pieChartOptions = {
                    series: {!! json_encode($pieChartData) !!},
                    labels: {!! json_encode($pieChartLabels) !!},
                    chart: {
                        type: 'pie',
                        height: 350,
                        background: 'transparent'
                    },
                    theme: {
                        mode: 'dark',
                        palette: 'palette3'
                    },
                    stroke: {
                        colors: ['#1f2937']
                    },
                    legend: {
                        position: 'bottom',
                        horizontalAlign: 'center'
                    },
                    tooltip: {
                        y: {
                            formatter: (value) => `Rp ${new Intl.NumberFormat('id-ID').format(value)}`
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function(val, opts) {
                            const label = opts.w.globals.labels[opts.seriesIndex];
                            const value = opts.w.globals.series[opts.seriesIndex];
                            const formattedValue = new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                minimumFractionDigits: 0
                            }).format(value);
                            return `${label}: ${formattedValue}`;
                        },
                        style: {
                            fontSize: '14px',
                            colors: ['#fff']
                        }
                    },
                    noData: {
                        text: 'Belum ada data pendapatan per konsol',
                        align: 'center',
                        verticalAlign: 'middle',
                        offsetX: 0,
                        offsetY: 0,
                        style: {
                            color: '#9CA3AF',
                            fontSize: '14px',
                            fontFamily: 'Inter, sans-serif'
                        }
                    }
                };

                const pieChart = new ApexCharts(pieChartEl, pieChartOptions);
                pieChart.render();
            }

        });
    </script>
</x-layouts.admin>

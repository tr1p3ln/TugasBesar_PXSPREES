<x-layouts.admin>
    {{-- Style tidak berubah --}}
    <style>
        /* Anda bisa memindahkan style ini ke file CSS utama jika diinginkan */
        .stat-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
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

    {{-- RECENT TRANSACTIONS TABLE --}}
    <div class="table-container bg-gray-800 p-5 mt-8 rounded-lg shadow-lg">
        <h5 class="mb-4 text-xl font-semibold text-white">5 Transaksi Terakhir yang Berhasil</h5>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="border-b border-gray-600 p-3 text-left text-sm font-semibold text-gray-300">No</th>
                        <th class="border-b border-gray-600 p-3 text-left text-sm font-semibold text-gray-300">Nama Pelanggan</th>
                        <th class="border-b border-gray-600 p-3 text-left text-sm font-semibold text-gray-300">Jenis Console</th>
                        <th class="border-b border-gray-600 p-3 text-left text-sm font-semibold text-gray-300">Ruangan</th>
                        <th class="border-b border-gray-600 p-3 text-left text-sm font-semibold text-gray-300">Tanggal Bayar</th>
                        <th class="border-b border-gray-600 p-3 text-left text-sm font-semibold text-gray-300">Status</th>
                        <th class="border-b border-gray-600 p-3 text-right text-sm font-semibold text-gray-300">Total</th>
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
                                <span class="px-2 py-1 text-xs font-bold rounded-full bg-green-500 text-green-900">
                                    {{ ucfirst($payment->payment_status) }}
                                </span>
                            </td>
                            <td class="p-3 border-b border-gray-700 text-right font-mono">Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center p-5 text-gray-500">
                                Belum ada transaksi yang berhasil.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Chart Area --}}
    <div class="chart-area mt-8 bg-gray-800 p-4 rounded-lg shadow-lg">
        <h5 class="mb-4 text-xl font-semibold text-white">Grafik Keuntungan</h5>
        <div id="chart" style="height: 300px;">
            {{-- Implementasi chart (misal: dengan ApexCharts atau Chart.js) bisa ditambahkan di sini --}}
            <p class="text-gray-500 text-center">Area untuk menampilkan grafik.</p>
        </div>
    </div>

    {{-- SKRIP JAVASCRIPT (Tidak ada perubahan)
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        // ... kode javascript sama persis seperti sebelumnya ...
        document.addEventListener("DOMContentLoaded", () => {
            const areaChartEl = document.querySelector("#revenue-area-chart");
            if (areaChartEl) {
                const areaChartOptions = {
                    chart: { type: 'area', height: '400px', background: 'transparent', toolbar: { show: false }},
                    theme: { mode: 'dark' },
                    series: [{ name: "Pendapatan", data: {!! json_encode($areaChartData) !!} }],
                    xaxis: { categories: {!! json_encode($areaChartLabels) !!} },
                    dataLabels: { enabled: false },
                    stroke: { curve: 'smooth', width: 3 },
                    tooltip: { y: { formatter: (value) => `Rp${new Intl.NumberFormat('id-ID').format(value)}` } },
                    grid: { borderColor: '#374151' },
                    yaxis: {
                        // ⬇️ TAMBAHAN BARU: Menetapkan nilai maksimum secara eksplisit
                        max: {!! $yAxisMax !!},
                        labels: {
                            formatter: (value) => {
                                if (value >= 1000) { return `Rp${value/1000}K` }
                                return `Rp${value}`;
                            }
                        }
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
    </script> --}}
</x-layouts.admin>

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf; // Asumsi Anda menggunakan library ini untuk PDF

class AdminController extends Controller
{
    /**
     * Menampilkan halaman dashboard admin dengan data statistik dan grafik.
     */
    public function homepage(Request $request)
    {
        // Menentukan rentang tanggal dari input atau default ke hari ini
        $startDateInput = $request->input('start_date') ?? Carbon::now()->toDateString();
        $endDateInput = $request->input('end_date') ?? Carbon::now()->toDateString();
        $startDate = Carbon::parse($startDateInput)->startOfDay();
        $endDate = Carbon::parse($endDateInput)->endOfDay();
        
        // Membuat judul dinamis berdasarkan rentang tanggal
        $dateTitle = ($startDateInput == $endDateInput) 
            ? 'Hari Ini (' . Carbon::parse($startDateInput)->format('d M Y') . ')' 
            : 'Periode ' . Carbon::parse($startDateInput)->format('d M') . ' - ' . Carbon::parse($endDateInput)->format('d M Y');
        
        // MENGAMBIL DATA UNTUK KARTU STATISTIK
        $totalRevenue = Payment::where('payment_status', 'paid')->whereBetween('paid_at', [$startDate, $endDate])->sum('amount');
        $totalSuccessfulBookings = Payment::where('payment_status', 'paid')->whereBetween('paid_at', [$startDate, $endDate])->count();
        $pendingPaymentsCount = Payment::where('payment_status', 'pending')->whereNotNull('payment_proof')->count();
        
        // MENGAMBIL DATA UNTUK TABEL TRANSAKSI TERBARU
        $recentTransactions = Payment::where('payment_status', 'paid')
                                     ->with(['booking.user', 'booking.room'])
                                     ->latest('paid_at')
                                     ->take(5)
                                     ->get();

        // MENYIAPKAN DATA UNTUK GRAFIK AREA (PENDAPATAN HARIAN)
        $revenueData = Payment::where('payment_status', 'paid')
            ->whereBetween('paid_at', [$startDate, $endDate])
            ->select(DB::raw('DATE(paid_at) as date'), DB::raw('sum(amount) as total'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->pluck('total', 'date');

        $dateRange = Carbon::parse($startDate)->toPeriod($endDate);
        $areaChartData = [];
        $areaChartLabels = [];

        foreach ($dateRange as $date) {
            $formattedDate = $date->format('Y-m-d');
            $areaChartLabels[] = $date->format('d M');
            $areaChartData[] = (int) ($revenueData[$formattedDate] ?? 0);
        }
        
        // Menghitung nilai maksimum untuk sumbu Y pada grafik
        $maxRevenueForChart = count($areaChartData) > 0 ? max($areaChartData) : 0;
        $yAxisMax = $maxRevenueForChart > 0 ? floor($maxRevenueForChart * 1.1) : 100000;

        // MENYIAPKAN DATA UNTUK PIE CHART (PENDAPATAN PER TIPE KONSOL)
        $allConsoleTypes = Room::distinct()->pluck('console_type');
        $revenueByConsole = Payment::where('payments.payment_status', 'paid')
            ->whereBetween('payments.paid_at', [$startDate, $endDate])
            ->join('bookings', 'payments.booking_id', '=', 'bookings.id')
            ->join('rooms', 'bookings.room_id', '=', 'rooms.id')
            ->select('rooms.console_type', DB::raw('SUM(payments.amount) as total_revenue'))
            ->groupBy('rooms.console_type')
            ->pluck('total_revenue', 'console_type');
            
        $pieChartLabels = $allConsoleTypes;
        $pieChartData = $allConsoleTypes->map(function ($consoleType) use ($revenueByConsole) {
            return (int) ($revenueByConsole[$consoleType] ?? 0);
        })->values();

        // MENGIRIM SEMUA DATA KE VIEW
        return view('admin.homepage', [
            'totalRevenue' => $totalRevenue,
            'totalBooking' => $totalSuccessfulBookings,
            'pendingPayments' => $pendingPaymentsCount,
            'recentTransactions' => $recentTransactions,
            'areaChartLabels' => $areaChartLabels,
            'areaChartData' => $areaChartData,
            'yAxisMax' => $yAxisMax,
            'pieChartLabels' => $pieChartLabels,
            'pieChartData' => $pieChartData,
            'start_date' => $startDateInput,
            'end_date' => $endDateInput,
            'dateTitle' => $dateTitle,
        ]);
    }

    /**
     * Fungsi untuk export PDF (contoh).
     */
    public function exportPDF()
    {
        // Anda perlu menambahkan logika untuk mengambil data yang ingin diekspor
        $data = [
            'title' => 'Laporan Transaksi',
            // ...data lainnya
        ]; 

        $pdf = Pdf::loadView('pdf.transactions', $data); // Buat view pdf.transactions
        return $pdf->download('laporan-transaksi.pdf');
    }
}

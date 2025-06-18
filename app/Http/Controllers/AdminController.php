<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Payment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function homepage(Request $request)
    {
        // =======================================================
        // 1. LOGIKA FILTER TANGGAL (SEKARANG BERLAKU GLOBAL)
        // =======================================================
        // Defaultnya sekarang adalah HARI INI, bukan 7 hari terakhir.
        $startDateInput = $request->input('start_date') ?? Carbon::now()->toDateString();
        $endDateInput = $request->input('end_date') ?? Carbon::now()->toDateString();
        
        $startDate = Carbon::parse($startDateInput)->startOfDay();
        $endDate = Carbon::parse($endDateInput)->endOfDay();

        // Membuat judul dinamis untuk ditampilkan di view
        if ($startDateInput == $endDateInput) {
            $dateTitle = 'Hari Ini (' . Carbon::parse($startDateInput)->format('d M Y') . ')';
        } else {
            $dateTitle = 'Periode ' . Carbon::parse($startDateInput)->format('d M') . ' - ' . Carbon::parse($endDateInput)->format('d M Y');
        }

        // =======================================================
        // 2. DATA KARTU STATISTIK (SEKARANG MENGGUNAKAN FILTER TANGGAL)
        // =======================================================
        $totalRevenue = Payment::where('payment_status', 'paid')
            ->whereBetween('paid_at', [$startDate, $endDate]) // <-- DITERAPKAN FILTER
            ->sum('amount');

        $totalSuccessfulBookings = Payment::where('payment_status', 'paid')
            ->whereBetween('paid_at', [$startDate, $endDate]) // <-- DITERAPKAN FILTER
            ->count();
            
        // "Perlu Konfirmasi" tidak difilter tanggal karena ini adalah tugas saat ini (real-time)
        $pendingPaymentsCount = Payment::where('payment_status', 'pending')
            ->whereNotNull('payment_proof')
            ->count();
        
        // "Transaksi Terakhir" juga tidak difilter untuk selalu menampilkan yang paling baru
        $recentTransactions = Payment::where('payment_status', 'paid')
            ->with(['booking.user', 'booking.room'])
            ->latest('paid_at')
            ->take(5)
            ->get();

        // =======================================================
        // 3. LOGIKA GRAFIK AREA (Tidak ada perubahan, sudah menggunakan filter)
        // =======================================================
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
            $areaChartData[] = $revenueData[$formattedDate] ?? 0;
        }

        // =======================================================
        // 4. LOGIKA PIE CHART (SEKARANG MENGGUNAKAN FILTER TANGGAL)
        // =======================================================
        $allConsoleTypes = Room::distinct()->pluck('console_type');
        
        $revenueByConsole = Payment::where('payments.payment_status', 'paid')
            ->whereBetween('payments.paid_at', [$startDate, $endDate]) // <-- DITERAPKAN FILTER
            ->join('bookings', 'payments.booking_id', '=', 'bookings.id')
            ->join('rooms', 'bookings.room_id', '=', 'rooms.id')
            ->select('rooms.console_type', DB::raw('SUM(payments.amount) as total_revenue'))
            ->groupBy('rooms.console_type')
            ->pluck('total_revenue', 'console_type');

        $pieChartLabels = $allConsoleTypes;
        $pieChartData = $allConsoleTypes->map(function ($consoleType) use ($revenueByConsole) {
            return (int) ($revenueByConsole[$consoleType] ?? 0);
        })->values();

        // =======================================================
        // 5. KIRIM SEMUA DATA KE VIEW
        // =======================================================
        return view('admin.homepage', [
            'totalRevenue' => $totalRevenue,
            'totalBooking' => $totalSuccessfulBookings,
            'pendingPayments' => $pendingPaymentsCount,
            'recentTransactions' => $recentTransactions,
            'areaChartLabels' => $areaChartLabels,
            'areaChartData' => $areaChartData,
            'pieChartLabels' => $pieChartLabels,
            'pieChartData' => $pieChartData,
            'start_date' => $startDateInput,
            'end_date' => $endDateInput,
            'dateTitle' => $dateTitle, // <-- Kirim judul dinamis ke view
        ]);
    }
}
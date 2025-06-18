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
        // ... (Kode untuk filter tanggal dan kartu statistik tidak berubah)
        $startDateInput = $request->input('start_date') ?? Carbon::now()->toDateString();
        $endDateInput = $request->input('end_date') ?? Carbon::now()->toDateString();
        $startDate = Carbon::parse($startDateInput)->startOfDay();
        $endDate = Carbon::parse($endDateInput)->endOfDay();
        $dateTitle = ($startDateInput == $endDateInput) ? 'Hari Ini (' . Carbon::parse($startDateInput)->format('d M Y') . ')' : 'Periode ' . Carbon::parse($startDateInput)->format('d M') . ' - ' . Carbon::parse($endDateInput)->format('d M Y');
        
        $totalRevenue = Payment::where('payment_status', 'paid')->whereBetween('paid_at', [$startDate, $endDate])->sum('amount');
        $totalSuccessfulBookings = Payment::where('payment_status', 'paid')->whereBetween('paid_at', [$startDate, $endDate])->count();
        $pendingPaymentsCount = Payment::where('payment_status', 'pending')->whereNotNull('payment_proof')->count();
        $recentTransactions = Payment::where('payment_status', 'paid')->with(['booking.user', 'booking.room'])->latest('paid_at')->take(5)->get();

        // LOGIKA GRAFIK AREA
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
        
        // =======================================================
        // TAMBAHAN BARU: Menghitung Nilai Maksimum untuk Sumbu-Y
        // =======================================================
        // Cari nilai tertinggi dari data pendapatan yang ada
        $maxRevenueForChart = count($areaChartData) > 0 ? max($areaChartData) : 0;
        // Tambahkan 10% padding agar grafik tidak menyentuh atap, atau set default jika tidak ada data
        $yAxisMax = $maxRevenueForChart > 0 ? floor($maxRevenueForChart * 1.1) : 100000; // Default max 100K jika tidak ada pendapatan


        // LOGIKA PIE CHART (tidak berubah)
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

        // KIRIM SEMUA DATA KE VIEW
        return view('admin.homepage', [
            'totalRevenue' => $totalRevenue,
            'totalBooking' => $totalSuccessfulBookings,
            'pendingPayments' => $pendingPaymentsCount,
            'recentTransactions' => $recentTransactions,
            'areaChartLabels' => $areaChartLabels,
            'areaChartData' => $areaChartData,
            'yAxisMax' => $yAxisMax, // <-- KIRIM NILAI MAKSIMUM KE VIEW
            'pieChartLabels' => $pieChartLabels,
            'pieChartData' => $pieChartData,
            'start_date' => $startDateInput,
            'end_date' => $endDateInput,
            'dateTitle' => $dateTitle,
        ]);
    }
}
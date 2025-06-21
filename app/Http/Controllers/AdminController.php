<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function homepage()
    {
        // 1. Menghitung Keuntungan: Jumlahkan 'amount' dari semua payment yang statusnya 'paid'
        $totalRevenue = Payment::where('payment_status', 'paid')->sum('amount');

        // 2. Menghitung Total Booking Sukses: Hitung jumlah payment yang statusnya 'paid'
        $totalSuccessfulBookings = Payment::where('payment_status', 'paid')->count();

        // 3. Menghitung Pesanan Masuk: Hitung jumlah payment 'pending' yang sudah ada bukti bayar
        $pendingPaymentsCount = Payment::where('payment_status', 'pending')
            ->whereNotNull('payment_proof')
            ->count();

        // 4. (Bonus) Ambil data transaksi terbaru untuk ditampilkan di tabel
        $recentTransactions = Payment::where('payment_status', 'paid')
            ->with(['booking.user', 'booking.room']) // Eager load untuk efisiensi
            ->whereNotNull('paid_at') // Memastikan hanya mengambil data dengan tanggal bayar
            ->take(5) // Ambil 5 data teratas
            ->get();

        // Kirim semua data ke view
        return view('admin.homepage', [
            'totalRevenue' => $totalRevenue,
            'totalBooking' => $totalSuccessfulBookings, // Gunakan nama variabel 'totalBooking' sesuai view
            'pendingPayments' => $pendingPaymentsCount, // Gunakan nama variabel 'pendingPayments'
            'recentTransactions' => $recentTransactions,
        ]);
    }

    // Fungsi untuk menampilkan halaman riwayat transaksi
    public function historydata(Request $request)
    {
        $filterDate = $request->input('filter_date');

        $payments = Payment::query();

        if ($filterDate) {
            $payments->whereDate('created_at', $filterDate);
        }

        $payments = $payments->get();

        return view('admin.historydata', compact('payments'));
    }

    // Fungsi untuk export PDF
    public function exportPDF(Request $request)
    {
        $filterDate = $request->input('filter_date');

        $payments = Payment::query();

        if ($filterDate) {
            $payments->whereDate('created_at', $filterDate);
        }

        $payments = $payments->get();

        $pdf = Pdf::loadView('admin.exportpdf', compact('payments', 'filterDate'));
        return $pdf->download('history-transaksi.pdf');
    }

    public function bookingData(Request $request)
    {
        $query = Booking::query();

        if ($request->has('filter_date') && $request->filter_date) {
            $query->whereDate('start_time', $request->filter_date);
        }

        $bookings = $query->orderBy('start_time', 'desc')->get();
        return view('admin.bookingdata', compact('bookings'));
    }

    // public function homepage()
    // {
    //     $totalBooking = \App\Models\Booking::count();
    //     return view('admin.homepage', compact('totalBooking'));
    // }
}

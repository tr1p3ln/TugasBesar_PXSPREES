<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
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
    // public function exportPDF(Request $request)
    // {
    //     $filterDate = $request->input('filter_date');

    //     $payments = Payment::query();

    //     if ($filterDate) {
    //         $payments->whereDate('created_at', $filterDate);
    //     }

    //     $payments = $payments->get();

    //     $pdf = Pdf::loadView('admin.exportpdf', compact('payments', 'filterDate'));
    //     return $pdf->download('history-transaksi.pdf');
    // }
    
    public function bookingData(Request $request)
    {
        $query = Booking::query();

        if ($request->has('filter_date') && $request->filter_date) {
            $query->whereDate('start_time', $request->filter_date);
        }

        $bookings = $query->orderBy('start_time', 'desc')->get();
        return view('admin.bookingdata', compact('bookings'));
    }

    public function homepage()
    {
        $totalBooking = \App\Models\Booking::count();
        return view('admin.homepage', compact('totalBooking'));
    }
}
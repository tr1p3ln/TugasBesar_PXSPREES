<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================
// Guest & General Routes
// ==========================
Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/booking/check-availability', [BookingController::class, 'checkAvailability'])->name('booking.checkAvailability');


// ==========================
// Email Verification Routes
// ==========================
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        if ($request->user()->role === 'admin') {
            return redirect()->route('admin.home');
        }
        return redirect()->route('user.home');
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'verification-link-sent');
    })->middleware('throttle:6,1')->name('verification.send');
});


// ===========================================
// ADMIN ROUTES
// ===========================================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'is_admin'])->group(function () {
    // General Admin
    Route::get('/homepage', [AdminController::class, 'homepage'])->name('home'); // admin.home
    Route::get('/exportpdf', [AdminController::class, 'exportPDF'])->name('exportpdf'); // admin.exportpdf

    // Rooms Management (CRUD)
    Route::get('/keloladata', [RoomController::class, 'view'])->name('keloladata'); // admin.keloladata
    Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create'); // admin.rooms.create
    Route::post('/rooms/create', [RoomController::class, 'store'])->name('rooms.store'); // admin.rooms.store
    Route::get('/rooms/{id}/edit', [RoomController::class, 'edit'])->name('rooms.edit'); // admin.rooms.edit
    Route::put('/rooms/{id}', [RoomController::class, 'update'])->name('rooms.update'); // admin.rooms.update
    Route::delete('/rooms/{id}', [RoomController::class, 'destroy'])->name('rooms.destroy'); // admin.rooms.destroy

    // Vouchers Management (CRUD)
    Route::get('/voucher', [VoucherController::class, 'view'])->name('voucher'); // admin.voucher
    Route::get('/vouchers/create', [VoucherController::class, 'create'])->name('vouchers.create'); // admin.vouchers.create
    Route::post('/vouchers/create', [VoucherController::class, 'store'])->name('vouchers.store'); // admin.vouchers.store
    Route::get('/vouchers/{id}/edit', [VoucherController::class, 'edit'])->name('vouchers.edit'); // admin.vouchers.edit
    Route::put('/vouchers/{id}', [VoucherController::class, 'update'])->name('vouchers.update'); // admin.vouchers.update
    Route::delete('/vouchers/{id}', [VoucherController::class, 'destroy'])->name('vouchers.destroy'); // admin.vouchers.destroy

    // Booking & Payment Data Views
    Route::get('/bookingdata', [BookingController::class, 'view'])->name('bookingdata'); // admin.bookingdata
    Route::get('/historydata', [PaymentController::class, 'view'])->name('historydata'); // admin.historydata

    // Payment Confirmation
    Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index'); // admin.payments.index
    Route::get('/payments/{payment}/show', [AdminPaymentController::class, 'show'])->name('payments.show'); // admin.payments.show
    Route::post('/payments/{payment}/confirm', [AdminPaymentController::class, 'confirm'])->name('payments.confirm'); // admin.payments.confirm
});


// ==========================
// USER ROUTES
// ==========================
Route::middleware(['auth', 'verified', 'is_user'])->group(function () {
    Route::get('/user/homepage', function () {
        return view('user.homepage');
    })->name('user.home');

    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard');

    Route::get('/user/merchant', function () {
        return view('user.merchant');
    })->name('merchant');

    // User Booking Process
    Route::get('/user/booking', [BookingController::class, 'create'])->name('booking');
    Route::post('/user/booking', [BookingController::class, 'store'])->name('user.booking.store');

    // User Payment Page
    Route::get('/user/payment/{booking}', [BookingController::class, 'showPaymentPage'])->name('user.payment.show');
    
    // User Booking History
    Route::get('/user/riwayat', [BookingController::class, 'index'])->name('riwayat');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
});


// ==========================
// User Actions (Authenticated)
// ==========================
Route::middleware(['auth'])->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Payment Proof Upload & Download
    Route::post('/payments/{payment}/upload', [PaymentController::class, 'uploadProof'])->name('payment.upload');
    Route::get('/payments/{payment}/download', [PaymentController::class, 'downloadProof'])->name('payments.download');
});

// ==========================
// Resource Routes (jika masih diperlukan di luar grup)
// ==========================
// Route::resource('rooms', RoomController::class);
// Route::resource('vouchers', VoucherController::class);


// ==========================
// Auth Routes (Login, Register, etc.)
// ==========================
require __DIR__ . '/auth.php';
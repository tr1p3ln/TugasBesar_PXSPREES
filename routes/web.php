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

// GUEST & PUBLIC ROUTES
Route::get('/', fn () => view('index'))->name('home');
Route::get('/booking/check-availability', [BookingController::class, 'checkAvailability'])->name('booking.checkAvailability');

// AUTHENTICATION & VERIFICATION ROUTES
require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/email/verify', fn () => view('auth.verify-email'))->name('verification.notice');
    
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        // Redirect yang lebih baik, ke dashboard masing-masing
        return $request->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
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
    Route::get('/dashboard', [AdminController::class, 'homepage'])->name('dashboard');
    Route::get('/export-pdf', [AdminController::class, 'exportPDF'])->name('export.pdf');

    // Rooms Management
    Route::resource('rooms', RoomController::class)->except(['show']);
    Route::patch('rooms/{room}/status', [RoomController::class, 'updateStatus'])->name('rooms.updateStatus');

    // Vouchers Management
    Route::resource('vouchers', VoucherController::class);
    
    // Bookings Management
    Route::get('bookings', [BookingController::class, 'view'])->name('bookings.index');
    Route::patch('bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.updateStatus');
    
    // Payments Management
    Route::get('payments/history', [PaymentController::class, 'index'])->name('payments.history');
    Route::get('payments/pending', [AdminPaymentController::class, 'index'])->name('payments.index');
    Route::patch('payments/{payment}/status', [AdminPaymentController::class, 'updateStatus'])->name('payments.updateStatus');
});

// ===========================================
// USER ROUTES
// ===========================================
Route::prefix('user')->name('user.')->middleware(['auth', 'verified', 'is_user'])->group(function () {
    Route::get('/dashboard', fn() => view('user.dashboard'))->name('dashboard');
    Route::get('/vouchers', [VoucherController::class, 'dataVoucher'])->name('vouchers.index');
    
    // Booking Process
    Route::get('/booking', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

    // Payment & History
    Route::get('/payment/{booking}', [BookingController::class, 'showPaymentPage'])->name('payment.show');
    Route::get('/booking-history', [BookingController::class, 'index'])->name('booking.history');
    Route::get('/booking-history/{booking}', [BookingController::class, 'show'])->name('booking.show');
});

// ===========================================
// AUTHENTICATED SHARED ROUTES (Profile, etc.)
// ===========================================
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Payment Actions
    Route::post('/payments/{payment}/upload-proof', [PaymentController::class, 'uploadProof'])->name('payment.uploadProof');
    Route::get('/payments/{payment}/download-proof', [PaymentController::class, 'downloadProof'])->name('payment.downloadProof');
});

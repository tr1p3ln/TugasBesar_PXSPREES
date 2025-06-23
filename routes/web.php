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
Route::get('/', fn() => view('index'))->name('home');
Route::get('/booking/check-availability', [BookingController::class, 'checkAvailability'])->name('booking.checkAvailability');

// AUTHENTICATION & VERIFICATION ROUTES
require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/email/verify', fn() => view('auth.verify-email'))->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
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
    // Dashboard & Export
    Route::get('/dashboard', [AdminController::class, 'homepage'])->name('dashboard');
    Route::get('/export-pdf', [PaymentController::class, 'exportPDF'])->name('exportpdf');

    // Rooms Management
    Route::get('keloladata', [RoomController::class, 'view'])->name('keloladata'); // Route untuk keloladata.blade.php
    Route::get('rooms/create', [RoomController::class, 'create'])->name('rooms.create');
    Route::post('rooms', [RoomController::class, 'store'])->name('rooms.store');
    Route::get('rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
    Route::put('rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
    Route::delete('rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');
    Route::patch('rooms/{room}/status', [RoomController::class, 'updateStatus'])->name('rooms.updateStatus');

    // Vouchers Management
    // Route::get('voucher', [VoucherController::class, 'view'])->name('voucher'); // Route untuk voucher.blade.php
    // Route::get('vouchers/create', [VoucherController::class, 'create'])->name('vouchers.create');
    // Route::post('vouchers', [VoucherController::class, 'store'])->name('vouchers.store');
    // Route::get('vouchers/{voucher}/edit', [VoucherController::class, 'edit'])->name('vouchers.edit');
    // Route::put('vouchers/{voucher}', [VoucherController::class, 'update'])->name('vouchers.update');
    // Route::delete('vouchers/{voucher}', [VoucherController::class, 'destroy'])->name('vouchers.destroy');
    Route::get('/voucher', [VoucherController::class, 'view'])->name('voucher'); // admin.voucher
    Route::get('/vouchers/create', [VoucherController::class, 'create'])->name('voucher.create'); // admin.vouchers.create
    Route::post('/vouchers/create', [VoucherController::class, 'store'])->name('vouchers.store'); // admin.vouchers.store
    Route::get('/vouchers/{id}/edit', [VoucherController::class, 'edit'])->name('vouchers.edit'); // admin.vouchers.edit
    Route::put('/vouchers/{id}', [VoucherController::class, 'update'])->name('vouchers.update'); // admin.vouchers.update
    Route::delete('/vouchers/{id}', [VoucherController::class, 'destroy'])->name('vouchers.destroy'); // admin.vouchers.destroy


    // Bookings Management
    Route::get('booking-data', [BookingController::class, 'view'])->name('bookingdata'); // Route untuk bookingdata.blade.php
    Route::patch('bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.updateStatus');

    // Payments Management
    Route::get('history-data', [AdminPaymentController::class, 'history'])->name('historydata'); // Route untuk historydata.blade.php
    Route::get('pending-payments', [AdminPaymentController::class, 'index'])->name('payments.pending'); // Route untuk pending_payments.blade.php
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

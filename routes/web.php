<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsUser;

// ==========================
// Homepage untuk guest
// ==========================
Route::get('/', function () {
    return view('index');
})->name('home');

// ==========================
// Email Verification Routes
// ==========================

// Menampilkan halaman notifikasi verifikasi email
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Proses verifikasi dari email link
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    // Redirect berdasarkan role setelah verifikasi berhasil
    if ($request->user()->role === 'admin') {
        return redirect()->route('admin.home');
    }

    return redirect()->route('user.home');
})->middleware(['auth', 'signed'])->name('verification.verify');

// Mengirim ulang email verifikasi
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// ==========================
// Routes untuk Admin
// ==========================
Route::middleware(['auth', 'verified', 'is_admin'])->group(function () {
    Route::get('/admin/homepage', function () {
        return view('admin.homepage');
    })->name('admin.home');
});

// ==========================
// Routes untuk User Biasa
// ==========================
Route::middleware(['auth', 'verified', 'is_user'])->group(function () {
    Route::get('/user/homepage', function () {
        return view('user.homepage');
    })->name('user.home');

    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard');

    Route::get('/user/booking', function () {
        return view('user.booking');
    })->name('booking');

    Route::get('/user/merchant', function () {
        return view('user.merchant');
    })->name('merchant');
});





// Group route untuk admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/bookingdata', function () {
        return view('admin.bookingdata');
    })->name('bookingdata');

    Route::get('/historydata', function () {
        return view('admin.historydata');
    })->name('historydata');

    Route::get('/homepage', function () {
        return view('admin.homepage');
    })->name('homepage');

    Route::get('/keloladata', function () {
        return view('admin.keloladata');
    })->name('keloladata');

    Route::get('/voucher', function () {
        return view('admin.voucher');
    })->name('voucher');


    // Route::get('/voucher', function () {
    //     $vouchers = Voucher::all(); // ambil semua data voucher
    //     return view('admin.voucher', compact('vouchers'));
    // })->name('voucher');
    


    Route::get('/vouchercreate', function () {
        return view('admin.vouchercreate');
    })->name('vouchercreate');
});

// Route::prefix('admin')->name('admin.')->group(function () {
//     Route::get('/homepage', fn() => view('admin.homepage'))->name('homepage');
//     Route::get('/keloladata', fn() => view('admin.keloladata'))->name('keloladata');
//     Route::get('/bookingdata', fn() => view('admin.bookingdata'))->name('bookingdata');
//     Route::get('/historydata', fn() => view('admin.historydata'))->name('historydata');
//     Route::get('/voucher', fn() => view('admin.voucher'))->name('voucher');
//     Route::get('/vouchercreate', fn() => view('admin.vouchercreate'))->name('vouchercreate');
// });

// ==========================
// Profile Routes
// ==========================
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==========================
// Auth Routes
// ==========================
require __DIR__ . '/auth.php';

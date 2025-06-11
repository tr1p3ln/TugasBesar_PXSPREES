<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsUser;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;

// Homepage untuk guest
Route::get('/', function () {
    return view('index');
})->name('home');

// Email Verification Routes
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    if ($request->user()->role === 'admin') {
        return redirect()->route('admin.home');
    }
    return redirect()->route('user.home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


// Routes untuk Admin
Route::middleware(['auth', 'verified', 'is_admin'])->group(function () {
    Route::get('/admin/homepage', function () {
        return view('admin.homepage');
    })->name('admin.home');

    Route::get('/bookingdata', function () {
        return view('admin.bookingdata');
    })->name('admin.bookingdata'); // Accessible as route('admin.bookingdata'), URL: /admin/bookingdata

    Route::get('/historydata', function () {
        return view('admin.historydata');
    })->name('admin.historydata'); // Accessible as route('admin.historydata'), URL: /admin/historydata

    Route::get('/homepage', function () {
        return view('admin.homepage');
    })->name('admin.homepage');

    Route::get('/keloladata', function () {
        return view('admin.keloladata');
    })->name('admin.keloladata'); // Accessible as route('admin.keloladata'), URL: /admin/keloladata

    Route::get('/voucher', function () {
        return view('admin.voucher');
    })->name('admin.voucher'); // Accessible as route('admin.voucher'), URL: /admin/voucher

    Route::get('/vouchercreate', function () {
        return view('admin.vouchercreate');
    })->name('admin.vouchercreate'); // Accessible as route('admin.vouchercreate'), URL: /admin/vouchercreate
});


// Routes untuk User Biasa
Route::middleware(['auth', 'verified', 'is_user'])->group(function () {
    Route::get('/user/homepage', function () {
        return view('user.homepage');
    })->name('user.home');

    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard'); // Consider naming 'user.dashboard' for consistency

    // Corrected booking route for users
    // This uses BookingController@create and is named 'booking'
    Route::get('/user/booking', [BookingController::class, 'create'])->name('booking'); 
    // Route untuk menyimpan data booking pengguna
    Route::post('/user/booking', [BookingController::class, 'store'])->name('user.booking.store'); 
    

    Route::get('/user/merchant', function () {
        return view('user.merchant');
    })->name('merchant'); // Consider naming 'user.merchant' for consistency


    // Route ini akan menampilkan halaman pembayaran berdasarkan booking
    Route::get('/user/payment/{booking}', [BookingController::class, 'showPaymentPage'])->name('user.payment.show');
});

// Payment Routes
Route::middleware(['auth'])->group(function () {

     // Booking Payment Routes
    Route::prefix('user')->group(function () {
        // Show payment page for specific booking
        Route::get('payment/{booking}', [BookingController::class, 'showPaymentPage'])
            ->name('user.payment.show');
    });

    Route::get('/payments/{payment}', [PaymentController::class, 'show'])
        ->name('payments.show');
        
    Route::post('/payments/{payment}/upload', [PaymentController::class, 'uploadProof'])
        ->name('payments.upload');
        
    Route::get('/payments/{payment}/download', [PaymentController::class, 'downloadProof'])
        ->name('payments.download');
});





// Profile Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show'); // Assuming {booking} is a route model binding
});

// //Logout Route
// Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');


// Payment
Route::middleware(['auth', 'verified', 'is_admin'])->group(function () {
    // ... route admin lainnya ...
    Route::get('/admin/payments', [AdminPaymentController::class, 'index'])->name('admin.payments.index');
    Route::post('/admin/payments/{payment}/confirm', [AdminPaymentController::class, 'confirm'])->name('admin.payments.confirm');
});



Route::get('/booking/check-availability', [BookingController::class, 'checkAvailability'])->name('booking.checkAvailability');


// Auth Routes (usually at the end)
require __DIR__ . '/auth.php';
<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsUser;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;

// ==========================
// Homepage untuk guest
// ==========================
Route::get('/', function () {
    return view('index');
})->name('home');

// Email Verification Routes
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
        // INI PENTING: Pastikan ini memanggil 'admin.home'
        return redirect()->route('admin.home'); 
    }

    return redirect()->route('user.home');
})->middleware(['auth', 'signed'])->name('verification.verify');

// Mengirim ulang email verifikasi
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


// URL: /admin/*, Nama: admin.*, Middleware: auth, verified, is_admin
// ===========================================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'is_admin'])->group(function () {

    // Admin Homepage
    // URL: /admin/homepage, Nama: admin.home (INI ADALAH ROUTE UTAMA UNTUK HOMEPAGE ADMIN)
    Route::get('/homepage', [AdminController::class, 'homepage'])->name('home'); //

    // Export PDF
    // URL: /admin/exportpdf, Nama: admin.exportpdf
    Route::get('/exportpdf', [AdminController::class, 'exportPDF'])->name('exportpdf'); //

    // ==========================
    // Admin Data (Manajemen Kamar/Ruangan)
    // ==========================
    // Menampilkan semua data kamar
    // URL: /admin/keloladata, Nama: admin.keloladata
    Route::get('/keloladata', [RoomController::class, 'view'])->name('keloladata');
    // Menampilkan form tambah kamar
    // URL: /admin/rooms/create, Nama: admin.rooms.create
    Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
    // Menyimpan data kamar baru (POST)
    // URL: /admin/rooms/create, Nama: admin.rooms.store
    Route::post('/rooms/create', [RoomController::class, 'store'])->name('rooms.store');
    // Menampilkan form edit kamar
    // URL: /admin/rooms/{id}/edit, Nama: admin.rooms.edit
    Route::get('/rooms/{id}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
    // Memperbarui data kamar (PUT/PATCH)
    // URL: /admin/rooms/{id}, Nama: admin.rooms.update
    Route::put('/rooms/{id}', [RoomController::class, 'update'])->name('rooms.update');
    // Menghapus data kamar (DELETE)
    // URL: /admin/rooms/{id}, Nama: admin.rooms.destroy
    Route::delete('/rooms/{id}', [RoomController::class, 'destroy'])->name('rooms.destroy');

    // ==========================
    // Admin Voucher
    // ==========================
    // Menampilkan semua data voucher
    // URL: /admin/voucher, Nama: admin.voucher
    // Route::get('/voucher', [VoucherController::class, 'view'])->name('voucher');
    // // Menampilkan form tambah voucher
    // // URL: /admin/vouchers/create, Nama: admin.vouchers.create
    // Route::get('/vouchers/create', [VoucherController::class, 'create'])->name('vouchers.create');
    // // Menyimpan data voucher baru (POST)
    // // URL: /admin/vouchers/create, Nama: admin.vouchers.store
    // Route::post('/vouchers/create', [VoucherController::class, 'store'])->name('vouchers.store');
    // // Menampilkan form edit voucher
    // // URL: /admin/vouchers/{id}/edit, Nama: admin.vouchers.edit
    // Route::get('/vouchers/{id}/edit', [VoucherController::class, 'edit'])->name('vouchers.edit');
    // // Memperbarui data voucher (PUT/PATCH)
    // // URL: /admin/vouchers/{id}, Nama: admin.vouchers.update
    // Route::put('/vouchers/{id}', [VoucherController::class, 'update'])->name('vouchers.update');
    // // Menghapus data voucher (DELETE)
    // // URL: /admin/vouchers/{id}, Nama: admin.vouchers.destroy
    // Route::delete('/vouchers/{id}', [VoucherController::class, 'destroy'])->name('vouchers.destroy');

    // ==========================
    // Admin Booking Data
    // ==========================
    // Menampilkan data booking (ini dari BookingController::view, bukan AdminController::bookingData)
    // URL: /admin/bookingdata, Nama: admin.bookingdata
    Route::get('/bookingdata', [BookingController::class, 'view'])->name('bookingdata');

    // ==========================
    // Admin Payment (History Data)
    // ==========================
    // Menampilkan data riwayat pembayaran (ini dari PaymentController::view, bukan AdminController::historydata)
    // URL: /admin/historydata, Nama: admin.historydata
    Route::get('/historydata', [PaymentController::class, 'view'])->name('historydata'); //

    // Jika Anda memiliki route admin.payments.show (seperti yang terlihat di ProofUploaded.php)
    // Anda perlu menambahkannya di sini.
    // Contoh:
    Route::get('/payments/{payment}/show', [App\Http\Controllers\Admin\PaymentController::class, 'show'])->name('payments.show'); //
    Route::post('/payments/{payment}/confirm', [App\Http\Controllers\Admin\PaymentController::class, 'confirm'])->name('payments.confirm'); //
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
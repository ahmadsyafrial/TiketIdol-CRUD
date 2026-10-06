<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConcertController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\ConcertController as AdminConcertController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

/*
|--------------------------------------------------------------------------
| Public Concert & Booking Routes
|--------------------------------------------------------------------------
*/

// Homepage & Concert Catalog
Route::get('/', [ConcertController::class, 'index'])->name('home');
Route::get('/concerts/{slug}', [ConcertController::class, 'show'])->name('concerts.show');

// Booking & Checkout Flow (tiket.com style)
Route::get('/checkout/{categoryId}', [BookingController::class, 'checkout'])->name('booking.checkout');
Route::post('/checkout', [BookingController::class, 'processCheckout'])->name('booking.process');
Route::post('/api/check-promo', [BookingController::class, 'checkPromo'])->name('booking.checkPromo');

// Payment Simulation & Order/E-Ticket
Route::get('/orders/{orderCode}/payment', [BookingController::class, 'payment'])->name('booking.payment');
Route::post('/orders/{orderCode}/pay', [BookingController::class, 'confirmPayment'])->name('booking.confirmPayment');
Route::get('/orders/{orderCode}', [BookingController::class, 'showOrder'])->name('booking.order');

// Cek Pesanan / My Booking
Route::get('/cek-pesanan', [BookingController::class, 'checkBooking'])->name('booking.check');

/*
|--------------------------------------------------------------------------
| Admin Management Routes (CRUD)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.concerts.index');
    })->name('dashboard');

    // Concert CRUD
    Route::resource('concerts', AdminConcertController::class);

    // Ticket Category Management under Concert
    Route::post('concerts/{concertId}/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::put('categories/{id}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{id}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

    // Orders Management
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
});

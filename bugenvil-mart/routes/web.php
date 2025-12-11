<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OngkirController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminVideoController;

/*
|--------------------------------------------------------------------------
| 1. HALAMAN PUBLIK
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produk', [PageController::class, 'products'])->name('products.index');
Route::get('/produk/{id}/detail', [PageController::class, 'detail'])->name('products.show');
Route::get('/tutorial', [PageController::class, 'tutorials'])->name('tutorials.all');
Route::get('/kontak', [PageController::class, 'contact'])->name('contact');

// Keranjang Belanja
Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.index');
Route::match(['get', 'post'], '/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::delete('/remove-from-cart', [CartController::class, 'remove'])->name('cart.remove');

/*
|--------------------------------------------------------------------------
| 2. HALAMAN USER (Wajib Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard & Profile
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user->is_admin) return redirect()->route('admin.dashboard');
        $myOrders = \App\Models\Order::where('user_id', $user->id)->latest()->limit(5)->get();
        return view('dashboard', compact('myOrders'));
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Checkout & Transaksi
    Route::get('/checkout', [OrderController::class, 'index'])->name('checkout');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');

    // --- API RAJAONGKIR (Sesuai SantriKoding) ---
    Route::get('/api/provinces', [OngkirController::class, 'getProvinces'])->name('api.provinces');
    Route::get('/api/cities/{id}', [OngkirController::class, 'getCities'])->name('api.cities');
    Route::get('/api/districts/{id}', [OngkirController::class, 'getDistricts'])->name('api.districts'); // Kecamatan
    Route::post('/api/cost', [OngkirController::class, 'checkOngkir'])->name('api.cost');

    // Fitur Lain
    Route::get('/lapor-kerusakan', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/lapor-kerusakan', [ReportController::class, 'store'])->name('reports.store');
    Route::post('/produk/{id}/review', [ReviewController::class, 'store'])->name('reviews.store');
});

/*
|--------------------------------------------------------------------------
| 3. HALAMAN ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductController::class);
    Route::resource('videos', AdminVideoController::class);
    Route::get('/laporan', [ReportController::class, 'indexAdmin'])->name('reports.index');
    Route::patch('/laporan/{id}', [ReportController::class, 'updateStatus'])->name('reports.update');
    Route::patch('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.update');
});

require __DIR__ . '/auth.php';
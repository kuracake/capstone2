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
use App\Http\Controllers\AdminOrderController; // Tambahkan ini
use App\Http\Controllers\PaymentCallbackController;

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

/*
|--------------------------------------------------------------------------
| 2. HALAMAN USER (Wajib Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    
    // --- KERANJANG BELANJA (CART) ---
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add'); 
    Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');    
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy'); 

    // --- DASHBOARD USER ---
    Route::get('/dashboard', function () {
        $user = Auth::user();
        // Redirect Admin ke Dashboard Admin jika salah masuk
        if ($user->is_admin) return redirect()->route('admin.dashboard');
        
        $myOrders = \App\Models\Order::with('report') 
                        ->where('user_id', $user->id)
                        ->latest()
                        ->limit(10)
                        ->get();
                        
        return view('dashboard', compact('myOrders'));
    })->name('dashboard');

    // --- Notifikasi ---
    Route::get('/user/notification/{id}/read', [ProfileController::class, 'markNotification'])->name('user.notification.read');

    // --- PROFILE ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // TAMBAHAN: Route Manajemen Alamat
    Route::patch('/profile/address/{id}', [ProfileController::class, 'updateAddress'])->name('profile.address.update');
    Route::delete('/profile/address/{id}', [ProfileController::class, 'destroyAddress'])->name('profile.address.destroy');

    // --- CHECKOUT & TRANSAKSI ---
    Route::get('/checkout', [OrderController::class, 'index'])->name('checkout.index'); 
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');

    // --- API RAJAONGKIR ---
    Route::get('/api/provinces', [OngkirController::class, 'getProvinces'])->name('api.provinces');
    Route::get('/api/cities/{id}', [OngkirController::class, 'getCities'])->name('api.cities');
    Route::get('/api/districts/{id}', [OngkirController::class, 'getDistricts'])->name('api.districts');
    Route::post('/api/cost', [OngkirController::class, 'checkOngkir'])->name('api.cost');

    // --- FITUR LAIN ---
    Route::get('/orders/{order}/lapor', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/orders/{order}/lapor', [ReportController::class, 'store'])->name('reports.store');
    Route::post('/produk/{id}/review', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/checkout/success', [OrderController::class, 'success'])->name('checkout.success');
});

/*
|--------------------------------------------------------------------------
| 3. HALAMAN ADMIN
|--------------------------------------------------------------------------
*/
Route::post('payments/midtrans-notification', [PaymentCallbackController::class, 'receive']);

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Route Notifikasi
    Route::get('/notification/{id}/mark-as-read', [AdminController::class, 'markNotification'])->name('notification.read');
    
    // Manajemen Produk & Video
    Route::resource('products', AdminProductController::class);
    Route::delete('/product-image/{id}/delete', [AdminProductController::class, 'deleteImage'])->name('product.image.delete');
    Route::resource('videos', AdminVideoController::class);

    // Laporan & Cetak
    Route::get('/laporan', [ReportController::class, 'indexAdmin'])->name('reports.index');
    Route::patch('/laporan/{id}', [ReportController::class, 'updateStatus'])->name('reports.update');
    Route::get('/report/print', [AdminController::class, 'printReport'])->name('report.print');

    // Manajemen Order (PERBAIKAN UTAMA DI SINI)
    // Menggunakan AdminOrderController agar fitur Resi berfungsi
    Route::patch('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update');
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show']);
});

require __DIR__ . '/auth.php';
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// --- CONTROLLERS ---
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OngkirController;
use App\Http\Controllers\ReportController;

// --- ADMIN CONTROLLERS ---
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminVideoController; // Pastikan file ini ada

/*
|--------------------------------------------------------------------------
| 1. HALAMAN PUBLIK (Bisa Diakses Tanpa Login)
|--------------------------------------------------------------------------
*/

// Beranda & Halaman Utama
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

    // Dashboard User
    // (Jika Admin mengakses ini, kita lempar ke Admin Dashboard)
    Route::get('/dashboard', function () {
        if (Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard');
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Transaksi & Checkout
    Route::get('/checkout', [OrderController::class, 'index'])->name('checkout');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');

    // API Ongkir
    Route::get('/api/provinces', [OngkirController::class, 'getProvinces']);
    Route::get('/api/cities/{province_id}', [OngkirController::class, 'getCities']);
    Route::get('/api/districts', [OngkirController::class, 'getDistricts']);
    Route::get('/api/subdistricts', [OngkirController::class, 'getSubdistricts']);
    Route::post('/api/cost', [OngkirController::class, 'checkOngkir']);

    // Laporan Kerusakan
    Route::get('/lapor-kerusakan', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/lapor-kerusakan', [ReportController::class, 'store'])->name('reports.store');
});


/*
|--------------------------------------------------------------------------
| 3. HALAMAN ADMIN (Khusus Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])
    ->prefix('admin')        // URL diawali /admin
    ->name('admin.')         // Nama route diawali admin.
    ->group(function () {

        // Dashboard Admin
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        // CRUD Produk (Menggunakan AdminProductController)
        // Otomatis membuat: admin.products.index, create, store, dll
        Route::resource('products', AdminProductController::class);

        // CRUD Video Tutorial (Menggunakan AdminVideoController)
        // Pastikan Controller ini memiliki method: index, create, store, edit, update, destroy
        Route::resource('videos', AdminVideoController::class)->names([
            'index' => 'videos.index',
            'create' => 'videos.create',
            'store' => 'videos.store',
            'edit' => 'videos.edit',
            'update' => 'videos.update',
            'destroy' => 'videos.destroy',
        ]);

        // Laporan & Order
        Route::get('/laporan', [ReportController::class, 'indexAdmin'])->name('reports.index');
        Route::patch('/laporan/{id}', [ReportController::class, 'updateStatus'])->name('reports.update');
        Route::patch('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.update');

    });

require __DIR__ . '/auth.php';

Route::get('/debug-rajaongkir', function () {
    $apiKey = env('RAJAONGKIR_API_KEY');
    if (!$apiKey) dd("FATAL ERROR: API Key tidak terbaca.");

    try {
        $response = Illuminate\Support\Facades\Http::withoutVerifying()
            ->withHeaders(['key' => $apiKey, 'Accept' => 'application/json'])
            ->get('https://rajaongkir.komerce.id/api/v1/destination/province');

        dd([
            'STATUS' => $response->status(),
            'PESAN' => $response->json()['meta']['message'] ?? '-',
            'DATA' => $response->json()['data'][0] ?? 'Kosong',
        ]);
    } catch (\Exception $e) {
        dd("ERROR: " . $e->getMessage());
    }
});
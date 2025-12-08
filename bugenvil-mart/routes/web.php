<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// --- IMPORT CONTROLLER ---
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OngkirController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminVideoController;

/*
|--------------------------------------------------------------------------
| 1. HALAMAN PUBLIK
|--------------------------------------------------------------------------
*/

// Beranda
Route::get('/', [HomeController::class, 'index'])->name('home');

// Halaman Produk (Katalog)
// PERBAIKAN: Ubah ke 'products.index' agar cocok dengan Navbar & Layout
Route::get('/produk', [PageController::class, 'products'])->name('products.index');

// Detail Produk
// PERBAIKAN: Ubah ke 'products.show' agar cocok dengan Card Produk
Route::get('/produk/{id}/detail', [PageController::class, 'detail'])->name('products.show');

// Halaman Statis Lain
Route::get('/tutorial', [PageController::class, 'tutorials'])->name('tutorials.all');
Route::get('/kontak', [PageController::class, 'contact'])->name('contact');

// Keranjang Belanja (Cart)
// PERBAIKAN: Ubah ke 'cart.index' (Penyebab Error Utama Anda)
Route::get('cart', [CartController::class, 'viewCart'])->name('cart.index');

// Tambah ke Keranjang
// Gunakan POST jika form, GET jika link biasa. (Disarankan POST untuk aksi ubah data)
Route::match(['get', 'post'], 'add-to-cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::delete('remove-from-cart', [CartController::class, 'remove'])->name('cart.remove');


/*
|--------------------------------------------------------------------------
| 2. HALAMAN LOGIN (User & Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // --- A. DASHBOARD ---
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user->is_admin) {
            $totalProducts = \App\Models\Product::count();
            $totalReports = \App\Models\Report::where('status', 'pending')->count();
            $recentReports = \App\Models\Report::with('user')->latest()->take(5)->get();
            return view('admin.dashboard', compact('totalProducts', 'totalReports', 'recentReports'));
        } else {
            return view('dashboard');
        }
    })->name('dashboard');

    // --- B. PROFIL ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- C. CHECKOUT ---
    Route::get('/checkout', [OrderController::class, 'index'])->name('checkout');
    // TETAP: 'checkout.store' (Sesuai permintaan form Checkout RajaOngkir Bapak)
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');

    // --- D. API ONGKIR (RajaOngkir) ---
    Route::get('/api/provinces', [OngkirController::class, 'getProvinces']);
    Route::get('/api/cities/{province_id}', [OngkirController::class, 'getCities']);
    Route::get('/api/districts', [OngkirController::class, 'getDistricts']);
    Route::get('/api/subdistricts', [OngkirController::class, 'getSubdistricts']);
    Route::post('/api/cost', [OngkirController::class, 'checkOngkir']);

    // --- E. LAPORAN ---
    Route::get('/lapor-kerusakan', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/lapor-kerusakan', [ReportController::class, 'store'])->name('reports.store');

    /*
    |--------------------------------------------------------------------------
    | 3. ADMIN ROUTES
    |--------------------------------------------------------------------------
    */
    // Resource Admin Produk (Gunakan names agar tidak bentrok dengan user)
    Route::resource('admin/products', AdminProductController::class)->names('admin.products');

    Route::get('/admin/videos', [AdminVideoController::class, 'index'])->name('admin.videos.index');
    Route::put('/admin/videos/{id}', [AdminVideoController::class, 'update'])->name('admin.videos.update');

    Route::get('/admin/laporan', [ReportController::class, 'indexAdmin'])->name('admin.reports');
    Route::patch('/laporan/{id}', [ReportController::class, 'updateStatus'])->name('admin.reports.update');

    Route::patch('/admin/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.update');

});

require __DIR__.'/auth.php';

// Debug Route (Tes RajaOngkir)
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
        ]);
    } catch (\Exception $e) {
        dd("ERROR: " . $e->getMessage());
    }
});
<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminProductController; // Kita akan buat ini
use App\Http\Controllers\AdminVideoController;   // Kita akan buat ini
use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\Report;
use App\Models\User;

// --- HALAMAN PUBLIK (CUSTOMER) ---
Route::get('/', [HomeController::class, 'index'])->name('home');

use App\Http\Controllers\CartController;

use App\Http\Controllers\OrderController; // Pastikan baris ini ada di paling atas file

use App\Http\Controllers\OngkirController;

// ... (Di luar group middleware atau di dalam auth, terserah. Aman di dalam auth)

Route::middleware(['auth'])->group(function () {
    // API LOKAL UNTUK RAJAONGKIR
    Route::get('/api/provinces', [OngkirController::class, 'getProvinces']);
    Route::get('/api/cities/{province_id}', [OngkirController::class, 'getCities']);
    Route::post('/api/cost', [OngkirController::class, 'checkOngkir']);
    
    // ... route checkout dll tetap ada ...
});

// GANTI ROUTE CHECKOUT DENGAN INI:
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [OrderController::class, 'index'])->name('checkout');     // Halaman Form
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store'); // Proses Simpan
});

use App\Http\Controllers\PageController;

// ... route home yang sudah ada ...


Route::middleware(['auth'])->group(function () {
    // API LOKAL RAJAONGKIR
    Route::get('/api/provinces', [OngkirController::class, 'getProvinces']);
    Route::get('/api/cities/{province_id}', [OngkirController::class, 'getCities']);
    Route::post('/api/cost', [OngkirController::class, 'checkOngkir']);
    
    // Route checkout lama tetap ada...
});

// HALAMAN PUBLIK (Navigasi Header)
Route::get('/produk', [PageController::class, 'products'])->name('products.all');
Route::get('/tutorial', [PageController::class, 'tutorials'])->name('tutorials.all');
Route::get('/kontak', [PageController::class, 'contact'])->name('contact');
Route::get('/produk/{id}/detail', [PageController::class, 'detail'])->name('product.detail');

// CHECKOUT SYSTEM (Ganti route checkout lama dengan yang ini)
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [OrderController::class, 'index'])->name('checkout');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store'); // Action POST
});

// --- CART SYSTEM (Bisa diakses Guest/Pengunjung) ---
Route::get('cart', [CartController::class, 'viewCart'])->name('cart.view');
Route::get('add-to-cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::delete('remove-from-cart', [CartController::class, 'remove'])->name('cart.remove');


// --- LOGIKA DASHBOARD PINTAR ---
Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->is_admin) {
        // --- JIKA ADMIN: Tampilkan Dashboard Admin (Data Penjualan dll) ---
        
        // Ambil data statistik untuk admin
        $totalProducts = \App\Models\Product::count();
        $totalReports = \App\Models\Report::where('status', 'pending')->count();
        $recentReports = \App\Models\Report::with('user')->latest()->take(5)->get();

        // Arahkan ke view admin yang sudah kita pindahkan tadi
        return view('admin.dashboard', compact('totalProducts', 'totalReports', 'recentReports'));
    } else {
        // --- JIKA USER BIASA: Tampilkan Dashboard User (Riwayat Pesanan dll) ---
        return view('dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// --- FITUR ADMIN & USER LOGIN ---
Route::middleware('auth')->group(function () {
    // 1. Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// Route untuk Update Status Laporan
    Route::patch('/laporan/{id}', [App\Http\Controllers\ReportController::class, 'updateStatus'])->name('admin.reports.update');


    // 2. Laporan Komplain (Customer)
    Route::get('/lapor-kerusakan', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/lapor-kerusakan', [ReportController::class, 'store'])->name('reports.store');
    
    // 3. Admin: Manajemen Laporan
    Route::get('/admin/laporan', [ReportController::class, 'indexAdmin'])->name('admin.reports');

    // 4. Admin: Manajemen Produk (CRUD)
    Route::resource('admin/products', AdminProductController::class);
    
// Route Update Status Order (Bertahap)
    Route::patch('/admin/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.update');
    
// Route untuk Admin update video tutorial
Route::put('/admin/videos/{id}', [App\Http\Controllers\AdminVideoController::class, 'update'])->name('admin.videos.update');

    // 5. Admin: Manajemen Video
    Route::get('/admin/videos', [AdminVideoController::class, 'index'])->name('admin.videos.index');
    Route::put('/admin/videos/{id}', [AdminVideoController::class, 'update'])->name('admin.videos.update');
});

require __DIR__.'/auth.php';
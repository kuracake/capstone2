<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Pastikan Model ini ada
use App\Models\Order;   // <--- TAMBAHKAN INI
use App\Models\User;    // <--- TAMBAHKAN INI

class AdminController extends Controller
{
    public function index()
    {
        // 1. Hitung Statistik Ringkas
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', '!=', 'pending')->where('status', '!=', 'cancelled')->sum('total_price');
        $totalUsers = User::where('is_admin', false)->count();

        // 2. Ambil 10 Transaksi Terbaru (Supaya Admin bisa pantau)
        // Kita pakai 'with' user agar nama pembeli muncul
        $latestOrders = Order::with('user')->latest()->limit(10)->get();

        // 3. Kirim semua data ke View
        return view('admin.dashboard', compact(
            'totalProducts', 
            'totalOrders', 
            'totalRevenue', 
            'totalUsers',
            'latestOrders' // <--- PENTING
        ));
    }
}
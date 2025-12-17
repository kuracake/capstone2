<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Report;

class AdminController extends Controller
{
    public function index()
    {
        // Menghitung Statistik untuk Dashboard
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_price'); // Hanya hitung yang selesai
        $pendingReports = Report::where('status', 'pending')->count();

        // Ambil 5 pesanan terbaru
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProducts', 
            'totalOrders', 
            'totalRevenue', 
            'pendingReports',
            'recentOrders'
        ));
    }
}
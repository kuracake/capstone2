<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function index()
    {
        // 1. Tentukan Status Order yang Dianggap "Berhasil" (Masuk Penjualan)
        // Kita abaikan 'pending' (belum bayar) dan 'cancelled' (batal)
        $validStatuses = ['paid', 'shipped', 'success', 'completed'];

        // 2. Fungsi Helper untuk Rekap Data
        $getRecap = function ($startDate, $endDate) use ($validStatuses) {
            $orders = Order::whereIn('status', $validStatuses)
                ->whereBetween('created_at', [$startDate, $endDate]);

            return [
                'revenue' => $orders->sum('total_price'), // Total Omzet
                'count' => $orders->count(),              // Jumlah Transaksi
                // Menghitung total item terjual via relasi
                'items_sold' => OrderItem::whereHas('order', function ($q) use ($validStatuses, $startDate, $endDate) {
                    $q->whereIn('status', $validStatuses)
                      ->whereBetween('created_at', [$startDate, $endDate]);
                })->sum('quantity'),
            ];
        };

        // 3. Ambil Data Berdasarkan Waktu
        $now = Carbon::now();
        
        $today = $getRecap($now->copy()->startOfDay(), $now->copy()->endOfDay());
        $week = $getRecap($now->copy()->startOfWeek(), $now->copy()->endOfWeek());
        $month = $getRecap($now->copy()->startOfMonth(), $now->copy()->endOfMonth());
        $year = $getRecap($now->copy()->startOfYear(), $now->copy()->endOfYear());

        // 4. Statistik Tambahan
        
        // Produk Stok Menipis (Kurang dari 5)
        $lowStockProducts = Product::where('stock', '<=', 5)->orderBy('stock', 'asc')->limit(5)->get();

        // Produk Terlaris (Top 5)
        $bestSellers = Product::select('products.name', 'products.stock', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->whereIn('orders.status', $validStatuses)
            ->groupBy('products.id', 'products.name', 'products.stock')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // Data Grafik Penjualan Bulanan (Tahun Ini)
        $monthlySales = Order::select(
                DB::raw('MONTH(created_at) as month'), 
                DB::raw('SUM(total_price) as total')
            )
            ->whereIn('status', $validStatuses)
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Format data grafik agar array index 1-12 selalu ada (walau 0)
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $monthlySales[$i] ?? 0;
        }

        return view('admin.dashboard', compact(
            'today', 'week', 'month', 'year', 
            'lowStockProducts', 'bestSellers', 'chartData'
        ));
    }

    public function printReport(Request $request)
    {
        $period = $request->query('period', 'today'); // Default hari ini
        $now = Carbon::now();
        $startDate = $now->copy()->startOfDay();
        $endDate = $now->copy()->endOfDay();
        $label = 'Hari Ini (' . $now->translatedFormat('d F Y') . ')';

        // 1. Logika Filter Periode
        switch ($period) {
            case 'week':
                $startDate = $now->copy()->startOfWeek();
                $endDate = $now->copy()->endOfWeek();
                $label = 'Minggu Ini (' . $startDate->translatedFormat('d M') . ' - ' . $endDate->translatedFormat('d M Y') . ')';
                break;
            case 'month':
                $startDate = $now->copy()->startOfMonth();
                $endDate = $now->copy()->endOfMonth();
                $label = 'Bulan ' . $now->translatedFormat('F Y');
                break;
            case 'year':
                $startDate = $now->copy()->startOfYear();
                $endDate = $now->copy()->endOfYear();
                $label = 'Tahun ' . $now->translatedFormat('Y');
                break;
        }

        // 2. Ambil Data Order Sesuai Periode
        // Hanya ambil yang statusnya sukses (paid/shipped/success)
        $orders = Order::with('user')
            ->whereIn('status', ['paid', 'shipped', 'success', 'completed'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->get();

        // 3. Hitung Total
        $totalRevenue = $orders->sum('total_price');

        // 4. Generate PDF
        $pdf = Pdf::loadView('admin.reports.pdf', compact('orders', 'label', 'period', 'totalRevenue'));
        
        // 5. Download / Stream
        return $pdf->stream('Laporan-Penjualan-' . ucfirst($period) . '.pdf');
    }


}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\VideoTutorial;

class PageController extends Controller
{
    // Halaman Semua Produk (Katalog)
    public function products(Request $request)
    {
        // PERBAIKAN: Tambahkan withSum untuk menghitung 'Terjual' otomatis
        $query = Product::withAvg('reviews', 'rating')
                        ->withCount('reviews')
                        ->withSum('orderItems', 'quantity'); // Menghitung total qty terjual

        // 1. Logika Pencarian
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 2. Logika Filter / Urutan
        if ($request->filled('filter')) {
            switch ($request->filter) {
                case 'terbaru':
                    $query->latest();
                    break;
                case 'terlaris':
                    // Sekarang kita bisa urutkan berdasarkan jumlah terjual beneran!
                    $query->orderBy('order_items_sum_quantity', 'desc'); 
                    break;
                case 'termurah':
                    $query->orderBy('price', 'asc');
                    break;
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        // 3. Pagination 12 item per halaman
        $products = $query->paginate(12)->withQueryString();

        return view('pages.products', compact('products'));
    }

    // Halaman Detail Produk
   public function detail($id)
    {
        // Tambahkan withSum juga di sini
        $product = Product::with(['reviews.user'])
                        ->withAvg('reviews', 'rating')
                        ->withCount('reviews')
                        ->withSum('orderItems', 'quantity')
                        ->findOrFail($id);
        
        $relatedProducts = Product::where('id', '!=', $id)
                                ->withAvg('reviews', 'rating')
                                ->withCount('reviews')
                                ->withSum('orderItems', 'quantity')
                                ->inRandomOrder()
                                ->take(4)
                                ->get();

        return view('pages.detail', compact('product', 'relatedProducts'));
    }

    // Halaman Tutorial
    public function tutorials()
    {
        $videos = VideoTutorial::latest()->paginate(9); 
        return view('pages.tutorials', compact('videos'));
    }

    // Halaman Kontak
    public function contact()
    {
        return view('pages.contact');
    }
}
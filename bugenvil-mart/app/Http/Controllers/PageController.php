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
        $query = Product::query();

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
                    // Karena belum ada kolom 'sold', kita simulasikan dengan harga tertinggi dulu
                    $query->orderBy('price', 'desc'); 
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
        // Ambil produk beserta relasi reviews dan usernya (Eager Loading biar cepat)
        // withAvg menghitung rata-rata kolom 'rating' di relasi 'reviews' otomatis
        // withCount menghitung jumlah review
        $product = Product::with(['reviews.user'])
                    ->withAvg('reviews', 'rating')
                    ->withCount('reviews')
                    ->findOrFail($id);
        
        $relatedProducts = Product::where('id', '!=', $id)->inRandomOrder()->take(4)->get();

        return view('pages.detail', compact('product', 'relatedProducts'));
    }

    // Halaman Tutorial
    public function tutorials()
    {
        $videos = VideoTutorial::latest()->get();
        return view('pages.tutorials', compact('videos'));
    }

    // Halaman Kontak
    public function contact()
    {
        return view('pages.contact');
    }
}
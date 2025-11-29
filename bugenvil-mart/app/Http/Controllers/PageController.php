<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\VideoTutorial;

class PageController extends Controller
{
// Halaman Semua Produk dengan Filter
    public function products(Request $request)
    {
        $query = Product::query();

        // 1. Logika Pencarian (Search)
        if($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 2. Logika Filter (Sortir)
        if($request->has('filter')) {
            switch($request->filter) {
                case 'terbaru':
                    $query->latest(); // Urutkan dari yang paling baru dibuat
                    break;
                case 'terlaris':
                    $query->orderBy('price', 'desc'); // Simulasi: Anggap harga mahal = laris/premium
                    break;
                case 'terpopuler':
                    $query->inRandomOrder(); // Simulasi: Acak agar terlihat berubah
                    break;
                default:
                    // 'semua' atau default tidak melakukan apa-apa (urutan ID standar)
                    break;
            }
        }

        $products = $query->get();
        return view('pages.products', compact('products'));
    }

    // Halaman Semua Tutorial
    public function tutorials()
    {
        $videos = VideoTutorial::all();
        return view('pages.tutorials', compact('videos'));
    }

    // Halaman Kontak
    public function contact()
    {
        return view('pages.contact');
    }

// ... fungsi lainnya ...

    // Halaman Detail Produk (Single)
    public function detail($id)
    {
        $product = Product::findOrFail($id);
        
        // Ambil produk lain untuk rekomendasi "Produk Serupa"
        $relatedProducts = Product::where('id', '!=', $id)->inRandomOrder()->take(4)->get();

        return view('pages.detail', compact('product', 'relatedProducts'));
    }

}
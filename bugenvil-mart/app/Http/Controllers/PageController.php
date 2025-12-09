<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\VideoTutorial;

class PageController extends Controller
{
    // Halaman Semua Produk dengan Filter dan Pencarian
    public function products(Request $request)
    {
        // 1. Inisialisasi Query Builder
        $query = Product::query();

        // 2. Logika Pencarian (Search)
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 3. Logika Filter (Sortir)
        if ($request->filled('filter')) {
            switch ($request->filter) {
                case 'terbaru':
                    $query->latest(); // Urutkan dari yang paling baru
                    break;
                case 'terlaris':
                    $query->orderBy('price', 'desc'); // Simulasi: Harga tertinggi
                    break;
                case 'terpopuler':
                    $query->inRandomOrder(); // Acak
                    break;
                default:
                    $query->latest(); 
                    break;
            }
        } else {
            // Default jika tidak ada filter: Tampilkan yang terbaru
            $query->latest();
        }

        // 4. Eksekusi Query (Gunakan paginate agar rapi, maksimal 12 produk per halaman)
        $products = $query->paginate(12);
        
        // Agar parameter pencarian tidak hilang saat pindah halaman (pagination)
        $products->appends($request->all());

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

    // Halaman Detail Produk (Single)
    public function detail($id)
    {
        $product = Product::findOrFail($id);
        
        // Ambil produk lain untuk rekomendasi "Produk Serupa"
        // Mengambil 4 produk acak selain produk yang sedang dilihat
        $relatedProducts = Product::where('id', '!=', $id)->inRandomOrder()->take(4)->get();

        return view('pages.detail', compact('product', 'relatedProducts'));
    }
}
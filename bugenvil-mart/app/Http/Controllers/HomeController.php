<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\VideoTutorial;

class HomeController extends Controller {
    public function index() {
        // PERBAIKAN: Tambahkan withSum, withAvg, dan withCount
        // Agar data terjual & rating tersedia di Halaman Beranda
        $products = Product::withSum('orderItems', 'quantity') // Hitung total terjual
                           ->withAvg('reviews', 'rating')      // Hitung rata-rata bintang
                           ->withCount('reviews')              // Hitung jumlah ulasan
                           ->take(8) // Tampilkan 8 produk (bukan 4, agar grid lebih penuh)
                           ->get();

        $videos = VideoTutorial::take(4)->get();
        
        return view('welcome', compact('products', 'videos'));
    }
}
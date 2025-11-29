<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\VideoTutorial;

class HomeController extends Controller {
    public function index() {
        // Ambil semua produk dan video untuk ditampilkan di Homepage
        $products = Product::all();
        $videos = VideoTutorial::take(3)->get();
        return view('welcome', compact('products', 'videos'));
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // 1. Tambah ke Keranjang (Tanpa Login)
    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        // Jika produk sudah ada di cart, tambah jumlahnya
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            // Jika belum ada, masukkan data baru
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image_path
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Produk masuk keranjang!');
    }

    // 2. Lihat Halaman Keranjang
    public function viewCart()
    {
        return view('cart.index');
    }

    // 3. Hapus Item dari Keranjang
    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Produk dihapus dari keranjang');
        }
    }
}
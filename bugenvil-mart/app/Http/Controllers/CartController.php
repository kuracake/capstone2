<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // 1. Tambah ke Keranjang (Versi Database)
    public function addToCart(Request $request, $id)
{
    // 1. Validasi User Login (Wajib Login untuk masuk Database)
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Silakan login untuk belanja.');
    }

    $product = Product::findOrFail($id);
    $user_id = Auth::id();

    // 2. Validasi Stok
    if ($product->stock < 1) {
        return back()->with('error', 'Maaf, stok produk habis.');
    }

    // 3. Cek apakah barang sudah ada di keranjang user ini?
    $existingCart = CartItem::where('user_id', $user_id)
                            ->where('product_id', $product->id)
                            ->first();

    if ($existingCart) {
        // Jika ada, update quantity saja (Stok tidak boleh minus)
        if (($existingCart->quantity + 1) > $product->stock) {
            return back()->with('error', 'Stok tidak mencukupi untuk penambahan.');
        }
        
        $existingCart->increment('quantity');
        
        // Update harga terbaru jika harga produk berubah
        $existingCart->update(['price' => $product->price]); 
        
    } else {
        // 4. Jika belum ada, BUAT BARU dengan HARGA YANG BENAR
        // PENTING: Kita ambil 'price' dari $product->price
        CartItem::create([
            'user_id'    => $user_id,
            'product_id' => $product->id,
            'quantity'   => 1, // Default 1
            'price'      => $product->price // <--- INI KUNCI AGAR HARGA TIDAK 0
        ]);
    }

    return redirect()->route('cart.index')->with('success', 'Produk berhasil masuk keranjang!');
}

    // 2. Lihat Keranjang
    public function viewCart()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Ambil data cart milik user yang sedang login beserta data produknya
        $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();
        
        // Hitung Total (Subtotal semua item)
        $grandTotal = 0;
        foreach($cartItems as $item) {
            $grandTotal += $item->product->price * $item->quantity;
        }

        return view('cart.index', compact('cartItems', 'grandTotal'));
    }

    // 3. Hapus Item
    public function remove(Request $request)
    {
        if (!Auth::check()) return redirect()->route('login');

        if($request->id) {
            // Hapus berdasarkan ID CartItem, dan pastikan milik user yg login
            CartItem::where('id', $request->id)
                    ->where('user_id', Auth::id())
                    ->delete();
            
            return redirect()->back()->with('success', 'Produk dihapus dari keranjang');
        }
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // 1. Tambah ke Keranjang
    public function addToCart(Request $request, $id)
    {
        // A. Validasi User Login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk belanja.');
        }

        $product = Product::findOrFail($id);
        $user_id = Auth::id();

        // B. Validasi Stok
        if ($product->stock < 1) {
            return back()->with('error', 'Maaf, stok produk habis.');
        }

        // C. Cek apakah barang sudah ada di keranjang?
        $existingCart = CartItem::where('user_id', $user_id)
                                ->where('product_id', $product->id)
                                ->first();

        if ($existingCart) {
            // Update quantity (Cek stok dulu)
            if (($existingCart->quantity + 1) > $product->stock) {
                return back()->with('error', 'Stok tidak mencukupi untuk penambahan.');
            }
            
            $existingCart->increment('quantity');
            $existingCart->update(['price' => $product->price]); // Update harga terbaru
            
        } else {
            // Buat Item Baru
            CartItem::create([
                'user_id'    => $user_id,
                'product_id' => $product->id,
                'quantity'   => 1,
                'price'      => $product->price
            ]);
        }

        // --- BAGIAN INI YANG KITA UBAH ---
        
        // 1. Jika tombolnya 'Beli Sekarang', langsung ke Checkout
        if ($request->has('redirect_checkout')) {
            return redirect()->route('checkout');
        }

        // 2. Jika tombol Keranjang biasa, TETAP DI HALAMAN ITU (Back) + Pesan Sukses
        return redirect()->back()->with('success', "Berhasil menambahkan <b>{$product->name}</b> ke keranjang!");
    }

    // 2. Lihat Keranjang
    public function viewCart()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();
        
        $grandTotal = 0;
        foreach($cartItems as $item) {
            // Cek preventif jika produk terhapus
            if($item->product) {
                $grandTotal += $item->product->price * $item->quantity;
            }
        }

        return view('cart.index', compact('cartItems', 'grandTotal'));
    }

    // 3. Hapus Item
    public function remove(Request $request)
    {
        if (!Auth::check()) return redirect()->route('login');

        if($request->id) {
            CartItem::where('id', $request->id)
                    ->where('user_id', Auth::id())
                    ->delete();
            
            return redirect()->back()->with('success', 'Produk dihapus dari keranjang');
        }
    }
}
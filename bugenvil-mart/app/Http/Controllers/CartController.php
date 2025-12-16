<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // 1. Tambah ke Keranjang (Versi Database)
    public function addToCart($id)
    {
        // Paksa Login agar cart tersimpan di akun
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk mulai berbelanja.');
        }

        $product = Product::findOrFail($id);
        $userId = Auth::id();

        // Validasi Stok
        if($product->stock <= 0) {
            return redirect()->back()->with('error', 'Stok produk ini habis!');
        }

        // Cek apakah produk sudah ada di cart user ini?
        $cartItem = CartItem::where('user_id', $userId)
                            ->where('product_id', $id)
                            ->first();

        if ($cartItem) {
            // Jika ada, tambahkan quantity
            // Opsional: Cek apakah quantity baru melebihi stok
            if (($cartItem->quantity + 1) > $product->stock) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi untuk penambahan jumlah.');
            }
            
            $cartItem->increment('quantity');
        } else {
            // Jika belum ada, buat baru
            CartItem::create([
                'user_id' => $userId,
                'product_id' => $id,
                'quantity' => 1
            ]);
        }

        return redirect()->back()->with('success', 'Produk masuk keranjang!');
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
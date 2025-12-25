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

        // 1. Jika tombolnya 'Beli Sekarang' (redirect_checkout), langsung ke Keranjang/Checkout
        // Kita arahkan ke cart.index dulu agar user melihat ringkasan sebelum checkout
        if ($request->has('redirect_checkout')) {
            return redirect()->route('cart.index')->with('success', 'Produk ditambahkan! Silakan periksa pesanan Anda.');
        }

        // 2. Jika tombol Keranjang biasa, tetap di halaman produk
        return redirect()->back()->with('success', "Berhasil menambahkan <b>{$product->name}</b> ke keranjang!");
    }

    // 2. Lihat Keranjang
    public function viewCart()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Mengambil data keranjang milik user
        $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();
        
        // Hitung Grand Total
        $grandTotal = 0;
        foreach($cartItems as $item) {
            if($item->product) {
                $grandTotal += $item->product->price * $item->quantity;
            }
        }

        return view('cart.index', compact('cartItems', 'grandTotal'));
    }

    // 3. Update Jumlah (Tambah/Kurang) - BARU DITAMBAHKAN
    public function update(Request $request, $id)
    {
        // Cari item keranjang
        $item = CartItem::where('user_id', Auth::id())->where('id', $id)->firstOrFail();

        // Logika Tombol Tambah (+)
        if ($request->action == 'increase') {
            // Cek stok produk sebelum nambah
            if ($item->quantity < $item->product->stock) {
                $item->increment('quantity');
            } else {
                return back()->with('error', 'Stok maksimal tercapai!');
            }
        } 
        // Logika Tombol Kurang (-)
        elseif ($request->action == 'decrease') {
            if ($item->quantity > 1) {
                $item->decrement('quantity');
            } else {
                // Opsional: Jika 1 dikurang, bisa dihapus atau dibiarkan 1
                // Di sini saya biarkan 1. User harus klik tombol hapus jika ingin membuang.
                return back()->with('info', 'Minimal pembelian 1 item. Gunakan tombol hapus jika ingin membatalkan.');
            }
        }

        return redirect()->route('cart.index');
    }

    // 4. Hapus Item - DIPERBAIKI (Sesuai Route Delete)
    public function destroy($id)
    {
        if (!Auth::check()) return redirect()->route('login');

        // Hapus berdasarkan ID dan User ID (agar aman)
        $deleted = CartItem::where('id', $id)
                    ->where('user_id', Auth::id())
                    ->delete();
        
        if($deleted) {
            return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang.');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus produk.');
        }
    }
}
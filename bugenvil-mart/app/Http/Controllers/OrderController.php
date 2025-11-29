<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // 1. Tampilkan Halaman Checkout
    public function index()
    {
        if (!session('cart') || count(session('cart')) == 0) {
            return redirect()->route('products.all')->with('error', 'Keranjang belanja Anda kosong.');
        }
        return view('checkout');
    }

    // 2. Proses Simpan Pesanan (User)
    public function store(Request $request)
    {
        $request->validate([
            'address_detail' => 'required',
            'province_name' => 'required', // Ambil dari hidden input
            'city_name'     => 'required', // Ambil dari hidden input
            'postal_code'   => 'required',
            'bank'          => 'required',
            'courier'       => 'required',
        ]);

        $cart = session('cart');
        $itemTotal = 0;
        foreach($cart as $details) { 
            $itemTotal += $details['price'] * $details['quantity']; 
        }

        $shippingCost = $request->shipping_cost;
        $grandTotal = $itemTotal + $shippingCost;

        // Gabungkan Alamat
        // Format: "Jl. Mawar 10, Kota Bandung, Jawa Barat (60111) - JNE"
        $fullAddress = sprintf(
            "%s, %s, %s (%s) - Kurir: %s - Bank: %s",
            $request->address_detail,
            $request->city_name,
            $request->province_name,
            $request->postal_code,
            strtoupper($request->courier),
            $request->bank
        );

        DB::transaction(function () use ($request, $grandTotal, $fullAddress, $cart) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_price' => $grandTotal,
                'status' => 'pending', 
                'shipping_address' => $fullAddress,
                'tracking_number' => 'INV-' . strtoupper(uniqid())
            ]);

            foreach($cart as $id => $details) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'product_name' => $details['name'],
                    'quantity' => $details['quantity'],
                    'price' => $details['price']
                ]);
            }
        });

        session()->forget('cart');
        return redirect()->route('dashboard')->with('success', 'Pesanan Berhasil! Ongkir dihitung otomatis dari Tulungagung.');
    }

    // 3. Update Status Pesanan (Admin) - INI YANG TADI ERROR
    public function updateStatus(Request $request, $id) 
    {
        $order = Order::findOrFail($id);
        
        // Validasi status yang diperbolehkan
        $request->validate([
            'status' => 'required|in:packing,shipping,completed'
        ]);

        // Update database
        $order->update(['status' => $request->status]);

        // Pesan notifikasi dinamis
        $pesan = '';
        if($request->status == 'packing') {
            $pesan = 'Status diubah: Pesanan sedang DIKEMAS.';
        } elseif($request->status == 'shipping') {
            $pesan = 'Status diubah: Pesanan sedang DIKIRIM kurir.';
        } elseif($request->status == 'completed') {
            $pesan = 'Status diubah: Pesanan SELESAI / Sampai Tujuan.';
        }

        return back()->with('success', $pesan);
    }
}
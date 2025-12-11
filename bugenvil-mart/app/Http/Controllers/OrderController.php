<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        if (!session('cart') || count(session('cart')) == 0) {
            return redirect()->route('products.index')->with('error', 'Keranjang belanja Anda kosong. Silakan belanja dulu ya!');
        }
        return view('checkout');
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'address_detail' => 'required|string',
            'province_name' => 'required|string', 
            'city_name'     => 'required|string', 
            'district_name' => 'required|string', // Tambahan Kecamatan
            'village_name'  => 'required|string', // Tambahan Desa
            'postal_code'   => 'required|string',
            'bank'          => 'required|string',
            'courier'       => 'required|string',
            'shipping_cost' => 'required|numeric',
        ]);

        $cart = session('cart');
        
        if (!$cart) {
            return redirect()->route('products.index')->with('error', 'Keranjang kosong.');
        }

        $itemTotal = 0;
        foreach($cart as $details) { 
            $itemTotal += $details['price'] * $details['quantity']; 
        }

        $shippingCost = $request->shipping_cost;
        $grandTotal = $itemTotal + $shippingCost;

        // Format Alamat Lengkap: Jalan, Desa, Kecamatan, Kota, Provinsi
        $fullAddress = sprintf(
            "%s, Ds. %s, Kec. %s, %s, %s (%s) - Kurir: %s - Bank: %s",
            $request->address_detail,
            $request->village_name,
            $request->district_name,
            $request->city_name,
            $request->province_name,
            $request->postal_code,
            strtoupper($request->courier),
            $request->bank
        );

        try {
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

                    $product = Product::find($id);
                    if ($product) {
                        $product->decrement('stock', $details['quantity']);
                    }
                }
            });

            session()->forget('cart');
            return redirect()->route('dashboard')->with('success', 'Pesanan Berhasil dibuat! Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id) 
    {
        $order = Order::findOrFail($id);
        $request->validate(['status' => 'required|in:packing,shipping,completed']);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
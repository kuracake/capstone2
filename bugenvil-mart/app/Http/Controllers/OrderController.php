<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    public function index()
    {
        if (!session('cart') || count(session('cart')) == 0) {
            return redirect()->route('products.index')->with('error', 'Keranjang belanja Anda kosong.');
        }
        return view('checkout');
    }

    public function store(Request $request)
    {
        $request->validate([
            'address_detail' => 'required|string',
            'province_name' => 'required|string', 
            'city_name'     => 'required|string', 
            'district_name' => 'required|string',
            'village_name'  => 'required|string',
            'postal_code'   => 'required|string',
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

        // DISCLAIMER: Idealnya shipping_cost dihitung ulang di sini via API untuk keamanan,
        // tapi untuk level capstone, mengambil dari request masih bisa diterima.
        $shippingCost = $request->shipping_cost;
        $grandTotal = $itemTotal + $shippingCost;

        $fullAddress = sprintf(
            "%s, Ds. %s, Kec. %s, %s, %s (%s) - Kurir: %s - Bank: %s",
            $request->address_detail,
            $request->village_name,
            $request->district_name,
            $request->city_name,
            $request->province_name,
            $request->postal_code,
            strtoupper($request->courier),
        );

        try {
            DB::beginTransaction(); // Kita kendalikan manual agar bisa throw exception stok

            // 1. Buat Order Utama
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_price' => $grandTotal,
                'status' => 'pending', 
                'shipping_address' => $fullAddress,
                'tracking_number' => 'INV-' . strtoupper(uniqid())
            ]);

            // 2. Loop Item & Cek Stok
            foreach($cart as $id => $details) {
                // Lock row for update untuk mencegah race condition (optional tapi bagus)
                $product = Product::lockForUpdate()->find($id);

                if (!$product) {
                    throw new \Exception("Produk dengan ID $id tidak ditemukan.");
                }

                if ($product->stock < $details['quantity']) {
                    throw new \Exception("Stok untuk produk '{$product->name}' tidak mencukupi. Sisa stok: {$product->stock}");
                }

                // Kurangi Stok
                $product->decrement('stock', $details['quantity']);

                // Simpan Item Order
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'product_name' => $details['name'],
                    'quantity' => $details['quantity'],
                    'price' => $details['price']
                ]);
            }

            // --- MULAI TAMBAHAN MIDTRANS ---
            
            // 1. Set Konfigurasi Midtrans
            Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
            Config::$isSanitized = env('MIDTRANS_IS_SANITIZED');
            Config::$is3ds = env('MIDTRANS_IS_3DS');

            // 2. Buat Parameter untuk Midtrans
            $params = [
                'transaction_details' => [
                    'order_id' => $order->tracking_number, // ID Order Unik
                    'gross_amount' => (int) $order->total_price, // Total harga (harus integer)
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'phone' => Auth::user()->phone ?? '08123456789', // Default jika kosong
                ],
            ];

            // 3. Minta Snap Token dari Midtrans
            $snapToken = Snap::getSnapToken($params);
            
            // 4. Simpan Token ke Database Order
            $order->snap_token = $snapToken;
            $order->save();

            // --- SELESAI TAMBAHAN MIDTRANS ---

            DB::commit(); // Simpan semua perubahan
            
            session()->forget('cart');
            return redirect()->route('orders.show', $order->id);

        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan semua perubahan jika ada error/stok habis
            return back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id) 
    {
        $order = Order::findOrFail($id);
        $request->validate(['status' => 'required|in:packing,shipping,completed']);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    // Method Baru: Menampilkan Detail Order & Tombol Bayar
    public function show($id)
    {
        // Ambil order berdasarkan ID dan pastikan milik user yang login
        $order = Order::with('items')->where('user_id', Auth::id())->findOrFail($id);
        
        // Tampilkan view
        return view('orders.show', compact('order'));
    }
    
}
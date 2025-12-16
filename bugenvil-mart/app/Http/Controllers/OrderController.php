<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\CartItem; // <--- JANGAN LUPA IMPORT INI
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    public function index()
    {
        // AMBIL DARI DATABASE
        $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('products.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        // Hitung subtotal manual untuk dikirim ke view checkout
        $subtotal = 0;
        foreach($cartItems as $item) {
            $subtotal += $item->product->price * $item->quantity;
        }

        return view('checkout', compact('cartItems', 'subtotal'));
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

        // 1. AMBIL KERANJANG DARI DATABASE
        $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('products.index')->with('error', 'Keranjang kosong.');
        }

        // 2. HITUNG TOTAL
        $itemTotal = 0;
        foreach($cartItems as $item) { 
            // Akses harga dari relasi product
            $itemTotal += $item->product->price * $item->quantity; 
        }

        $shippingCost = $request->shipping_cost;
        $grandTotal = $itemTotal + $shippingCost;

        $fullAddress = sprintf(
            "%s, Ds. %s, Kec. %s, %s, %s (%s) - Kurir: %s",
            $request->address_detail,
            $request->village_name,
            $request->district_name,
            $request->city_name,
            $request->province_name,
            $request->postal_code,
            strtoupper($request->courier),
        );

        try {
            DB::beginTransaction();

            // 3. BUAT ORDER UTAMA
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_price' => $grandTotal,
                'status' => 'pending', 
                'shipping_address' => $fullAddress,
                'tracking_number' => 'INV-' . strtoupper(uniqid())
            ]);

            // 4. LOOP ITEM & CEK STOK (LOGIKA BARU)
            foreach($cartItems as $item) {
                // Lock row for update
                $product = Product::lockForUpdate()->find($item->product_id);

                if (!$product) {
                    throw new \Exception("Produk dengan ID {$item->product_id} tidak ditemukan.");
                }

                if ($product->stock < $item->quantity) {
                    throw new \Exception("Stok untuk produk '{$product->name}' tidak mencukupi. Sisa stok: {$product->stock}");
                }

                // Kurangi Stok
                $product->decrement('stock', $item->quantity);

                // Simpan Item Order
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $item->quantity,
                    'price' => $product->price // Simpan harga saat transaksi terjadi
                ]);
            }

            // 5. MIDTRANS (Tidak Berubah)
            Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
            Config::$isSanitized = env('MIDTRANS_IS_SANITIZED');
            Config::$is3ds = env('MIDTRANS_IS_3DS');

            $params = [
                'transaction_details' => [
                    'order_id' => $order->tracking_number,
                    'gross_amount' => (int) $order->total_price,
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'phone' => Auth::user()->phone ?? '08123456789',
                ],
            ];

            $snapToken = Snap::getSnapToken($params);
            $order->snap_token = $snapToken;
            $order->save();

            // 6. HAPUS KERANJANG DI DATABASE (PENTING!)
            CartItem::where('user_id', Auth::id())->delete();

            DB::commit();
            
            return redirect()->route('orders.show', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
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

    public function show($id)
    {
        $order = Order::with('items')->where('user_id', Auth::id())->findOrFail($id);
        return view('orders.show', compact('order'));
    }
}
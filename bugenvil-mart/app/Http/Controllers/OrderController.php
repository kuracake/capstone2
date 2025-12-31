<?php

namespace App\Http\Controllers; // Pastikan namespace ini sesuai folder (jika di folder Admin, ubah jadi App\Http\Controllers\Admin)

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;
use App\Notifications\NewOrderNotification;
use App\Models\User;
use Illuminate\Support\Facades\Notification;

class OrderController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('products.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $subtotal = 0;
        foreach($cartItems as $item) {
            $subtotal += $item->product->price * $item->quantity;
        }

        $savedAddresses = \App\Models\UserAddress::where('user_id', Auth::id())->get();

        return view('checkout', compact('cartItems', 'subtotal', 'savedAddresses'));
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

        try {
        \App\Models\UserAddress::firstOrCreate(
            [
                'user_id'       => Auth::id(),
                'address_detail'=> $request->address_detail, // Kunci pengecekan (biar gak duplikat persis)
                'city_id'       => $request->city_id,        // Kunci pengecekan
            ],
            [
                'province_id'   => $request->province_id,
                'province_name' => $request->province_name,
                'city_name'     => $request->city_name,
                'district_id'   => $request->district_id ?? 0, // jaga-jaga kalau null
                'district_name' => $request->district_name,
                'village_name'  => $request->village_name,
                'postal_code'   => $request->postal_code,
            ]
        );
    } catch (\Exception $e) {
        // Jika gagal simpan alamat, abaikan saja. Jangan sampai user gagal belanja cuma gara-gara fitur "save address" error.
    }

        $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('products.index')->with('error', 'Keranjang kosong.');
        }

        $itemTotal = 0;
        foreach($cartItems as $item) { 
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

            $order = Order::create([
                'user_id' => Auth::id(),
                'total_price' => $grandTotal,
                'status' => 'pending', 
                'shipping_address' => $fullAddress,
                'tracking_number' => 'INV-' . strtoupper(uniqid())
            ]);

            foreach($cartItems as $item) {
                $product = Product::lockForUpdate()->find($item->product_id);

                if (!$product) {
                    throw new \Exception("Produk dengan ID {$item->product_id} tidak ditemukan.");
                }

                if ($product->stock < $item->quantity) {
                    throw new \Exception("Stok untuk produk '{$product->name}' tidak mencukupi. Sisa stok: {$product->stock}");
                }

                $product->decrement('stock', $item->quantity);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $item->quantity,
                    'price' => $product->price 
                ]);
            }

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
                'callbacks' => [
                    'finish' => route('dashboard'),
                ],
            ];

            $snapToken = Snap::getSnapToken($params);
            $order->snap_token = $snapToken;
            $order->save();

            CartItem::where('user_id', Auth::id())->delete();

            // 1. Cari semua user yang berstatus Admin
            $admins = User::where('is_admin', true)->get();
            
            // 2. Kirim notifikasi ke mereka
            if ($admins->count() > 0) {
                Notification::send($admins, new NewOrderNotification($order));
            }

            DB::commit();
            
            return redirect()->route('orders.show', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }

    // === BAGIAN INI YANG SAYA PERBAIKI ===
    // Saya ubah nama function jadi 'update' agar sesuai dengan route resources admin
    // GANTI function update YANG TADI, MENJADI SEPERTI INI:
    public function updateStatus(Request $request, $id) 
    {
        $order = Order::findOrFail($id);
        
        // 1. Validasi Input (Status wajib, Resi boleh kosong/nullable)
        $request->validate([
            'status' => 'required',
            'resi'   => 'nullable|string'
        ]);

        // 2. Siapkan data update dasar
        $updateData = [
            'status' => $request->status
        ];

        // 3. LOGIKA PENTING: Cek apakah Admin menginput Resi?
        // Jika ada isinya, masukkan ke array updateData
        if ($request->filled('resi')) {
            $updateData['resi'] = $request->resi;
        }

        // 4. Lakukan Update ke Database
        $order->update($updateData);

        return back()->with('success', 'Status pesanan dan nomor resi berhasil diperbarui.');
    }
    // ======================================

    public function show($id)
    {
        $order = Order::with('items.product')->where('user_id', Auth::id())->findOrFail($id);
        return view('orders.show', compact('order'));
    }
}
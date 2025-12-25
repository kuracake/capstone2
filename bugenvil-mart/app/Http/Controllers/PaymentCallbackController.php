<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Midtrans\Config;
use Midtrans\Notification;

class PaymentCallbackController extends Controller
{
    public function receive()
    {
        // 1. Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        try {
            // 2. Ambil Notifikasi dari Midtrans
            $notif = new Notification();

            $transaction = $notif->transaction_status;
            $type = $notif->payment_type;
            $orderId = $notif->order_id;
            $fraud = $notif->fraud_status;

            // 3. Cari Order berdasarkan ID
            $order = Order::where('tracking_number', $orderId)->first();

            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            // 4. Logika Update Status
            if ($transaction == 'capture') {
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        $order->update(['status' => 'pending']);
                    } else {
                        $order->update(['status' => 'packing']); // LUNAS -> DIKEMAS
                    }
                }
            } else if ($transaction == 'settlement') {
                // Settlement = Uang masuk (Transfer Bank/Gopay/dll)
                $order->update(['status' => 'packing']); // LUNAS -> DIKEMAS
            } else if ($transaction == 'pending') {
                $order->update(['status' => 'pending']);
            } else if ($transaction == 'deny') {
                $order->update(['status' => 'cancelled']);
            } else if ($transaction == 'expire') {
                $order->update(['status' => 'cancelled']);
            } else if ($transaction == 'cancel') {
                $order->update(['status' => 'cancelled']);
            }

            return response()->json(['message' => 'Payment status updated']);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
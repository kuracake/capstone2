<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Notifications\OrderStatusUpdated;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id) 
    {
        $order = Order::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:packing,shipping,completed,cancelled',
            'resi'   => 'nullable|string'
        ]);

        $data = [
            'status' => $request->status
        ];

        // --- BAGIAN INI YANG SEPERTINYA BELUM ADA DI FILE BAPAK ---
        // Logika: Jika admin mengisi resi, simpan ke database!
        if ($request->filled('resi')) {
            $data['resi'] = $request->resi;
        }
        // ---------------------------------------------------------

        $order->update($data);

        if ($order->user) {
        $order->user->notify(new OrderStatusUpdated($order));
    }

        // Perhatikan pesan suksesnya ada kata "& Resi"
        return back()->with('success', 'Status pesanan & Resi berhasil diperbarui!');
    }
}
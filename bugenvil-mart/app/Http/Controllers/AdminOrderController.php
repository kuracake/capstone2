<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['user', 'items'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id) 
    {
        $order = Order::findOrFail($id);
        $request->validate(['status' => 'required|in:packing,shipping,completed']);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Status berhasil diperbarui');
    }
}
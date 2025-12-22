<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    // ==========================================
    // BAGIAN PENGGUNA (User)
    // ==========================================

    // 1. Menampilkan Form (Logic Baru: Harus bawa ID Order)
    public function create(Order $order)
    {
        // A. Keamanan: Cek apakah yang lapor adalah pemilik pesanan
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }

        // B. Cek Status: Hanya boleh lapor jika status completed atau shipping
        // Sesuaikan dengan status di database Anda (misal: 'completed')
        if ($order->status !== 'completed' && $order->status !== 'shipping') {
             return redirect()->route('orders.show', $order->id)
                ->with('error', 'Pesanan harus diterima/dikirim dulu baru bisa dilaporkan.');
        }

        // C. Cek Duplikat: Jika sudah pernah lapor, tolak
        if ($order->report) {
            return redirect()->route('orders.show', $order->id)
                ->with('error', 'Anda sudah melaporkan pesanan ini sebelumnya.');
        }

        return view('reports.create', compact('order'));
    }

    // 2. Menyimpan Laporan (Logic Baru)
    public function store(Request $request, Order $order)
    {
        // A. Keamanan lagi
        if ($order->user_id !== Auth::id()) abort(403);

        // B. Validasi
        $request->validate([
            'description' => 'required|string', // Pastikan di form namanya 'description'
            'image'       => 'required|file|mimes:jpeg,png,jpg|max:2048',
        ]);

        // C. Upload Gambar
        $imagePath = null;
        if ($request->hasFile('image')) {
            // Simpan ke folder 'reports' di storage public
            $imagePath = $request->file('image')->store('reports', 'public');
        }

        // D. Simpan ke Database (SESUAI KOLOM ANDA)
        Report::create([
            'user_id'             => Auth::id(),
            'order_id'            => $order->id,         // Ambil dari Route, bukan Request
            'subject'             => 'Keluhan Pesanan',  // Default subject
            'description'         => $request->description, // Masuk ke kolom 'description'
            'evidence_image_path' => $imagePath,         // Masuk ke kolom 'evidence_image_path'
            'status'              => 'pending',
        ]);

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Laporan berhasil dikirim. Admin akan mengeceknya.');
    }

    // ==========================================
    // BAGIAN ADMIN (Tetap Dipertahankan)
    // ==========================================

    public function indexAdmin()
    {
        $reports = Report::with('user', 'order')->latest()->paginate(10);
        return view('admin.reports', compact('reports'));
    }

    public function updateStatus(Request $request, $id)
    {
        $report = Report::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,process,resolved,rejected'
        ]);
        
        $report->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status laporan berhasil diperbarui.');
    }
}
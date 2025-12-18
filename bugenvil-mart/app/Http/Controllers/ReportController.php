<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    // SISI PENGGUNA: Menampilkan Form Laporan
    public function create()
    {
        $orders = Order::where('user_id', Auth::id())->where('status', 'completed')->get();
        return view('reports.create', compact('orders'));
    }

    // SISI PENGGUNA: Menyimpan Laporan
   public function store(Request $request)
{
    $request->validate([
        'order_id'          => 'required|exists:orders,id', 
        'issue_description' => 'required|string',
        'image'             => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Simpan ke disk 'public' agar bisa diakses browser via storage:link
    $imagePath = $request->file('image')->store('reports', 'public');

    Report::create([
        'user_id'           => Auth::id(),
        'order_id'          => $request->order_id, 
        'issue_description' => $request->issue_description,
        'image'             => $imagePath,
        'status'            => 'pending',
    ]);

    return redirect()->route('dashboard')->with('success', 'Laporan berhasil dikirim.');
}
    // SISI ADMIN: Daftar Semua Laporan
    public function indexAdmin()
{
    // Mengambil data report beserta data user yang melaporkan
    $reports = Report::with('user')->latest()->paginate(10);
    return view('admin.reports', compact('reports'));
}

public function updateStatus(Request $request, $id)
{
    $report = Report::findOrFail($id);
    
    // Validasi agar status yang masuk sesuai ketentuan
    $request->validate([
        'status' => 'required|in:pending,process,resolved,rejected'
    ]);
    
    $report->update([
        'status' => $request->status
    ]);

    return back()->with('success', 'Status laporan berhasil diperbarui.');
}
}
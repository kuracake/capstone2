<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    // 1. Tampilkan Form Laporan (Untuk User)
    public function create() {
        return view('welcome'); // Formnya ada di homepage (welcome)
    }

    // 2. Proses Simpan Laporan (Dari Form)
    public function store(Request $request) {
        // Validasi Input
        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'evidence' => 'required|image|mimes:jpeg,png,jpg|max:10240', // Maks 10MB
        ]);

        // Proses Upload Gambar
        $path = null;
        if ($request->hasFile('evidence')) {
            // Simpan gambar ke folder 'public/reports'
            $path = $request->file('evidence')->store('reports', 'public');
        }

        // Simpan Data ke Database
        Report::create([
            'user_id' => auth()->id(),
            'subject' => $request->subject,
            'description' => $request->description,
            'evidence_image_path' => $path,
            'status' => 'pending'
        ]);

        // Redirect kembali ke Dashboard dengan pesan Sukses
        return redirect()->route('dashboard')->with('success', 'Laporan Anda berhasil dikirim! Tim kami akan segera memeriksanya.');
    }

    // 3. Tampilkan Daftar Laporan (Khusus Admin)
    public function indexAdmin() {
        $reports = Report::with('user')->latest()->get();
        // Pastikan nama view sesuai dengan nama file yang baru dibuat: admin.reports
        return view('admin.reports', compact('reports')); 
    }

    // 4. Update Status Laporan (Khusus Admin)
    public function updateStatus(Request $request, $id) {
        $report = Report::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,processing,resolved,rejected'
        ]);

        $report->update(['status' => $request->status]);

        return back()->with('success', 'Status laporan berhasil diperbarui.');
    }
}
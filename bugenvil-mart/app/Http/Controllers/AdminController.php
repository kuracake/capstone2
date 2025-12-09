<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\VideoTutorial;

class AdminController extends Controller
{
    // Halaman Dashboard
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // --- FITUR PRODUK ---

    // Menampilkan Form Tambah Produk
    public function createProduct()
    {
        return view('admin.products.create');
    }

    // Menyimpan Produk ke Database
    public function storeProduct(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
        ]);

        // 2. Upload Gambar
        $imagePath = null;
        if ($request->hasFile('image')) {
            // Simpan ke folder 'storage/app/public/products'
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // 3. Simpan Data ke Database
        \App\Models\Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $imagePath, // Pastikan kolom di DB bernama 'image'
        ]);

        // 4. Redirect kembali ke dashboard
        return redirect()->route('dashboard')->with('success', 'Produk berhasil ditambahkan!');
    }

    // --- FITUR VIDEO TUTORIAL ---

    // Menampilkan Form Tambah Video
    public function createVideo()
    {
        return view('admin.videos.create');
    }

    // Menyimpan Video
    public function storeVideo(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'title' => 'required|string|max:255',
            'video_file' => 'required|file|mimes:mp4,mov,ogg,qt|max:20000', // Max 20MB
        ]);

        // 2. Upload Video
        $videoPath = null;
        if ($request->hasFile('video_file')) {
            $videoPath = $request->file('video_file')->store('videos', 'public');
        }

        // 3. Simpan ke Database
        \App\Models\VideoTutorial::create([
            'title' => $request->title,
            'video_url' => $videoPath,
        ]);

        // 4. Redirect
        return redirect()->route('dashboard')->with('success', 'Video tutorial berhasil ditambahkan!');
    }

    // --- TAMBAHAN CRUD VIDEO ---

    // 1. Tampilkan Daftar Video (Tabel)
    public function indexVideo()
    {
        $videos = VideoTutorial::latest()->get();
        return view('admin.videos.index', compact('videos'));
    }

    // 2. Tampilkan Form Edit
    public function editVideo($id)
    {
        $video = VideoTutorial::findOrFail($id);
        return view('admin.videos.edit', compact('video'));
    }

    // 3. Proses Update (Simpan Perubahan)
    public function updateVideo(Request $request, $id)
    {
        $video = VideoTutorial::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'video_file' => 'nullable|file|mimes:mp4,mov,ogg,qt|max:20000', // Nullable: tidak wajib upload ulang
        ]);

        // Update Judul
        $video->title = $request->title;

        // Cek jika ada file video BARU yang diupload
        if ($request->hasFile('video_file')) {
            // Upload video baru
            $videoPath = $request->file('video_file')->store('videos', 'public');
            $video->video_url = $videoPath;
        }

        $video->save();

        return redirect()->route('tutorials.index')->with('success', 'Video berhasil diperbarui!');
    }

    // 4. Proses Hapus
    public function destroyVideo($id)
    {
        $video = VideoTutorial::findOrFail($id);

        // Hapus data dari database
        $video->delete();

        return redirect()->route('tutorials.index')->with('success', 'Video berhasil dihapus!');
    }
}
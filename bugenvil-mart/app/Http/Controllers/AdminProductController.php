<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Pastikan import Model

class AdminProductController extends Controller
{
    // Menampilkan daftar produk (jika diperlukan nanti)
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    // Menampilkan Form Tambah Produk
    public function create() // Nama standar: create (bukan createProduct)
    {
        return view('admin.products.create');
    }

    // Menyimpan Produk ke Database
    public function store(Request $request) // Nama standar: store
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Upload Gambar
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // 3. Simpan Data ke Database
        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        // 4. Redirect kembali
        return redirect()->route('admin.dashboard')->with('success', 'Produk berhasil ditambahkan!');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage; // Pastikan Model ini di-import
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    // --- FUNGSI STORE YANG SUDAH DIPERBAIKI ---
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'weight' => 'required|numeric',
            // Validasi Array Gambar (Wajib ada minimal 1)
            'images' => 'required|array|min:1', 
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        // 2. Buat Data Produk Dasar
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'weight' => $request->weight,
            // Kolom image akan diisi di bawah
            'image' => null, 
        ]);

        // 3. Proses Upload Gambar
        if ($request->hasFile('images')) {
            $files = $request->file('images');

            // A. Simpan Gambar PERTAMA sebagai Thumbnail Utama (kolom image)
            if (isset($files[0])) {
                $thumbnailPath = $files[0]->store('products', 'public');
                // Update kolom image di tabel products
                $product->update(['image' => $thumbnailPath]);
            }

            // B. Simpan SEMUA gambar ke tabel 'product_images' (Galeri)
            foreach ($files as $file) {
                // Simpan fisik file ke folder gallery
                $galleryPath = $file->store('product_gallery', 'public');
                
                // Simpan path ke database relasi
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $galleryPath
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            // images nullable saat edit (jika user tidak ingin ubah foto)
            'images' => 'nullable|array|max:10', 
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Update data text
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'weight' => $request->weight,
        ]);

        // Cek apakah user upload foto baru?
        if ($request->hasFile('images')) {
            
            // Cek batas maksimal 10 foto
            if (($product->images->count() + count($request->images)) > 10) {
                 return back()->with('error', 'Maksimal total 10 foto!');
            }

            foreach ($request->file('images') as $file) {
                $path = $file->store('product_gallery', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk diperbarui!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // Hapus file thumbnail utama
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Hapus semua file di galeri (looping)
        foreach($product->images as $gallery) {
             Storage::disk('public')->delete($gallery->image_path);
        }
        
        // Hapus data di database (Cascade akan menghapus product_images otomatis jika di set di migrasi)
        // Tapi manual delete record untuk memastikan
        $product->images()->delete(); 
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
    }

    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);
        // Hapus file fisik
        Storage::disk('public')->delete($image->image_path);
        // Hapus record db
        $image->delete();
        
        return back()->with('success', 'Foto galeri berhasil dihapus');
    }
}
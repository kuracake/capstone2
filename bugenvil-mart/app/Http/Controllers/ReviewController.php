<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $id)
    {
        $user = Auth::user();
        $product = Product::findOrFail($id);

        // 1. Validasi Input
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
            'image'   => 'nullable|image|max:2048',
        ]);

        // 2. Cek apakah user sudah pernah review produk ini? (Cegah Spam)
        $existingReview = Review::where('user_id', $user->id)
                                ->where('product_id', $product->id)
                                ->first();

        if ($existingReview) {
            return back()->with('error', 'Anda sudah memberikan penilaian untuk produk ini.');
        }

        // 3. Upload Gambar Review (Jika ada)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('reviews', 'public');
        }

        // 4. Simpan ke Database
        Review::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'image' => $imagePath
        ]);

        return back()->with('success', 'Terima kasih atas penilaian Anda!');
    }
}
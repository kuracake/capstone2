<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VideoTutorial; // Pastikan import Model

class AdminVideoController extends Controller
{
    // 1. Tampilkan Daftar Video
    public function index()
    {
        $videos = VideoTutorial::latest()->get();
        return view('admin.videos.index', compact('videos'));
    }

    // 2. Menampilkan Form Tambah Video
    public function create()
    {
        return view('admin.videos.create');
    }

    // 3. Menyimpan Video
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'video_file' => 'required|file|mimes:mp4,mov,ogg,qt|max:20000', // 20MB
        ]);

        $videoPath = null;
        if ($request->hasFile('video_file')) {
            $videoPath = $request->file('video_file')->store('videos', 'public');
        }

        VideoTutorial::create([
            'title' => $request->title,
            'video_url' => $videoPath,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Video tutorial berhasil ditambahkan!');
    }

    // 4. Tampilkan Form Edit
    public function edit($id)
    {
        $video = VideoTutorial::findOrFail($id);
        return view('admin.videos.edit', compact('video'));
    }

    // 5. Proses Update
    public function update(Request $request, $id)
    {
        $video = VideoTutorial::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'video_file' => 'nullable|file|mimes:mp4,mov,ogg,qt|max:20000',
        ]);

        $video->title = $request->title;

        if ($request->hasFile('video_file')) {
            $videoPath = $request->file('video_file')->store('videos', 'public');
            $video->video_url = $videoPath;
        }

        $video->save();

        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil diperbarui!');
    }

    // 6. Proses Hapus
    public function destroy($id)
    {
        $video = VideoTutorial::findOrFail($id);
        $video->delete();
        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil dihapus!');
    }
}
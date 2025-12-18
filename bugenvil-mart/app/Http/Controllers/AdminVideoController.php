<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VideoTutorial;
use Illuminate\Support\Facades\Storage;

class AdminVideoController extends Controller
{
    public function index()
    {
        $videos = VideoTutorial::latest()->paginate(10);
        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        return view('admin.videos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'video_file' => 'required|file|mimes:mp4,mov,ogg,qt|max:20000',
        ]);

        $videoPath = $request->file('video_file')->store('videos', 'public');

        VideoTutorial::create([
            'title' => $request->title,
            'description' => $request->description,
            'video_url' => $videoPath,
        ]);

        return redirect()->route('admin.videos.index')->with('success', 'Tutorial berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $video = VideoTutorial::findOrFail($id);
        return view('admin.videos.edit', compact('video'));
    }

    public function update(Request $request, $id)
    {
        $video = VideoTutorial::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'video_file' => 'nullable|file|mimes:mp4,mov,ogg,qt|max:20000',
        ]);

        $video->title = $request->title;
        $video->description = $request->description;

        if ($request->hasFile('video_file')) {
            // Hapus file lama jika ada
            if ($video->video_url && Storage::disk('public')->exists($video->video_url)) {
                Storage::disk('public')->delete($video->video_url);
            }
            $video->video_url = $request->file('video_file')->store('videos', 'public');
        }

        $video->save();

        return redirect()->route('admin.videos.index')->with('success', 'Tutorial berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $video = VideoTutorial::findOrFail($id);
        if ($video->video_url) {
            Storage::disk('public')->delete($video->video_url);
        }
        $video->delete();
        return redirect()->route('admin.videos.index')->with('success', 'Tutorial berhasil dihapus!');
    }
}
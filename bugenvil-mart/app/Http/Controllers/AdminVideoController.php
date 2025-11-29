<?php
namespace App\Http\Controllers;
use App\Models\VideoTutorial;
use Illuminate\Http\Request;

class AdminVideoController extends Controller
{
    public function index() {
        $videos = VideoTutorial::all();
        return view('admin.videos.index', compact('videos'));
    }

    public function update(Request $request, $id) {
        $video = VideoTutorial::findOrFail($id);
        $video->update([
            'video_url' => $request->video_url
        ]);
        return back()->with('success', 'Link video berhasil diupdate!');
    }
}
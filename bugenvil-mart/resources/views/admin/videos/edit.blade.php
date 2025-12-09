<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Video Tutorial</h2>

                <form action="{{ route('admin.videos.update', $video->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT') <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Judul Video</label>
                        <input type="text" name="title" value="{{ $video->title }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Ganti Video (Opsional)</label>
                        <input type="file" name="video_file" class="block w-full text-sm text-gray-500 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" accept="video/*">
                        <p class="text-xs text-gray-500 mt-2">Biarkan kosong jika tidak ingin mengganti video saat ini.</p>
                        
                        <div class="mt-2 text-sm text-gray-600">
                            Video saat ini: 
                            <a href="{{ asset('storage/' . $video->video_url) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Video</a>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('tutorials.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                            Update Video
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
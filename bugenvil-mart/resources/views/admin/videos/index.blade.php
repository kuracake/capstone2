<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Update Video Tutorial Homepage</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($videos as $video)
                <div class="bg-white p-6 rounded shadow">
                    <h3 class="font-bold mb-2">{{ $video->title }}</h3>
                    <div class="mb-4">
                        <iframe class="w-full h-32" src="{{ $video->video_url }}"></iframe>
                    </div>
                    <form action="{{ route('admin.videos.update', $video->id) }}" method="POST">
                        @csrf @method('PUT')
                        <label class="text-xs text-gray-500">Ganti Link Youtube (Embed):</label>
                        <input type="text" name="video_url" value="{{ $video->video_url }}" class="w-full border text-sm p-1 rounded mb-2">
                        <button class="bg-blue-600 text-white text-xs px-2 py-1 rounded">Update</button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
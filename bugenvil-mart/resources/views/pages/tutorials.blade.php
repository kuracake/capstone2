<x-app-layout>
    <div class="bg-white py-12">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-fuchsia-600 serif mb-4">Pusat Belajar</h1>
                <p class="text-gray-600">Video panduan lengkap untuk pemula hingga ahli.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($videos as $video)
                <div class="flex flex-col md:flex-row bg-pink-50 rounded-2xl overflow-hidden shadow hover:shadow-md transition">
                    <div class="md:w-1/2 relative">
                         <iframe class="w-full h-full min-h-[200px]" src="{{ $video->video_url }}" allowfullscreen></iframe>
                    </div>
                    <div class="p-6 md:w-1/2 flex flex-col justify-center">
                        <h3 class="font-bold text-xl text-gray-800 mb-2">{{ $video->title }}</h3>
                        <p class="text-gray-600 text-sm mb-4">{{ $video->description }}</p>
                        <a href="{{ $video->video_url }}" target="_blank" class="text-fuchsia-600 font-bold text-sm hover:underline">Buka di YouTube &rarr;</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
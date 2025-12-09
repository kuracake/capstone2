<x-app-layout>
    <div class="bg-white py-12">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-fuchsia-600 serif mb-4">Pusat Belajar</h1>
                <p class="text-gray-600">Video panduan lengkap untuk pemula hingga ahli.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($videos as $video)
                <div class="flex flex-col bg-pink-50 rounded-2xl overflow-hidden shadow hover:shadow-md transition">
                    
                    <div class="relative w-full bg-black">
                        <video controls class="w-full h-auto max-h-[300px] mx-auto">
                            <source src="{{ asset('storage/' . $video->video_url) }}" type="video/mp4">
                            Browser Anda tidak mendukung tag video.
                        </video>
                    </div>

                    <div class="p-6 flex flex-col justify-between h-full">
                        <div>
                            <h3 class="font-bold text-xl text-gray-800 mb-2">{{ $video->title }}</h3>
                            <p class="text-gray-600 text-sm mb-4">
                                {{ $video->description ?? 'Tonton video tutorial lengkap tentang perawatan Bougenville.' }}
                            </p>
                        </div>
                        
                        <div class="mt-4">
                            <a href="{{ asset('storage/' . $video->video_url) }}" download class="text-fuchsia-600 font-bold text-sm hover:underline flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M12 9.75v10.5m0 0L7.5 15.75m4.5 4.5 4.5-4.5m-4.5-10.5h.008v.008H12v-.008Z" />
                                </svg>
                                Download Video
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if($videos->isEmpty())
                <div class="text-center py-10 text-gray-500">
                    Belum ada video tutorial yang diunggah.
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
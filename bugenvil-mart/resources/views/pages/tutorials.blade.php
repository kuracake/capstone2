<x-app-layout>

    {{-- 1. HERO HEADER (Gaya Baru) --}}
    <div class="relative bg-fuchsia-900 py-16 md:py-20 overflow-hidden">
        {{-- Dekorasi Latar Belakang --}}
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full translate-x-1/2 -translate-y-1/2 blur-2xl"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full -translate-x-1/2 translate-y-1/2 blur-2xl"></div>
        
        <div class="relative z-10 container mx-auto px-6 text-center">
            <h1 class="text-3xl md:text-5xl font-bold text-white mb-4 font-serif tracking-wide">
                Video Tutorial
            </h1>
            <p class="text-fuchsia-100 max-w-2xl mx-auto text-base md:text-lg font-light leading-relaxed">
                Kumpulan video panduan perawatan Bougenville untuk hasil terbaik.
            </p>
        </div>
    </div>

    {{-- 2. MAIN CONTENT (Grid Video) --}}
    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="container mx-auto px-6">
            
            {{-- Grid Video --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10">
                @foreach($videos as $video)
                <div class="bg-white rounded-3xl shadow-lg hover:shadow-xl transition overflow-hidden group border border-purple-50 flex flex-col h-full">
                    
                    {{-- Video Container dengan Overlay Play Button --}}
                    <div class="relative h-56 md:h-64 bg-black flex-shrink-0 cursor-pointer" onclick="playVideo(this)">
                        
                        {{-- Overlay Play Button (Akan hilang saat diklik) --}}
                        <div class="absolute inset-0 flex items-center justify-center bg-black/30 group-hover:bg-black/40 transition z-10 play-overlay">
                            <div class="w-16 h-16 bg-white/90 rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8 text-fuchsia-600 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </div>
                        </div>

                        {{-- Video Element --}}
                        <video 
                            class="w-full h-full object-cover" 
                            controls 
                            preload="metadata"
                        >
                            <source src="{{ asset('storage/' . $video->video_url) }}" type="video/mp4">
                            Browser Anda tidak mendukung pemutar video.
                        </video>
                    </div>

                    {{-- Deskripsi Video --}}
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="font-bold text-xl text-gray-800 mb-3 serif leading-snug group-hover:text-fuchsia-600 transition" title="{{ $video->title }}">
                            {{ $video->title }}
                        </h3>
                        
                        <p class="text-gray-500 text-sm line-clamp-4 leading-relaxed mb-4">
                            {{ $video->description ?? 'Tidak ada deskripsi tersedia.' }}
                        </p>

                        <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-400">
                            <span>Diunggah {{ $video->created_at->diffForHumans() }}</span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                Video
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Empty State --}}
            @if($videos->isEmpty())
                <div class="text-center py-20 bg-white rounded-3xl shadow-sm border border-gray-100 mt-10">
                    <div class="bg-gray-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Belum ada video</h3>
                    <p class="text-gray-500 mt-2">Nantikan tutorial menarik kami segera.</p>
                    <a href="{{ route('home') }}" class="inline-block mt-6 text-fuchsia-600 font-bold hover:underline">Kembali ke Beranda</a>
                </div>
            @endif

            {{-- Pagination --}}
            @if(method_exists($videos, 'links'))
                <div class="mt-12">
                    {{ $videos->links() }}
                </div>
            @endif

        </div>
    </div>

    {{-- Script Play Button --}}
    <script>
        function playVideo(element) {
            const video = element.querySelector('video');
            const overlay = element.querySelector('.play-overlay');
            
            if (video.paused) {
                // Pause semua video lain
                document.querySelectorAll('video').forEach(v => {
                    if(v !== video) v.pause();
                });
                
                // Reset semua overlay lain
                document.querySelectorAll('.play-overlay').forEach(o => {
                    if(o !== overlay) o.classList.remove('hidden');
                });

                video.play();
                overlay.classList.add('hidden'); 
            } else {
                video.pause();
                overlay.classList.remove('hidden'); 
            }
        }
    </script>
</x-app-layout>
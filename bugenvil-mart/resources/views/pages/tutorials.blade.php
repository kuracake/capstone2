<x-app-layout>
    {{-- 1. HERO HEADER (Gaya Baru) --}}
    <div class="bg-fuchsia-900 py-16 md:py-20 relative overflow-hidden">
        {{-- Dekorasi Latar Belakang --}}
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full translate-x-1/2 -translate-y-1/2 blur-2xl"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full -translate-x-1/2 translate-y-1/2 blur-2xl"></div>
        
        <div class="container mx-auto px-6 text-center relative z-10">
            <h1 class="text-3xl md:text-5xl font-bold text-white mb-4 font-serif tracking-wide">
                Video Tutorial
            </h1>
            <p class="text-fuchsia-100 max-w-2xl mx-auto text-base md:text-lg font-light leading-relaxed">
                Kumpulan video panduan perawatan Bougenville untuk hasil terbaik.
            </p>
        </div>
    </div>

    {{-- 2. GRID VIDEO --}}
    <div class="py-12 md:py-16 bg-white min-h-screen">
        <div class="container mx-auto px-6">
            
            @if($videos->isEmpty())
                <div class="text-center py-24 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-100">
                    <p class="text-gray-500 font-medium">Belum ada video tutorial saat ini.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($videos as $video)
                    <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden flex flex-col h-full group">
                        
                        {{-- CONTAINER VIDEO (Padding Hack 16:9) --}}
                        <div class="relative w-full bg-black" style="padding-bottom: 56.25%;">
                            <video 
                                class="absolute inset-0 w-full h-full object-contain" 
                                controls 
                                preload="metadata"
                                poster="{{ asset('img/video-placeholder.jpg') }}"> 
                                <source src="{{ asset('storage/' . $video->video_url) }}" type="video/mp4">
                                Browser Anda tidak mendukung tag video.
                            </video>
                        </div>

                        {{-- INFO VIDEO --}}
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="text-[10px] font-bold text-fuchsia-600 bg-fuchsia-50 px-2.5 py-1 rounded uppercase tracking-wide">
                                    Tutorial
                                </span>
                                <span class="text-[11px] text-gray-400">
                                    • {{ $video->created_at->diffForHumans() }}
                                </span>
                            </div>

                            <h3 class="text-lg font-bold text-gray-900 mb-2 leading-snug line-clamp-2 group-hover:text-fuchsia-700 transition-colors" title="{{ $video->title }}">
                                {{ $video->title }}
                            </h3>
                            
                            <p class="text-gray-500 text-sm leading-relaxed line-clamp-3">
                                {{ $video->description ?? 'Tidak ada deskripsi.' }}
                            </p>
                        </div>

                    </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-16">
                    {{ $videos->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
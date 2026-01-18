<x-app-layout>

    {{-- HERO SECTION --}}
    <div class="relative w-full h-[600px] md:h-screen flex items-center justify-center overflow-hidden">
        
        {{-- Background Image --}}
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('img/background-utama.jpg') }}" alt="Background Bugenvil" class="w-full h-full object-cover object-center">
        </div>
        
        {{-- Overlay Gelap --}}
        <div class="absolute inset-0 bg-black/40 md:bg-black/50 z-10"></div>
        
        {{-- Content --}}
        <div class="relative z-20 container mx-auto px-6 text-center text-white mt-8 md:mt-0">
            <h1 class="text-4xl sm:text-5xl md:text-7xl font-bold serif mb-4 md:mb-6 drop-shadow-lg leading-tight">
                Bawa Keindahan Alam <br class="hidden md:block"> Ke Taman Anda
            </h1>
            
            <p class="text-base sm:text-lg md:text-xl text-gray-100 mb-8 md:mb-10 max-w-2xl mx-auto font-light leading-relaxed drop-shadow-md px-2">
                Temukan koleksi premium bunga Bugenvil kami. Warna cerah, tanaman sehat, dikirim langsung ke depan pintu rumah Anda.
            </p>
            
            <a href="{{ route('products.index') }}" class="inline-block bg-fuchsia-600 hover:bg-fuchsia-700 text-white font-bold py-3 px-8 md:py-4 md:px-12 rounded-full shadow-xl transition transform hover:scale-105 hover:shadow-2xl">
                Belanja Sekarang
            </a>
        </div>
    </div>

    {{-- FITUR UNGGULAN --}}
    <div class="bg-white py-12">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="bg-fuchsia-100 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 text-fuchsia-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-800">Pengiriman Cepat</h3>
                    <p class="text-xs md:text-sm text-gray-500">Aman & Cepat Nasional</p>
                </div>
                <div>
                    <div class="bg-purple-100 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 text-purple-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-800">Tanaman Sehat</h3>
                    <p class="text-xs md:text-sm text-gray-500">Garansi Kualitas Bunga</p>
                </div>
                <div>
                    <div class="bg-fuchsia-100 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 text-fuchsia-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-800">Layanan 24/7</h3>
                    <p class="text-xs md:text-sm text-gray-500">Bantuan Ahli Kebun</p>
                </div>
                <div>
                    <div class="bg-purple-100 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 text-purple-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-800">Pembayaran Aman</h3>
                    <p class="text-xs md:text-sm text-gray-500">Transaksi Terjamin</p>
                </div>
            </div>
        </div>
    </div>

    {{-- PRODUK UNGGULAN --}}
    <div id="products" class="bg-pink-50 py-16 md:py-24">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12 md:mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-fuchsia-600 serif mb-4">Produk Unggulan</h2>
                <p class="text-gray-600 text-base md:text-lg">Jelajahi varietas Bugenvil paling populer kami</p>
            </div>

            {{-- Grid Produk --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-8">
                @foreach($products as $product)
                <div class="bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col h-full group overflow-hidden relative">
                    
                    {{-- Gambar Produk --}}
                    <div class="relative aspect-square overflow-hidden bg-gray-100">
                        <a href="{{ route('products.show', $product->id) }}" class="block w-full h-full relative">
                            
                            {{-- LOGIKA BADGE "PALING LARIS" (REAL DATA) --}}
                            {{-- Z-Index 20 agar di atas overlay --}}
                            <div class="absolute top-2 right-2 flex flex-col items-end gap-1 z-20">
                                {{-- 1. Badge Stok Habis --}}
                                @if($product->stock == 0)
                                    <span class="bg-gray-800 text-white text-[10px] font-bold px-2 py-1 rounded-full shadow-sm uppercase tracking-wide">
                                        Stok Habis
                                    </span>
                                {{-- 2. Badge Segera Habis (Jika stok < 5) --}}
                                @elseif($product->stock <= 5)
                                    <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded-full shadow-sm uppercase tracking-wide animate-pulse">
                                        Segera Habis
                                    </span>
                                @endif

                                {{-- 3. Badge Paling Laris (Jika terjual > 0) --}}
                                @if(($product->order_items_sum_quantity ?? 0) > 0)
                                    <span class="bg-amber-400 text-white text-[10px] font-bold px-2 py-1 rounded-full shadow-sm uppercase tracking-wide flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        Paling Laris
                                    </span>
                                @endif
                            </div>
                            
                            {{-- Image --}}
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://source.unsplash.com/random/400x400?bougainvillea,flower&sig='.$product->id }}"
                                 class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 z-0">
                            
                            {{-- OVERLAY GRADIENT (Seperti Halaman Produk) --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10"></div>
                        </a>
                    </div>

                    {{-- Info Produk --}}
                    <div class="p-4 flex flex-col flex-grow">
                        <a href="{{ route('products.show', $product->id) }}" class="hover:text-fuchsia-600 transition">
                            <h3 class="font-bold text-sm md:text-lg text-gray-900 mb-1 serif line-clamp-2 leading-tight">{{ $product->name }}</h3>
                        </a>
                        
                        {{-- Rating (Data Nyata) --}}
                        <div class="flex items-center gap-1 text-yellow-400 text-xs mb-3">
                            @php $rating = round($product->reviews_avg_rating ?? 0); @endphp
                            @for($i=0; $i<5; $i++)
                                <svg class="w-3 h-3 {{ $i < $rating ? 'fill-current' : 'text-gray-300 fill-current' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                            <span class="text-gray-400 ml-1">({{ $product->reviews_count ?? 0 }})</span>
                        </div>

                        {{-- Harga --}}
                        <div class="mt-auto pt-3 border-t border-gray-50 flex justify-between items-center">
                            <span class="text-base md:text-xl font-bold text-fuchsia-600 block">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                            @if(($product->order_items_sum_quantity ?? 0) > 0)
                                <span class="text-[10px] text-gray-500">{{ $product->order_items_sum_quantity }} Terjual</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-12 md:mt-16">
                 <a href="{{ route('products.index') }}" class="inline-block bg-fuchsia-500 hover:bg-fuchsia-600 text-white font-bold py-3 px-10 rounded-full shadow-lg transition transform hover:scale-105">Lihat Semua Produk</a>
            </div>
        </div>
    </div>

    {{-- VIDEO TUTORIAL --}}
    <section id="tutorials" class="bg-slate-50 py-16 md:py-24">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12 md:mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-fuchsia-600 serif mb-4">Video Tutorial</h2>
                <p class="text-gray-600 text-base md:text-lg">Pelajari cara merawat tanaman dan tips budidaya terbaik</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 md:gap-10">
                @foreach($videos as $video)
                <div class="bg-white rounded-3xl shadow-lg hover:shadow-xl transition overflow-hidden group border border-purple-50 flex flex-col h-full">
                    
                    {{-- Container Video dengan Overlay Play Button --}}
                    <div class="relative h-48 md:h-64 bg-black flex-shrink-0 cursor-pointer" onclick="playVideo(this)">
                        
                        {{-- Overlay Play Button (Akan hilang saat diklik) --}}
                        <div class="absolute inset-0 flex items-center justify-center bg-black/30 group-hover:bg-black/40 transition z-10 play-overlay">
                            <div class="w-14 h-14 bg-white/90 rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-fuchsia-600 ml-1" fill="currentColor" viewBox="0 0 24 24">
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

                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="font-bold text-lg text-gray-800 mb-2 serif line-clamp-2" title="{{ $video->title }}">
                            {{ $video->title }}
                        </h3>
                        
                        <p class="text-gray-500 text-sm line-clamp-3 leading-relaxed">
                            {{ $video->description ?? 'Tidak ada deskripsi tersedia.' }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>

            @if($videos->isEmpty())
                <div class="text-center py-10">
                    <p class="text-gray-400 italic">Belum ada video tutorial yang diunggah.</p>
                </div>
            @endif

            <div class="text-center mt-12 md:mt-16">
                 <a href="{{ route('tutorials.all') }}" class="inline-block bg-fuchsia-500 hover:bg-fuchsia-600 text-white font-bold py-3 px-10 rounded-full shadow-lg transition transform hover:scale-105">
                    Lihat Semua Video
                 </a>
            </div>
        </div>
    </section>

    {{-- SCRIPTS --}}
    <script>
        function playVideo(element) {
            const video = element.querySelector('video');
            const overlay = element.querySelector('.play-overlay');
            
            if (video.paused) {
                document.querySelectorAll('video').forEach(v => {
                    if(v !== video) v.pause();
                });
                
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

        function openGallery() {
            const input = document.getElementById('evidenceInput');
            input.removeAttribute('capture'); 
            input.click();
        }

        function openCamera() {
            const input = document.getElementById('evidenceInput');
            input.setAttribute('capture', 'environment'); 
            input.click();
        }

        function previewFile() {
            const input = document.getElementById('evidenceInput');
            const preview = document.getElementById('filePreview');
            const fileName = document.getElementById('fileName');

            if (input.files && input.files[0]) {
                fileName.textContent = input.files[0].name;
                preview.classList.remove('hidden');
                preview.classList.add('flex');
            }
        }

        function resetFile() {
            const input = document.getElementById('evidenceInput');
            const preview = document.getElementById('filePreview');
            
            input.value = ''; 
            preview.classList.add('hidden');
        }
    </script>

</x-app-layout>
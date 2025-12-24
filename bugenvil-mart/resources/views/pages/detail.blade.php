<x-app-layout>
    {{-- Style Khusus --}}
    <style>
        .rate { float: left; height: 46px; padding: 0 10px; }
        .rate:not(:checked) > input { position:absolute; top:-9999px; }
        .rate:not(:checked) > label { float:right; width:1em; overflow:hidden; white-space:nowrap; cursor:pointer; font-size:30px; color:#ccc; }
        .rate:not(:checked) > label:before { content: '★ '; }
        .rate > input:checked ~ label { color: #ffc700; }
        
        /* Transisi gambar */
        #mainImage { transition: opacity 0.3s ease-in-out; }
        .opacity-0 { opacity: 0; }
        .opacity-100 { opacity: 1; }

        /* Hide scrollbar for cleaner look in gallery if needed */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    <div class="bg-gray-50 min-h-screen py-8 md:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Breadcrumb --}}
            <nav class="flex text-sm text-gray-500 mb-6 md:mb-8 overflow-x-auto whitespace-nowrap pb-2">
                <a href="{{ route('home') }}" class="hover:text-fuchsia-600 transition">Beranda</a> 
                <span class="mx-2">/</span> 
                <a href="{{ route('products.index') }}" class="hover:text-fuchsia-600 transition">Produk</a>
                <span class="mx-2">/</span>
                <span class="text-gray-800 font-bold truncate">{{ $product->name }}</span>
            </nav>

            {{-- Alert Messages --}}
            @if(session('success'))
                <div class="rounded-xl bg-green-50 border border-green-200 text-green-700 p-4 mb-6 flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
            @endif
            @if(session('error'))
                <div class="rounded-xl bg-red-50 border border-red-200 text-red-700 p-4 mb-6 flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    <p class="text-sm font-medium">{{ session('error') }}</p>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-0 md:gap-12 p-0 md:p-8">
                    
                    {{-- === BAGIAN KIRI: GALERI FOTO === --}}
                    {{-- Di Desktop, bagian ini akan Sticky agar tetap terlihat saat scroll --}}
                    <div class="space-y-4 md:sticky md:top-24 md:self-start h-fit p-4 md:p-0">
                        
                        {{-- 1. FOTO UTAMA --}}
                        <div class="aspect-square w-full bg-gray-100 rounded-2xl overflow-hidden relative group border border-gray-200">
                            {{-- Logic Gambar --}}
                            @if($product->image)
                                <img id="mainImage" src="{{ asset('storage/' . $product->image) }}" 
                                     class="w-full h-full object-cover cursor-zoom-in" 
                                     alt="{{ $product->name }}">
                            @elseif($product->images->count() > 0)
                                <img id="mainImage" src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                                     class="w-full h-full object-cover cursor-zoom-in" 
                                     alt="{{ $product->name }}">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                                    <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="text-sm">No Image</span>
                                </div>
                            @endif
                            
                            {{-- Badge --}}
                            @if($product->stock <= 0)
                                <span class="absolute top-4 left-4 bg-red-500/90 backdrop-blur-sm text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-sm">Habis</span>
                            @else
                                <span class="absolute top-4 left-4 bg-orange-500/90 backdrop-blur-sm text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-sm">Terlaris</span>
                            @endif
                        </div>

                        {{-- 2. THUMBNAIL (Scrollable on Mobile) --}}
                        @if($product->images->count() > 0)
                        <div class="flex md:grid md:grid-cols-5 gap-3 overflow-x-auto md:overflow-visible pb-2 md:pb-0 no-scrollbar">
                            {{-- Loop Gambar --}}
                            @foreach($product->images as $img)
                                <button onclick="changeMainImage('{{ asset('storage/' . $img->image_path) }}')"
                                        class="flex-shrink-0 w-20 h-20 md:w-auto md:h-auto aspect-square rounded-xl overflow-hidden border-2 border-transparent hover:border-fuchsia-500 focus:border-fuchsia-500 transition-all">
                                    <img src="{{ asset('storage/' . $img->image_path) }}" 
                                         class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    {{-- === BAGIAN KANAN: INFO PRODUK === --}}
                    {{-- Hapus 'justify-center' agar teks rata atas (Top Alignment) --}}
                    <div class="flex flex-col p-6 md:p-0 pt-0 md:pt-2">
                        
                        <h1 class="text-2xl md:text-4xl font-extrabold text-gray-900 mb-2 leading-tight tracking-tight">{{ $product->name }}</h1>
                        
                        {{-- Rating & Stats --}}
                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 mb-6 md:mb-8">
                            <div class="flex items-center gap-1.5 text-yellow-400 bg-yellow-50 px-2 py-1 rounded-lg">
                                <span class="text-yellow-500 font-bold text-base">{{ number_format($product->reviews_avg_rating ?? 0, 1) }}</span>
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            </div>
                            <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                            <span>{{ $product->reviews_count }} Ulasan</span>
                            <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                            <span class="text-fuchsia-600 font-medium">{{ $product->stock }} Stok Tersedia</span>
                        </div>

                        {{-- Harga --}}
                        <div class="mb-6 md:mb-8">
                            <span class="text-3xl md:text-5xl font-bold text-fuchsia-600 tracking-tight">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="prose prose-sm md:prose-base text-gray-600 mb-8 md:mb-10 leading-relaxed max-w-none">
                            <p>{{ $product->description }}</p>
                        </div>

                        {{-- Actions Area (Sticky Bottom on Mobile, Regular on Desktop) --}}
                        <div class="mt-auto pt-6 border-t border-gray-100">
                            @if($product->stock > 0)
                                <div class="flex flex-col sm:flex-row gap-3 md:gap-4">
                                    {{-- Keranjang (Hanya User) --}}
                                    @if(!Auth::check() || (Auth::check() && !Auth::user()->is_admin))
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit" class="w-full py-3.5 px-6 rounded-xl border-2 border-fuchsia-100 bg-white text-fuchsia-700 font-bold hover:border-fuchsia-600 hover:bg-fuchsia-50 transition-all flex items-center justify-center gap-2 group">
                                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                                + Keranjang
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                                            @csrf
                                            <input type="hidden" name="redirect_checkout" value="1"> 
                                            <button type="submit" class="w-full py-3.5 px-6 rounded-xl bg-gradient-to-r from-fuchsia-600 to-purple-600 text-white font-bold shadow-lg shadow-fuchsia-200 hover:shadow-xl hover:translate-y-[-2px] transition-all flex items-center justify-center">
                                                Beli Sekarang
                                            </button>
                                        </form>
                                    @else
                                        <div class="w-full bg-gray-100 text-gray-400 py-4 text-center rounded-xl font-medium border border-gray-200">
                                            Mode Admin (Hanya Lihat)
                                        </div>
                                    @endif
                                </div>
                            @else
                                <button disabled class="w-full bg-gray-100 text-gray-400 py-4 rounded-xl font-bold cursor-not-allowed">
                                    Stok Habis
                                </button>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

            {{-- REVIEW SECTION --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-10 mb-10">
                <h3 class="text-2xl font-bold text-gray-900 mb-8 flex items-center gap-2">
                    <span>Ulasan Pembeli</span>
                    <span class="text-sm font-normal text-gray-500 bg-gray-100 px-3 py-1 rounded-full">{{ $product->reviews_count }}</span>
                </h3>
                
                {{-- Form Review --}}
                @if(Auth::check() && !Auth::user()->is_admin)
                <div class="bg-gray-50/80 backdrop-blur rounded-2xl p-6 mb-10 border border-gray-200">
                    <h4 class="font-bold text-gray-800 mb-4">Tulis Ulasan Anda</h4>
                    <form action="{{ route('reviews.store', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="flex flex-col md:flex-row gap-6">
                            {{-- Input Kiri --}}
                            <div class="flex-1 space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-1">Berikan Bintang</label>
                                    <div class="rate bg-white px-2 rounded-lg border border-gray-200 inline-block h-10">
                                        <input type="radio" id="star5" name="rating" value="5" /><label for="star5">5 stars</label>
                                        <input type="radio" id="star4" name="rating" value="4" /><label for="star4">4 stars</label>
                                        <input type="radio" id="star3" name="rating" value="3" /><label for="star3">3 stars</label>
                                        <input type="radio" id="star2" name="rating" value="2" /><label for="star2">2 stars</label>
                                        <input type="radio" id="star1" name="rating" value="1" /><label for="star1">1 star</label>
                                    </div>
                                    @error('rating') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-1">Foto (Opsional)</label>
                                    <input type="file" name="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-fuchsia-50 file:text-fuchsia-700 hover:file:bg-fuchsia-100"/>
                                </div>
                            </div>
                            
                            {{-- Input Kanan --}}
                            <div class="flex-1 flex flex-col">
                                <label class="block text-sm font-medium text-gray-600 mb-1">Komentar</label>
                                <textarea name="comment" rows="3" class="w-full border-gray-200 rounded-xl focus:ring-fuchsia-500 focus:border-fuchsia-500 flex-grow" placeholder="Ceritakan kepuasan Anda tentang produk ini..."></textarea>
                                <div class="mt-4 text-right">
                                    <button type="submit" class="bg-gray-900 text-white px-8 py-2.5 rounded-xl font-bold hover:bg-black transition shadow-lg">
                                        Kirim Ulasan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                @endif

                {{-- List Review --}}
                <div class="space-y-8">
                    @forelse($product->reviews as $review)
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-fuchsia-100 to-purple-100 flex items-center justify-center text-fuchsia-600 font-bold text-lg">
                                {{ substr($review->user->name, 0, 1) }}
                            </div>
                        </div>
                        <div class="flex-grow">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h5 class="font-bold text-gray-900">{{ $review->user->name }}</h5>
                                    <div class="flex text-yellow-400 text-sm my-1">
                                        @for($i=1; $i<=5; $i++)
                                            @if($i <= $review->rating) ★ @else <span class="text-gray-200">★</span> @endif
                                        @endfor
                                    </div>
                                </div>
                                <span class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-gray-600 mt-2 leading-relaxed">{{ $review->comment }}</p>
                            @if($review->image)
                                <img src="{{ asset('storage/' . $review->image) }}" class="mt-3 w-24 h-24 object-cover rounded-xl border border-gray-100">
                            @endif
                        </div>
                    </div>
                    @if(!$loop->last) <hr class="border-gray-100 my-6"> @endif
                    @empty
                    <div class="text-center py-12 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                        <p class="text-gray-500">Belum ada ulasan untuk produk ini.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- RELATED PRODUCTS --}}
            <div class="mb-20">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-2xl font-bold text-gray-900">Produk Serupa</h3>
                    <a href="{{ route('products.index') }}" class="text-fuchsia-600 font-semibold hover:underline">Lihat Semua &rarr;</a>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-8">
                    @foreach($relatedProducts as $related)
                    <a href="{{ route('products.show', $related->id) }}" class="group bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                        <div class="aspect-[4/5] bg-gray-100 overflow-hidden relative">
                            @if($related->image)
                                <img src="{{ asset('storage/' . $related->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @elseif($related->images->count() > 0)
                                <img src="{{ asset('storage/' . $related->images->first()->image_path) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">No Image</div>
                            @endif
                            
                            {{-- Quick Add Button (Visible on Hover Desktop) --}}
                            <div class="absolute bottom-0 left-0 right-0 p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300 hidden md:block">
                                <div class="bg-white/90 backdrop-blur text-center py-2 rounded-lg text-sm font-bold text-gray-800 shadow-sm">
                                    Lihat Detail
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <h4 class="font-bold text-gray-800 mb-1 truncate group-hover:text-fuchsia-600 transition">{{ $related->name }}</h4>
                            <p class="text-fuchsia-600 font-bold">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    <script>
        function changeMainImage(src) {
            const mainImage = document.getElementById('mainImage');
            mainImage.classList.add('opacity-0');
            setTimeout(() => {
                mainImage.src = src;
                mainImage.classList.remove('opacity-0');
            }, 300);
        }
    </script>
</x-app-layout>
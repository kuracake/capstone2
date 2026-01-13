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

        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* Custom Scrollbar for Textarea */
        textarea::-webkit-scrollbar { width: 6px; }
        textarea::-webkit-scrollbar-track { background: #f8f8f8; }
        textarea::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }
    </style>

    <div class="bg-gray-50 min-h-screen py-8 md:py-12" x-data="whatsappOrder()">
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
                    <div class="space-y-4 md:sticky md:top-24 md:self-start h-fit p-4 md:p-0">
                        {{-- 1. FOTO UTAMA --}}
                        <div class="aspect-square w-full bg-gray-100 rounded-2xl overflow-hidden relative group border border-gray-200">
                            @if($product->image)
                                <img id="mainImage" src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover cursor-zoom-in" alt="{{ $product->name }}">
                            @elseif($product->images->count() > 0)
                                <img id="mainImage" src="{{ asset('storage/' . $product->images->first()->image_path) }}" class="w-full h-full object-cover cursor-zoom-in" alt="{{ $product->name }}">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                                    <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="text-sm">No Image</span>
                                </div>
                            @endif
                            @if($product->stock <= 0)
                                <span class="absolute top-4 left-4 bg-red-500/90 backdrop-blur-sm text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-sm">Habis</span>
                            @else
                                <span class="absolute top-4 left-4 bg-orange-500/90 backdrop-blur-sm text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-sm">Terlaris</span>
                            @endif
                        </div>

                        {{-- 2. THUMBNAIL --}}
                        @if($product->images->count() > 0)
                        <div class="flex md:grid md:grid-cols-5 gap-3 overflow-x-auto md:overflow-visible pb-2 md:pb-0 no-scrollbar">
                            @foreach($product->images as $img)
                                <button onclick="changeMainImage('{{ asset('storage/' . $img->image_path) }}')"
                                        class="flex-shrink-0 w-20 h-20 md:w-auto md:h-auto aspect-square rounded-xl overflow-hidden border-2 border-transparent hover:border-fuchsia-500 focus:border-fuchsia-500 transition-all">
                                    <img src="{{ asset('storage/' . $img->image_path) }}" class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    {{-- === BAGIAN KANAN: INFO PRODUK === --}}
                    <div class="flex flex-col p-6 md:p-0 pt-0 md:pt-2">
                        
                        <h1 class="text-2xl md:text-4xl font-extrabold text-gray-900 mb-2 leading-tight tracking-tight">{{ $product->name }}</h1>
                        
                        {{-- Rating & Stats --}}
                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 mb-6 md:mb-8">
                            <div class="flex items-center gap-1.5 text-yellow-500 font-bold text-base">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span>{{ number_format($product->reviews_avg_rating ?? 0, 1) }}</span>
                                <span class="text-gray-400 font-normal text-sm">({{ $product->reviews_count }} Ulasan)</span>
                            </div>
                            <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                            <span class="text-gray-800 font-medium">Terjual {{ $product->order_items_sum_quantity ?? 0 }}</span>
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

                        {{-- Actions Area --}}
                        <div class="mt-auto pt-6 border-t border-gray-100">
                            @if($product->stock > 0)
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-4">
                                    @if(!Auth::check() || (Auth::check() && !Auth::user()->is_admin))
                                        
                                        {{-- 1. Tombol Keranjang --}}
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="w-full">
                                            @csrf
                                            <button type="submit" class="w-full py-3.5 px-6 rounded-xl border-2 border-fuchsia-100 bg-white text-fuchsia-700 font-bold hover:border-fuchsia-600 hover:bg-fuchsia-50 transition-all flex items-center justify-center gap-2 group h-full">
                                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                                <span class="whitespace-nowrap">+ Keranjang</span>
                                            </button>
                                        </form>
                                        
                                        {{-- 2. Tombol Beli Sekarang --}}
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="w-full">
                                            @csrf
                                            <input type="hidden" name="redirect_checkout" value="1"> 
                                            <button type="submit" class="w-full py-3.5 px-6 rounded-xl bg-gradient-to-r from-fuchsia-600 to-purple-600 text-white font-bold shadow-lg shadow-fuchsia-200 hover:shadow-xl hover:translate-y-[-2px] transition-all flex items-center justify-center h-full">
                                                Beli Sekarang
                                            </button>
                                        </form>

                                        {{-- 3. Tombol WhatsApp (FIXED) --}}
                                        <button @click="openModal = true" 
                                                class="w-full py-3.5 px-6 rounded-xl text-white font-bold shadow-lg shadow-green-200 hover:shadow-xl hover:translate-y-[-2px] transition-all flex items-center justify-center gap-2 h-full sm:col-span-2 lg:col-span-1"
                                                style="background-color: #25D366;">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                            <span class="whitespace-nowrap">Via WhatsApp</span>
                                        </button>

                                    @else
                                        <div class="w-full col-span-1 sm:col-span-2 lg:col-span-3 bg-gray-100 text-gray-400 py-4 text-center rounded-xl font-medium border border-gray-200">
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
                
                @if(Auth::check() && !Auth::user()->is_admin)
                <div class="bg-gray-50/80 backdrop-blur rounded-2xl p-6 mb-10 border border-gray-200">
                    <h4 class="font-bold text-gray-800 mb-4">Tulis Ulasan Anda</h4>
                    <form action="{{ route('reviews.store', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="flex flex-col md:flex-row gap-6">
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
                            <div class="absolute bottom-0 left-0 right-0 p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300 hidden md:block">
                                <div class="bg-white/90 backdrop-blur text-center py-2 rounded-lg text-sm font-bold text-gray-800 shadow-sm">
                                    Lihat Detail
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <h4 class="font-bold text-gray-800 mb-1 truncate group-hover:text-fuchsia-600 transition">{{ $related->name }}</h4>
                            <div class="flex items-center gap-1 mb-2 text-xs text-gray-500">
                                <svg class="w-3 h-3 text-yellow-500 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                <span>{{ number_format($related->reviews_avg_rating ?? 0, 1) }}</span>
                                <span class="mx-1">•</span>
                                <span>Terjual {{ $related->order_items_sum_quantity ?? 0 }}</span>
                            </div>
                            <p class="text-fuchsia-600 font-bold">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- === MODAL FORM WHATSAPP (COMPACT & CLEAN) === --}}
            <div x-show="openModal" 
                 style="display: none; z-index: 9999;"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 z-[9999] flex items-center justify-center p-4">
                
                {{-- Backdrop --}}
                <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="openModal = false"></div>

                {{-- Modal Container (Max Width Small = 384px) --}}
                <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden transform transition-all flex flex-col max-h-[90vh]">
                    
                    {{-- Tombol Close --}}
                    <button @click="openModal = false" class="absolute top-3 right-3 z-10 p-1.5 bg-white/80 hover:bg-gray-100 rounded-full text-gray-400 hover:text-red-500 transition shadow-sm border border-gray-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>

                    {{-- Header Update --}}
                    <div class="px-5 py-4 border-b border-gray-100">
                        <h3 class="text-xl font-bold text-fuchsia-600 text-center">
                            Ainin Ar Store
                        </h3>
                    </div>

                    {{-- Body Form --}}
                    <div class="p-5 overflow-y-auto custom-scrollbar">
                        
                        {{-- Ringkasan Produk Compact --}}
                        <div class="bg-gray-50 border border-gray-100 rounded-lg p-2.5 mb-5 flex items-center gap-3">
                            <div class="w-12 h-12 bg-white rounded-md overflow-hidden flex-shrink-0 border border-gray-200">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                                @elseif($product->images->count() > 0)
                                    <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">IMG</div>
                                @endif
                            </div>
                            <div class="flex-grow">
                                <h4 class="font-bold text-gray-800 text-sm line-clamp-1">{{ $product->name }}</h4>
                                <p class="text-fuchsia-600 font-bold text-xs">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        {{-- Form Inputs Compact --}}
                        <div class="space-y-3">
                            
                            {{-- Nama --}}
                            <div>
                                <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1 block">Nama Penerima <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="text" x-model="waName" placeholder="Nama Lengkap" class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 focus:border-green-500 focus:ring-green-500 transition-all placeholder-gray-400">
                                </div>
                            </div>

                            {{-- Grid: WA & Jumlah --}}
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1 block">WhatsApp <span class="text-red-500">*</span></label>
                                    <input type="tel" x-model="waPhone" placeholder="08xxx" class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 focus:border-green-500 focus:ring-green-500 transition-all placeholder-gray-400">
                                </div>
                                <div>
                                    <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1 block">Jumlah <span class="text-red-500">*</span></label>
                                    <input type="number" x-model="waQty" min="1" max="{{ $product->stock }}" class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 focus:border-green-500 focus:ring-green-500 transition-all text-center">
                                </div>
                            </div>

                            {{-- Alamat --}}
                            <div>
                                <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1 block">Alamat Kirim <span class="text-red-500">*</span></label>
                                <textarea x-model="waAddress" rows="2" placeholder="Provinsi, Kota/Kabupaten, Kecamatan, Desa, Nama jalan Lengkap" class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 focus:border-green-500 focus:ring-green-500 transition-all placeholder-gray-400 resize-none"></textarea>
                            </div>

                            {{-- Pesan --}}
                            <div>
                                <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1 block">Catatan (Opsional)</label>
                                <input type="text" x-model="waMessage" class="w-full px-3 py-2 text-sm rounded-lg border border-gray-300 focus:border-green-500 focus:ring-green-500 transition-all placeholder-gray-400">
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="mt-6">
                            <button @click="sendWhatsApp" 
                                    :disabled="!waName || !waPhone || !waAddress || !waQty"
                                    :class="{'opacity-60 cursor-not-allowed transform-none': !waName || !waPhone || !waAddress || !waQty}"
                                    class="w-full text-white font-bold py-2.5 rounded-lg shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 transform hover:-translate-y-0.5 active:translate-y-0 text-sm"
                                    style="background-color: #25D366;">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                <span class="text-sm">Kirim Pesan</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Script Logic --}}
    <script>
        function changeMainImage(src) {
            const mainImage = document.getElementById('mainImage');
            mainImage.classList.add('opacity-0');
            setTimeout(() => {
                mainImage.src = src;
                mainImage.classList.remove('opacity-0');
            }, 300);
        }

        document.addEventListener('alpine:init', () => {
            Alpine.data('whatsappOrder', () => ({
                openModal: false,
                waName: '{{ Auth::user()->name ?? "" }}',
                waPhone: '{{ Auth::user()->phone ?? "" }}',
                waAddress: `{{ Auth::check() && Auth::user()->addresses->first() ? implode(', ', array_filter([Auth::user()->addresses->first()->address_detail, Auth::user()->addresses->first()->village_name, Auth::user()->addresses->first()->district_name, Auth::user()->addresses->first()->city_name, Auth::user()->addresses->first()->province_name])) : "" }}`,
                waQty: 1,
                waMessage: '',
                productName: '{{ addslashes($product->name) }}',
                productPrice: 'Rp {{ number_format($product->price, 0, ',', '.') }}',
                
                sendWhatsApp() {
                    // Membuat pesan WA dengan format terstruktur (\n untuk baris baru)
                    let message = `Halo Admin Ainin Ar Store\n\n`;
                    
                    message += `Saya ingin memesan produk ini:\n`;
                    message += `*${this.productName}*\n`;
                    message += `Harga: ${this.productPrice}\n`;
                    message += `Jumlah: ${this.waQty} pcs\n\n`;
                    
                    message += `--------------------------------\n`;
                    message += `*Data Pemesan:*\n`;
                    message += `Nama: ${this.waName}\n`;
                    message += `WA: ${this.waPhone}\n`;
                    message += `Alamat: ${this.waAddress}\n`;
                    
                    if(this.waMessage) {
                        message += `Catatan: ${this.waMessage}\n`;
                    }
                    
                    message += `--------------------------------\n\n`;
                    message += `Mohon info total bayar beserta ongkirnya ya kak. Terima kasih!`;

                    // Encode pesan agar URL valid
                    const encodedMessage = encodeURIComponent(message);
                    const whatsappUrl = `https://wa.me/6287860050339?text=${encodedMessage}`;
                    
                    window.open(whatsappUrl, '_blank');
                    this.openModal = false;
                }
            }));
        });
    </script>
</x-app-layout>
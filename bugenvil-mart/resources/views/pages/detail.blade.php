<x-app-layout>
    {{-- Tambahkan Style Khusus untuk Bintang --}}
    <style>
        .rate { float: left; height: 46px; padding: 0 10px; }
        .rate:not(:checked) > input { position:absolute; top:-9999px; }
        .rate:not(:checked) > label { float:right; width:1em; overflow:hidden; white-space:nowrap; cursor:pointer; font-size:30px; color:#ccc; }
        .rate:not(:checked) > label:before { content: '★ '; }
        .rate > input:checked ~ label { color: #ffc700; }
        .rate:not(:checked) > label:hover,
        .rate:not(:checked) > label:hover ~ label { color: #deb217; }
        .rate > input:checked + label:hover,
        .rate > input:checked + label:hover ~ label,
        .rate > input:checked ~ label:hover,
        .rate > input:checked ~ label:hover ~ label,
        .rate > label:hover ~ input:checked ~ label { color: #c59b08; }
    </style>

    <div class="bg-gray-50 min-h-screen py-10">
        <div class="container mx-auto px-6">
            
            {{-- Breadcrumb --}}
            <div class="text-sm text-gray-500 mb-6 flex items-center gap-2">
                <a href="{{ route('home') }}" class="hover:text-fuchsia-600">Beranda</a> 
                <span>/</span> 
                <a href="{{ route('products.index') }}" class="hover:text-fuchsia-600">Produk</a>
                <span>/</span>
                <span class="text-gray-800 font-bold truncate max-w-xs">{{ $product->name }}</span>
            </div>

            {{-- Pesan Sukses/Eror --}}
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    
                    {{-- Galeri Foto --}}
                    <div class="space-y-4">
                        <div class="border border-gray-200 rounded-lg overflow-hidden relative group">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     class="w-full h-96 object-cover transform group-hover:scale-110 transition duration-500 cursor-zoom-in" 
                                     alt="{{ $product->name }}">
                            @else
                                <div class="w-full h-96 bg-gray-200 flex items-center justify-center text-gray-400">No Image</div>
                            @endif
                            
                            {{-- Badge Random --}}
                            <span class="absolute top-4 left-4 bg-orange-500 text-white text-xs font-bold px-3 py-1 rounded">Terlaris</span>
                        </div>
                    </div>

                    {{-- Info Produk --}}
                    <div class="flex flex-col">
                        <h1 class="text-3xl font-bold text-gray-800 mb-2 leading-tight">{{ $product->name }}</h1>
                        
                        {{-- RATING ASLI DARI DATABASE --}}
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-6">
                            <div class="flex items-center gap-1 text-fuchsia-600 border-r border-gray-300 pr-4">
                                <span class="font-bold underline text-lg">
                                    {{ number_format($product->reviews_avg_rating ?? 0, 1) }}
                                </span>
                                <div class="flex text-sm text-yellow-400">
                                    @for($i=1; $i<=5; $i++)
                                        @if($i <= round($product->reviews_avg_rating)) ★ @else ☆ @endif
                                    @endfor
                                </div>
                            </div>
                            <div class="flex items-center gap-1 border-r border-gray-300 pr-4">
                                <span class="font-bold text-gray-800 text-lg">{{ $product->reviews_count }}</span>
                                <span>Penilaian</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="font-bold text-gray-800 text-lg">{{ rand(50, 200) }}</span>
                                <span>Terjual</span>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg mb-6 flex items-center gap-3">
                            <span class="text-4xl font-bold text-fuchsia-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>

                        <div class="mb-6 space-y-3">
                            <p class="text-gray-600">{{ $product->description }}</p>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="flex gap-4 mt-auto">
                            @if(!Auth::check() || (Auth::check() && !Auth::user()->is_admin))
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full border-2 border-fuchsia-600 bg-fuchsia-50 text-fuchsia-600 font-bold py-3 px-6 rounded-lg hover:bg-fuchsia-100 transition flex items-center justify-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        Masukkan Keranjang
                                    </button>
                                </form>
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" onclick="setTimeout(function(){ window.location.href='{{ route('checkout') }}'; }, 500);" class="w-full bg-fuchsia-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-fuchsia-700 transition flex items-center justify-center shadow-lg transform active:scale-95">
                                        Beli Sekarang
                                    </button>
                                </form>
                            @else
                                <div class="w-full bg-gray-200 text-gray-500 py-3 text-center rounded-lg cursor-not-allowed font-bold">
                                    Login sebagai User untuk membeli
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION REVIEW & PENILAIAN --}}
            <div class="bg-white rounded-xl shadow-sm p-8 mb-8">
                <h3 class="text-xl font-bold text-gray-800 mb-6">Penilaian Produk</h3>
                
                {{-- Form Input Review (Hanya muncul jika login dan user bukan admin) --}}
                @if(Auth::check() && !Auth::user()->is_admin)
                <div class="bg-gray-50 p-6 rounded-xl mb-8 border border-gray-200">
                    <h4 class="font-bold text-gray-700 mb-2">Berikan Penilaian Anda</h4>
                    <form action="{{ route('reviews.store', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        {{-- Bintang Rating --}}
                        <div class="mb-4">
                            <div class="rate">
                                <input type="radio" id="star5" name="rating" value="5" />
                                <label for="star5" title="text">5 stars</label>
                                <input type="radio" id="star4" name="rating" value="4" />
                                <label for="star4" title="text">4 stars</label>
                                <input type="radio" id="star3" name="rating" value="3" />
                                <label for="star3" title="text">3 stars</label>
                                <input type="radio" id="star2" name="rating" value="2" />
                                <label for="star2" title="text">2 stars</label>
                                <input type="radio" id="star1" name="rating" value="1" />
                                <label for="star1" title="text">1 star</label>
                            </div>
                            <div class="clearfix"></div>
                            @error('rating') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        {{-- Komentar --}}
                        <div class="mb-4">
                            <textarea name="comment" rows="3" class="w-full border-gray-300 rounded-lg focus:ring-fuchsia-500 focus:border-fuchsia-500" placeholder="Bagaimana kualitas produk ini? Ceritakan pengalaman Anda..."></textarea>
                            @error('comment') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        {{-- Upload Foto --}}
                        <div class="flex justify-between items-center">
                            <div>
                                <input type="file" name="image" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-fuchsia-50 file:text-fuchsia-700 hover:file:bg-fuchsia-100"/>
                                @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <button type="submit" class="bg-fuchsia-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-fuchsia-700 transition">
                                Kirim Penilaian
                            </button>
                        </div>
                    </form>
                </div>
                @endif

                {{-- Daftar Review --}}
                <div class="space-y-6">
                    @forelse($product->reviews as $review)
                    <div class="border-b border-gray-100 pb-6">
                        <div class="flex items-start gap-4">
                            {{-- Avatar User --}}
                            <div class="flex-shrink-0">
                                @if($review->user->avatar)
                                    <img src="{{ asset('storage/' . $review->user->avatar) }}" class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold">
                                        {{ substr($review->user->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>

                            <div class="flex-grow">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h5 class="font-bold text-gray-800 text-sm">{{ $review->user->name }}</h5>
                                        <div class="flex text-yellow-400 text-xs mb-1">
                                            @for($i=1; $i<=5; $i++)
                                                @if($i <= $review->rating) ★ @else ☆ @endif
                                            @endfor
                                        </div>
                                    </div>
                                    {{-- Menggunakan diffForHumans() agar muncul "2 menit yang lalu" --}}
<span class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                                
                                <p class="text-gray-600 text-sm mt-1">{{ $review->comment }}</p>
                                
                                @if($review->image)
                                    <div class="mt-3">
                                        <img src="{{ asset('storage/' . $review->image) }}" class="w-24 h-24 object-cover rounded-lg border border-gray-200 cursor-zoom-in">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <p class="text-gray-500 italic">Belum ada penilaian untuk produk ini.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Produk Serupa (Tetap ada) --}}
            <div class="mt-12">
                <h3 class="text-2xl font-bold text-gray-800 mb-6">Produk Lainnya</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $related)
                    <a href="{{ route('products.show', $related->id) }}" class="bg-white rounded-2xl shadow hover:shadow-xl transition overflow-hidden group border border-transparent hover:border-fuchsia-300">
                        <div class="relative h-48 bg-gray-200">
                            @if($related->image)
                                <img src="{{ asset('storage/' . $related->image) }}" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">No Image</div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h4 class="font-bold text-gray-800 mb-1 truncate">{{ $related->name }}</h4>
                            <p class="text-fuchsia-600 font-bold">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
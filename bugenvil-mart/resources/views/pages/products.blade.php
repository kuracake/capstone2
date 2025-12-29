<x-app-layout>
    {{-- 1. HERO HEADER --}}
    <div class="bg-fuchsia-900 py-12 md:py-20 relative overflow-hidden">
        {{-- Dekorasi Latar Belakang --}}
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full translate-x-1/2 -translate-y-1/2 blur-2xl"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full -translate-x-1/2 translate-y-1/2 blur-2xl"></div>
        
        <div class="container mx-auto px-6 text-center relative z-10">
            <h1 class="text-3xl md:text-5xl font-bold text-white mb-2 md:mb-4 font-serif tracking-wide">
                Koleksi Bougenville
            </h1>
            <p class="text-fuchsia-100 max-w-2xl mx-auto text-sm md:text-lg font-light leading-relaxed">
                Temukan varietas bugenvil terbaik untuk mempercantik taman Anda.
            </p>
        </div>
    </div>

    {{-- 2. KONTEN UTAMA --}}
    <div class="py-8 md:py-16 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 md:px-6">
            
            {{-- TOOLBAR: PENCARIAN & FILTER --}}
            <div class="bg-white p-4 md:p-5 rounded-2xl shadow-sm border border-gray-100 mb-8 md:mb-10">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    
                    {{-- Kiri: Info Jumlah Produk --}}
                    <p class="text-gray-500 text-xs md:text-sm font-medium order-2 md:order-1">
                        Menampilkan <span class="text-fuchsia-600 font-bold">{{ $products->total() }}</span> produk
                    </p>

                    {{-- Kanan: Form Search & Filter --}}
                    <form method="GET" action="{{ route('products.index') }}" class="w-full md:w-auto flex flex-col sm:flex-row gap-3 order-1 md:order-2">
                        
                        {{-- Input Pencarian --}}
                        <div class="relative w-full sm:w-64 text-gray-500 focus-within:text-fuchsia-600 transition-colors duration-200">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Cari tanaman..." 
                                   class="w-full pl-4 pr-10 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-fuchsia-500 focus:ring-fuchsia-500 bg-gray-50 focus:bg-white transition-all placeholder-gray-400">
                            
                            <button type="submit" class="absolute inset-y-0 right-0 pr-4 flex items-center cursor-pointer hover:text-fuchsia-700 transition-colors focus:outline-none" title="Cari">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </button>
                        </div>

                        {{-- Select Filter --}}
                        <div class="relative w-full sm:w-48">
                            <select name="filter" onchange="this.form.submit()" class="w-full pl-4 pr-10 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-fuchsia-500 focus:ring-fuchsia-500 bg-gray-50 cursor-pointer transition-colors text-gray-600 hover:bg-gray-100">
                                <option value="terbaru" {{ request('filter') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                <option value="termurah" {{ request('filter') == 'termurah' ? 'selected' : '' }}>Harga Terendah</option>
                                <option value="terlaris" {{ request('filter') == 'terlaris' ? 'selected' : '' }}>Paling Laris</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            {{-- GRID PRODUK --}}
            @if($products->isEmpty())
                <div class="text-center py-20 bg-white rounded-3xl border border-gray-100 shadow-sm">
                    {{-- Empty State Content --}}
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-1">Produk Tidak Ditemukan</h3>
                    <p class="text-gray-500 text-sm">Coba kata kunci lain atau reset filter pencarian Anda.</p>
                    <a href="{{ route('products.index') }}" class="inline-block mt-4 px-6 py-2 bg-fuchsia-50 text-fuchsia-600 rounded-full font-bold text-sm hover:bg-fuchsia-100 transition">
                        Reset Pencarian
                    </a>
                </div>
            @else
                {{-- Grid Responsif --}}
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-6 lg:gap-8">
                    @foreach($products as $product)
                    <div class="bg-white rounded-xl md:rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col h-full group overflow-hidden">
                        
                        {{-- Gambar Produk --}}
                        <a href="{{ route('products.show', $product->id) }}" class="relative aspect-square overflow-hidden block bg-gray-100">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300 text-xs md:text-sm">No Image</div>
                            @endif
                            
                            {{-- Badge Stok --}}
                            <div class="absolute top-2 right-2 md:top-3 md:right-3">
                                <span class="bg-white/95 backdrop-blur px-2 py-0.5 md:px-3 md:py-1 rounded-full text-[10px] md:text-xs font-bold text-fuchsia-700 shadow-sm uppercase tracking-wide">
                                    Stok: {{ $product->stock }}
                                </span>
                            </div>
                        </a>

                        {{-- Info Produk --}}
                        <div class="p-3 md:p-5 flex flex-col flex-grow">
                            {{-- Judul Produk --}}
                            <h3 class="text-sm md:text-lg font-bold text-gray-900 mb-1.5 font-serif group-hover:text-fuchsia-700 transition-colors line-clamp-2 leading-tight">
                                <a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a>
                            </h3>

                            {{-- === RATING & TERJUAL (BARU) === --}}
                            <div class="flex items-center gap-1.5 text-[11px] md:text-xs mb-3">
                                {{-- Bintang & Rating --}}
                                <div class="flex items-center text-yellow-500 font-bold">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <span class="ml-0.5">{{ number_format($product->reviews_avg_rating ?? 0, 1) }}</span>
                                </div>
                                
                                {{-- Jumlah Ulasan --}}
                                <span class="text-gray-400">({{ $product->reviews_count }})</span>

                                {{-- Divider --}}
                                <span class="text-gray-300">|</span>

                                {{-- Terjual --}}
                                <span class="text-gray-500">Terjual {{ $product->order_items_sum_quantity ?? 0 }}</span>
                            </div>
                            
                            {{-- Deskripsi (Desktop Only) --}}
                            <p class="hidden md:block text-gray-500 text-xs mb-4 line-clamp-2 leading-relaxed flex-grow">
                                {{ $product->description }}
                            </p>
                            
                            {{-- AREA HARGA & TOMBOL --}}
                            <div class="mt-auto pt-2 md:pt-4 md:border-t md:border-gray-50">
                                
                                {{-- Harga --}}
                                <div class="mb-3">
                                    <span class="text-base md:text-lg font-bold text-fuchsia-600">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                </div>

                                {{-- Baris Tombol --}}
                                <div class="flex items-center gap-2 w-full">
                                    
                                    {{-- 1. Tombol Keranjang --}}
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="shrink-0">
                                        @csrf
                                        <button type="submit" class="w-10 h-10 rounded-lg bg-fuchsia-50 text-fuchsia-600 border border-fuchsia-100 flex items-center justify-center hover:bg-fuchsia-600 hover:text-white transition-all shadow-sm" title="Tambah ke Keranjang">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 00-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        </button>
                                    </form>

                                    {{-- 2. Tombol Beli Langsung --}}
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-grow">
                                        @csrf
                                        <input type="hidden" name="redirect_checkout" value="1">
                                        <button type="submit" class="w-full h-10 rounded-lg bg-fuchsia-600 text-white font-bold text-xs md:text-sm hover:bg-fuchsia-700 transition-all shadow-md active:scale-95">
                                            Beli Sekarang
                                        </button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                {{-- Pagination --}}
                <div class="mt-12 md:mt-16">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
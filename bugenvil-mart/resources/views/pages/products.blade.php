<x-app-layout>
    {{-- Hero Section --}}
    <div class="bg-fuchsia-50 py-12">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-4xl font-bold text-fuchsia-800 mb-4 serif">Koleksi Bougenville</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Temukan varietas bugenvil terbaik hasil budidaya kami. Siap mempercantik taman dan halaman rumah Anda.
            </p>
        </div>
    </div>

    {{-- Product Grid --}}
    <div class="py-12 bg-white">
        <div class="container mx-auto px-6">
            
            {{-- Filter & Search Bar (Opsional, biar makin mantap) --}}
            <div class="flex justify-between items-center mb-8">
                <p class="text-gray-500">Menampilkan {{ $products->count() }} produk</p>
                <form method="GET" action="{{ route('products.index') }}" class="flex gap-2">
                    <select name="filter" onchange="this.form.submit()" class="border-gray-300 rounded-lg text-sm focus:ring-fuchsia-500 focus:border-fuchsia-500">
                        <option value="terbaru" {{ request('filter') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="termurah" {{ request('filter') == 'termurah' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="terlaris" {{ request('filter') == 'terlaris' ? 'selected' : '' }}>Harga Tertinggi</option>
                    </select>
                </form>
            </div>

            {{-- Jika produk kosong --}}
            @if($products->isEmpty())
                <div class="text-center py-20 bg-gray-50 rounded-xl">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <p class="text-gray-500 text-lg font-medium">Belum ada produk yang tersedia saat ini.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
                    @foreach($products as $product)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 border border-gray-100 flex flex-col h-full group">
                        
                        {{-- Gambar Produk (Klik menuju detail) --}}
                        <a href="{{ route('products.show', $product->id) }}" class="relative h-64 overflow-hidden block">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">No Image</div>
                            @endif
                            
                            {{-- Badge Stok --}}
                            <div class="absolute top-2 right-2">
                                <span class="bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-fuchsia-600 shadow-sm">
                                    Stok: {{ $product->stock }}
                                </span>
                            </div>
                        </a>

                        {{-- Info Produk --}}
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-xl font-bold text-gray-800 mb-2 serif hover:text-fuchsia-600 transition">
                                <a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a>
                            </h3>
                            <p class="text-gray-500 text-sm mb-4 line-clamp-2 flex-grow">
                                {{ $product->description }}
                            </p>
                            
                            <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-100">
                                <span class="text-lg font-bold text-fuchsia-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                
                                {{-- Tombol Tambah ke Keranjang (Sudah Diperbaiki) --}}
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-fuchsia-600 text-white p-2 rounded-lg hover:bg-fuchsia-700 transition shadow-md group-hover:scale-105" title="Tambah ke Keranjang">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 00-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                {{-- Pagination --}}
                <div class="mt-12">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
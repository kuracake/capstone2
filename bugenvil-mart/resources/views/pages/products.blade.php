<x-app-layout>
    <div class="bg-pink-50 min-h-screen py-24"> 
        <div class="container mx-auto px-6">
            
            <div class="text-center mb-16">
                <h1 class="text-4xl font-bold text-fuchsia-600 serif mb-4">Koleksi Lengkap Bugenvil</h1>
                <p class="text-gray-600 max-w-2xl mx-auto mb-8 text-lg">
                    Temukan berbagai jenis bunga Bugenvil berkualitas tinggi yang siap mempercantik taman rumah Anda.
                </p>
                
                <!-- PERBAIKAN: route('products.index') -->
                <form action="{{ route('products.index') }}" method="GET" class="max-w-md mx-auto flex gap-2 mb-10">
                    @if(request('filter'))
                        <input type="hidden" name="filter" value="{{ request('filter') }}">
                    @endif
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama bunga..." class="w-full rounded-full border border-gray-300 px-5 py-3 focus:ring-fuchsia-500 focus:border-fuchsia-500 shadow-sm transition outline-none">
                    <button class="bg-fuchsia-600 text-white px-8 py-3 rounded-full hover:bg-fuchsia-700 shadow-md transition font-bold">Cari</button>
                </form>

                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('products.index') }}" 
                       class="{{ !request('filter') ? 'bg-fuchsia-500 text-white shadow-lg scale-105' : 'bg-white text-gray-600 hover:text-fuchsia-600 hover:bg-fuchsia-50' }} px-6 py-2 rounded-full text-sm font-bold shadow-sm transition border border-transparent hover:border-fuchsia-200">
                       Semua
                    </a>
                    <a href="{{ route('products.index', ['filter' => 'terpopuler']) }}" 
                       class="{{ request('filter') == 'terpopuler' ? 'bg-fuchsia-500 text-white shadow-lg scale-105' : 'bg-white text-gray-600 hover:text-fuchsia-600 hover:bg-fuchsia-50' }} px-6 py-2 rounded-full text-sm font-bold shadow-sm transition border border-transparent hover:border-fuchsia-200">
                       Terpopuler
                    </a>
                    <a href="{{ route('products.index', ['filter' => 'terlaris']) }}" 
                       class="{{ request('filter') == 'terlaris' ? 'bg-fuchsia-500 text-white shadow-lg scale-105' : 'bg-white text-gray-600 hover:text-fuchsia-600 hover:bg-fuchsia-50' }} px-6 py-2 rounded-full text-sm font-bold shadow-sm transition border border-transparent hover:border-fuchsia-200">
                       Terlaris
                    </a>
                    <a href="{{ route('products.index', ['filter' => 'terbaru']) }}" 
                       class="{{ request('filter') == 'terbaru' ? 'bg-fuchsia-500 text-white shadow-lg scale-105' : 'bg-white text-gray-600 hover:text-fuchsia-600 hover:bg-fuchsia-50' }} px-6 py-2 rounded-full text-sm font-bold shadow-sm transition border border-transparent hover:border-fuchsia-200">
                       Terbaru
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                @foreach($products as $product)
                <!-- PERBAIKAN: route('products.show') -->
                <a href="{{ route('products.show', $product->id) }}" class="bg-white rounded-3xl shadow-lg hover:shadow-xl transition overflow-hidden group border border-purple-50 block cursor-pointer">
                    <div class="relative h-64 bg-gray-200 flex-shrink-0">
                        @php 
                            $badges = ['Best Seller', 'In Stock', 'New', 'Hot'];
                            $badge = $badges[array_rand($badges)];
                            $color = $badge == 'Best Seller' ? 'bg-fuchsia-500' : ($badge == 'In Stock' ? 'bg-green-500' : 'bg-orange-500');
                        @endphp
                        <span class="absolute top-4 right-4 {{ $color }} text-white text-xs font-bold px-3 py-1 rounded-full z-10 shadow-sm">{{ $badge }}</span>
                        
                        <img src="{{ $product->image_path ? asset('storage/' . $product->image_path) : 'https://source.unsplash.com/random/400x400?flower&sig='.$product->id }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    </div>
                    
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="font-bold text-lg text-gray-800 mb-1 serif">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-500 mb-4 flex-grow leading-relaxed">{{ Str::limit($product->description, 60) }}</p>
                        
                        <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-100">
                            <span class="text-xl font-bold text-fuchsia-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            
                            @if(!Auth::check() || (Auth::check() && !Auth::user()->is_admin))
                                <!-- Gunakan event preventDefault agar tidak bentrok dengan link card -->
                                <object>
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-purple-100 text-purple-600 p-3 rounded-full hover:bg-fuchsia-500 hover:text-white transition shadow-sm group-hover:scale-110">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        </button>
                                    </form>
                                </object>
                            @endif
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            
            @if($products->isEmpty())
                <div class="text-center py-20">
                    <div class="bg-white rounded-full h-24 w-24 flex items-center justify-center mx-auto mb-6 shadow-sm border border-gray-100">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-700 mb-2">Produk tidak ditemukan</h3>
                    <p class="text-gray-500">Coba gunakan kata kunci lain atau hapus filter.</p>
                    <a href="{{ route('products.index') }}" class="inline-block mt-4 text-fuchsia-600 font-bold hover:underline">Reset Pencarian</a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
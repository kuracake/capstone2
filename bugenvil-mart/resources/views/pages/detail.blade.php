<x-app-layout>
    <div class="bg-gray-50 min-h-screen py-10">
        <div class="container mx-auto px-6">
            
            <div class="text-sm text-gray-500 mb-6 flex items-center gap-2">
                <a href="{{ route('home') }}" class="hover:text-fuchsia-600">Beranda</a> 
                <span>/</span> 
                <!-- PERBAIKAN: products.all -> products.index -->
                <a href="{{ route('products.index') }}" class="hover:text-fuchsia-600">Produk</a>
                <span>/</span>
                <span class="text-gray-800 font-bold truncate max-w-xs">{{ $product->name }}</span>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    
                    <div class="space-y-4">
                        <div class="border border-gray-200 rounded-lg overflow-hidden relative group">
                            <img src="{{ $product->image_path ? asset('storage/' . $product->image_path) : 'https://source.unsplash.com/random/600x600?flower&sig='.$product->id }}" 
                                 class="w-full h-96 object-cover transform group-hover:scale-110 transition duration-500 cursor-zoom-in" 
                                 alt="{{ $product->name }}">
                            
                            @php 
                                $badges = ['Star+', 'Terlaris'];
                                $badge = $badges[array_rand($badges)];
                            @endphp
                            <span class="absolute top-4 left-4 bg-orange-500 text-white text-xs font-bold px-3 py-1 rounded">{{ $badge }}</span>
                        </div>
                        
                        <div class="grid grid-cols-4 gap-2">
                            @for($i=0; $i<4; $i++)
                            <div class="border border-gray-200 rounded cursor-pointer hover:border-fuchsia-500 transition overflow-hidden">
                                <img src="{{ $product->image_path ? asset('storage/' . $product->image_path) : 'https://source.unsplash.com/random/100x100?flower&sig='.$product->id.$i }}" class="w-full h-full object-cover">
                            </div>
                            @endfor
                        </div>
                    </div>

                    <div class="flex flex-col">
                        <h1 class="text-3xl font-bold text-gray-800 mb-2 leading-tight">{{ $product->name }}</h1>
                        
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-6">
                            <div class="flex items-center gap-1 text-fuchsia-600 border-r border-gray-300 pr-4">
                                <span class="font-bold underline text-lg">4.9</span>
                                <div class="flex text-sm">★★★★★</div>
                            </div>
                            <div class="flex items-center gap-1 border-r border-gray-300 pr-4">
                                <span class="font-bold text-gray-800 text-lg">{{ rand(50, 500) }}</span>
                                <span>Penilaian</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="font-bold text-gray-800 text-lg">{{ rand(100, 2000) }}</span>
                                <span>Terjual</span>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg mb-6 flex items-center gap-3">
                            <span class="text-gray-400 line-through text-lg">Rp {{ number_format($product->price * 1.2, 0, ',', '.') }}</span>
                            <span class="text-4xl font-bold text-fuchsia-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <span class="bg-fuchsia-100 text-fuchsia-600 text-xs font-bold px-2 py-1 rounded">DISKON 20%</span>
                        </div>

                        <div class="mb-6 space-y-3">
                            <div class="flex">
                                <span class="w-32 text-gray-500 text-sm">Pengiriman</span>
                                <div class="text-sm text-gray-800">
                                    <div class="flex items-center gap-2 mb-1">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                        <span>Gratis Ongkir</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                        <span>Sedang dikemas (Dikirim dalam 24 jam)</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center mb-8">
                            <span class="w-32 text-gray-500 text-sm">Kuantitas</span>
                            <div class="flex items-center border border-gray-300 rounded">
                                <button class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-600">-</button>
                                <input type="text" value="1" class="w-12 text-center border-none focus:ring-0 p-1 text-sm">
                                <button class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-600">+</button>
                            </div>
                            <span class="ml-4 text-sm text-gray-500">Tersedia {{ rand(50, 999) }} buah</span>
                        </div>

                        <div class="flex gap-4 mt-auto">
                            @if(!Auth::check() || (Auth::check() && !Auth::user()->is_admin))
                                <!-- FIX: Gunakan Form POST untuk Cart -->
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
                                    <button type="submit" onclick="setTimeout(function(){ window.location.href='/checkout'; }, 500);" class="w-full bg-fuchsia-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-fuchsia-700 transition flex items-center justify-center shadow-lg transform active:scale-95">
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

            <div class="bg-white rounded-xl shadow-sm p-8 mb-8">
                <h3 class="text-xl font-bold bg-gray-50 p-4 rounded-lg mb-6">Spesifikasi Produk</h3>
                <div class="space-y-4 text-gray-600 leading-relaxed">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4 text-sm">
                        <div class="text-gray-400">Kategori</div><div>Tanaman Hias</div>
                        <div class="text-gray-400">Stok</div><div>{{ rand(10, 100) }}</div>
                        <div class="text-gray-400">Dikirim Dari</div><div>KAB. BOGOR - JAWA BARAT</div>
                    </div>
                    <hr class="border-dashed my-4">
                    <h3 class="text-xl font-bold mb-4">Deskripsi Produk</h3>
                    <p class="whitespace-pre-line">{{ $product->description }}</p>
                    <p class="mt-4">
                        ✅ Garansi Tanaman Hidup sampai tujuan.<br>
                        ✅ Packing aman menggunakan kardus tebal.<br>
                        ✅ Gratis konsultasi perawatan setelah pembelian.
                    </p>
                </div>
            </div>

            <div class="mt-12">
                <h3 class="text-2xl font-bold text-gray-800 mb-6">Produk Lainnya</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $related)
                    <!-- PERBAIKAN: product.detail -> products.show -->
                    <a href="{{ route('products.show', $related->id) }}" class="bg-white rounded-2xl shadow hover:shadow-xl transition overflow-hidden group border border-transparent hover:border-fuchsia-300">
                        <div class="relative h-48 bg-gray-200">
                            <img src="{{ $related->image_path ? asset('storage/' . $related->image_path) : 'https://source.unsplash.com/random/400x400?flower&sig='.$related->id }}" 
                                 class="w-full h-full object-cover">
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
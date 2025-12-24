<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Breadcrumb --}}
            <nav class="flex text-sm text-gray-500 mb-6">
                <a href="{{ route('home') }}" class="hover:text-fuchsia-600">Beranda</a> 
                <span class="mx-2">/</span>
                <span class="text-gray-800 font-bold">Keranjang Belanja</span>
            </nav>

            <h1 class="text-3xl font-bold text-gray-900 mb-8 font-serif">Keranjang Belanja Anda</h1>

            {{-- Pesan Sukses --}}
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                {{-- Cek apakah keranjang tidak kosong --}}
                @if($cartItems->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider border-b border-gray-200">
                                <tr>
                                    <th class="p-6 font-semibold">Produk</th>
                                    <th class="p-6 font-semibold">Harga Satuan</th>
                                    <th class="p-6 font-semibold text-center">Jumlah</th>
                                    <th class="p-6 font-semibold">Total</th>
                                    <th class="p-6 font-semibold text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($cartItems as $item)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        {{-- 1. KOLOM PRODUK --}}
                                        <td class="p-6">
                                            <div class="flex items-center gap-4">
                                                <div class="w-20 h-20 flex-shrink-0 bg-gray-100 rounded-lg overflow-hidden border border-gray-200">
                                                    {{-- LOGIKA GAMBAR CADANGAN (FALLBACK) --}}
                                                    @if($item->product->image)
                                                        <img src="{{ asset('storage/'.$item->product->image) }}" class="w-full h-full object-cover">
                                                    @elseif($item->product->images->count() > 0)
                                                        <img src="{{ asset('storage/'.$item->product->images->first()->image_path) }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">No Image</div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <a href="{{ route('products.show', $item->product->id) }}" class="font-bold text-gray-800 text-lg hover:text-fuchsia-600 transition">
                                                        {{ $item->product->name }}
                                                    </a>
                                                    <p class="text-sm text-gray-500 mt-1">Stok: {{ $item->product->stock }}</p>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- 2. HARGA SATUAN --}}
                                        <td class="p-6 text-gray-600 font-medium">
                                            Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                        </td>

                                        {{-- 3. QUANTITY --}}
                                        <td class="p-6 text-center">
                                            <span class="inline-block bg-gray-100 px-4 py-2 rounded-lg font-bold text-gray-700">
                                                {{ $item->quantity }}
                                            </span>
                                        </td>

                                        {{-- 4. SUBTOTAL --}}
                                        <td class="p-6 font-bold text-fuchsia-600 text-lg">
                                            Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                        </td>

                                        {{-- 5. AKSI (HAPUS) --}}
                                        <td class="p-6 text-center">
                                            <form action="{{ route('cart.remove') }}" method="POST">
                                                @csrf @method('DELETE')
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button type="submit" 
                                                        class="text-gray-400 hover:text-red-500 transition p-2 hover:bg-red-50 rounded-full" 
                                                        title="Hapus dari keranjang">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- FOOTER KERANJANG --}}
                    <div class="bg-gray-50 p-6 sm:p-10 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-6">
                            <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-fuchsia-600 font-medium flex items-center gap-2 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                                Lanjut Belanja
                            </a>

                            <div class="text-right w-full sm:w-auto">
                                <div class="text-gray-500 text-sm mb-1">Total Pesanan</div>
                                <div class="text-3xl font-bold text-gray-900 mb-6 font-serif">
                                    Rp {{ number_format($grandTotal, 0, ',', '.') }}
                                </div>
                                
                                <a href="{{ route('checkout') }}" class="block w-full sm:w-auto bg-fuchsia-600 text-white px-8 py-4 rounded-xl font-bold hover:bg-fuchsia-700 transition shadow-lg shadow-fuchsia-200 text-center">
                                    Checkout Sekarang &rarr;
                                </a>
                            </div>
                        </div>
                    </div>

                @else
                    {{-- JIKA KOSONG --}}
                    <div class="text-center py-20 px-6">
                        <div class="bg-pink-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-fuchsia-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Keranjang Belanja Kosong</h3>
                        <p class="text-gray-500 mb-8 max-w-sm mx-auto">Wah, sepertinya Anda belum memilih bunga cantik untuk taman Anda.</p>
                        <a href="{{ route('products.index') }}" class="inline-block bg-fuchsia-600 text-white px-8 py-3 rounded-full font-bold hover:bg-fuchsia-700 transition shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            Mulai Belanja
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
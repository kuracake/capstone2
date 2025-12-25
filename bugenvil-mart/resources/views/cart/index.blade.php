<x-app-layout>
    {{-- HEADER HALAMAN (Style Clean & Minimalis) --}}
    <div class="bg-white border-b border-gray-100">
        <div class="container mx-auto px-4 md:px-6 py-6 md:py-8">
            <h1 class="text-2xl md:text-3xl font-bold font-serif text-fuchsia-900">
                Keranjang Belanja
            </h1>
            <p class="text-xs md:text-sm text-gray-500 mt-1">
                <span class="font-medium text-fuchsia-600">{{ $cartItems->sum('quantity') }} item</span> ada di dalam keranjang Anda.
            </p>
        </div>
    </div>

    {{-- KONTEN UTAMA --}}
    <div class="bg-gray-50 min-h-screen py-6 md:py-10">
        <div class="container mx-auto px-4 md:px-6">
            
            @if($cartItems->isEmpty())
                {{-- TAMPILAN KOSONG --}}
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-10 text-center max-w-lg mx-auto mt-10">
                    <div class="w-20 h-20 bg-fuchsia-50 rounded-full flex items-center justify-center mx-auto mb-5">
                        <svg class="w-10 h-10 text-fuchsia-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800 font-serif mb-2">Keranjang Kosong</h2>
                    <p class="text-gray-500 text-sm mb-6">Wah, keranjang Anda masih kosong. Yuk isi dengan tanaman cantik!</p>
                    <a href="{{ route('products.index') }}" class="inline-block px-6 py-2.5 bg-fuchsia-600 text-white rounded-full font-bold text-sm hover:bg-fuchsia-700 transition shadow-md">
                        Mulai Belanja
                    </a>
                </div>
            @else
                <div class="flex flex-col lg:flex-row gap-6 items-start">
                    
                    {{-- KIRI: LIST PRODUK --}}
                    <div class="w-full lg:w-2/3 space-y-4">
                        @foreach($cartItems as $item)
                            {{-- CARD PRODUK --}}
                            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex gap-4 relative group">
                                
                                {{-- 1. GAMBAR (Ukuran Fixed agar Rapi) --}}
                                <div class="w-20 h-20 md:w-28 md:h-28 flex-shrink-0 bg-gray-50 rounded-xl overflow-hidden border border-gray-100">
                                    @if($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-300 text-xs">No Img</div>
                                    @endif
                                </div>

                                {{-- 2. DETAIL & KONTROL --}}
                                <div class="flex-grow flex flex-col justify-between">
                                    
                                    {{-- Atas: Nama & Tombol Hapus --}}
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-base md:text-lg font-bold font-serif text-gray-800 leading-tight line-clamp-2">
                                                <a href="{{ route('products.show', $item->product->id) }}" class="hover:text-fuchsia-600 transition">
                                                    {{ $item->product->name }}
                                                </a>
                                            </h3>
                                            <p class="text-xs text-gray-500 mt-1">Stok: {{ $item->product->stock }}</p>
                                        </div>
                                        
                                        {{-- Tombol Hapus (Desktop & Mobile) --}}
                                        <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-gray-300 hover:text-red-500 transition p-1" title="Hapus">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </form>
                                    </div>

                                    {{-- Bawah: Harga & Quantity Stepper --}}
                                    <div class="flex items-end justify-between mt-3">
                                        <div class="text-fuchsia-700 font-bold text-sm md:text-base">
                                            Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                        </div>

                                        {{-- STEPPER BUTTONS --}}
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center bg-gray-50 rounded-lg border border-gray-200 h-8 md:h-9">
                                            @csrf @method('PATCH')
                                            
                                            {{-- Tombol Kurang --}}
                                            <button type="submit" name="action" value="decrease" class="w-8 md:w-9 h-full flex items-center justify-center text-gray-500 hover:text-fuchsia-600 hover:bg-gray-100 rounded-l-lg transition">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M20 12H4"/></svg>
                                            </button>
                                            
                                            {{-- Angka --}}
                                            <input type="text" readonly value="{{ $item->quantity }}" class="w-8 md:w-10 h-full text-center bg-transparent border-0 p-0 text-xs md:text-sm font-bold text-gray-800 focus:ring-0 cursor-default">
                                            
                                            {{-- Tombol Tambah --}}
                                            <button type="submit" name="action" value="increase" class="w-8 md:w-9 h-full flex items-center justify-center text-gray-500 hover:text-fuchsia-600 hover:bg-gray-100 rounded-r-lg transition">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="pt-4">
                            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-fuchsia-600 font-medium transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" /></svg>
                                Kembali Belanja
                            </a>
                        </div>
                    </div>

                    {{-- KANAN: RINGKASAN PESANAN (Sticky) --}}
                    <div class="w-full lg:w-1/3">
                        <div class="bg-white p-5 md:p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-24">
                            <h3 class="text-lg font-bold font-serif text-gray-900 mb-4 pb-3 border-b border-gray-100">
                                Ringkasan
                            </h3>
                            
                            <div class="space-y-3 text-sm text-gray-600 mb-6">
                                <div class="flex justify-between">
                                    <span>Total Harga ({{ $cartItems->sum('quantity') }} item)</span>
                                    <span class="font-bold text-gray-900">Rp {{ number_format($cartItems->sum(function($item){ return $item->product->price * $item->quantity; }), 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Ongkos Kirim</span>
                                    <span class="text-gray-400 text-xs italic">Hitung di checkout</span>
                                </div>
                            </div>

                            <div class="flex justify-between items-end mb-6">
                                <span class="text-base font-bold text-gray-800">Total Bayar</span>
                                <span class="text-xl font-bold text-fuchsia-600">
                                    Rp {{ number_format($cartItems->sum(function($item){ return $item->product->price * $item->quantity; }), 0, ',', '.') }}
                                </span>
                            </div>

                            <a href="{{ route('checkout.index') }}" class="block w-full py-3.5 bg-gradient-to-r from-fuchsia-700 to-purple-700 text-white text-center font-bold rounded-xl hover:shadow-lg hover:opacity-90 transition transform active:scale-95 text-sm md:text-base">
                                Lanjut Pembayaran
                            </a>
                            
                            <p class="text-center text-xs text-gray-400 mt-4 flex justify-center gap-2 items-center">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                Transaksi Aman & Terenkripsi
                            </p>
                        </div>
                    </div>

                </div>
            @endif
        </div>
    </div>
</x-app-layout>
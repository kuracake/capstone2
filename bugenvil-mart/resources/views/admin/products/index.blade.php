<x-admin-layout>
    
    {{-- HEADER & TOMBOL TAMBAH --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 font-serif">Daftar Produk</h2>
            <p class="text-sm text-gray-500">Kelola katalog tanaman dan stok produk Anda.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="inline-flex items-center justify-center px-6 py-3 bg-fuchsia-600 text-white text-sm font-bold rounded-xl hover:bg-fuchsia-700 transition shadow-lg shadow-fuchsia-200 gap-2 transform hover:-translate-y-0.5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Produk
        </a>
    </div>

    {{-- ALERT NOTIFIKASI --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" class="mb-6 flex items-center p-4 bg-green-50 border-l-4 border-green-500 rounded-r-xl shadow-sm">
            <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="text-green-800 font-medium text-sm">{{ session('success') }}</span>
            <button @click="show = false" class="ml-auto text-green-400 hover:text-green-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
    @endif

    {{-- TABEL PRODUK --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-gray-600">
                <thead class="bg-gray-50 text-xs uppercase text-gray-400 font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-5">Produk</th>
                        <th class="px-6 py-5">Harga</th>
                        <th class="px-6 py-5 text-center">Stok</th>
                        <th class="px-6 py-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $product)
                        <tr class="hover:bg-fuchsia-50/30 transition duration-200 group">
                            
                            {{-- Kolom Produk (Gambar + Nama) --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="h-14 w-14 rounded-xl overflow-hidden bg-gray-100 border border-gray-100 shadow-sm flex-shrink-0 group-hover:scale-105 transition-transform duration-300">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover" alt="{{ $product->name }}">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-300 text-xs">No Img</div>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-800 text-sm group-hover:text-fuchsia-700 transition">{{ $product->name }}</h3>
                                        <p class="text-xs text-gray-400 mt-0.5 line-clamp-1 max-w-[150px]">{{ Str::limit($product->description, 30) }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Kolom Harga --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-bold text-fuchsia-600">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                            </td>

                            {{-- Kolom Stok (Dengan Warna Dinamis) --}}
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                @if($product->stock < 5)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-red-50 text-red-600 border border-red-100">
                                        {{ $product->stock }} Item
                                        <span class="w-2 h-2 ml-1.5 rounded-full bg-red-500 animate-pulse"></span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-green-50 text-green-600 border border-green-100">
                                        {{ $product->stock }} Item
                                    </span>
                                @endif
                            </td>

                            {{-- Kolom Aksi --}}
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition shadow-sm" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition shadow-sm" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4 text-gray-400">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-800">Belum ada produk</h3>
                                    <p class="text-gray-500 text-sm mt-1 mb-4">Mulai tambahkan koleksi tanaman Anda sekarang.</p>
                                    <a href="{{ route('admin.products.create') }}" class="px-5 py-2 bg-fuchsia-600 text-white rounded-lg text-sm font-bold hover:bg-fuchsia-700 transition">
                                        + Tambah Produk Baru
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination (Jika ada) --}}
        @if($products->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                {{ $products->links() }}
            </div>
        @endif
    </div>

</x-admin-layout>
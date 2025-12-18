<x-admin-layout>
    <div class="py-4 md:py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4">
            
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900">Daftar Produk</h2>
                <a href="{{ route('admin.products.create') }}" class="inline-flex items-center justify-center px-5 py-3 bg-teal-600 text-white rounded-xl font-bold text-sm shadow-md hover:bg-teal-700 transition-all">
                    + Tambah Produk
                </a>
            </div>

            {{-- Desktop View (Tabel) --}}
            <div class="hidden md:block bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 border-b border-gray-100 text-gray-400 uppercase text-[11px] font-bold">
                        <tr>
                            <th class="px-6 py-4">Produk</th>
                            <th class="px-6 py-4">Harga</th>
                            <th class="px-6 py-4 text-center">Stok</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-gray-700">
                        @foreach($products as $product)
                        <tr class="hover:bg-gray-50/50">
                            <td class="px-6 py-4 flex items-center gap-3">
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-10 h-10 rounded-lg object-cover bg-gray-50 border border-gray-100">
                                <span class="font-bold text-gray-900">{{ $product->name }}</span>
                            </td>
                            <td class="px-6 py-4 font-bold text-teal-600">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2 py-1 rounded-md {{ $product->stock <= 5 ? 'bg-red-50 text-red-600' : 'bg-teal-50 text-teal-600' }} text-[11px] font-bold">
                                    {{ $product->stock }} Item
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-500 p-2 hover:bg-blue-50 rounded-lg transition-colors">Edit</a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-400 p-2 hover:bg-red-50 rounded-lg">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Mobile View (Card List) --}}
            <div class="md:hidden space-y-3">
                @forelse($products as $product)
                <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
                    <img src="{{ asset('storage/' . $product->image) }}" class="w-16 h-16 rounded-xl object-cover border border-gray-100 shadow-sm">
                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-gray-900 truncate">{{ $product->name }}</h4>
                        <p class="text-teal-600 font-bold text-sm">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-[10px] font-bold uppercase tracking-wider {{ $product->stock <= 5 ? 'text-red-500' : 'text-gray-400' }}">
                                Stok: {{ $product->stock }}
                            </span>
                            <div class="flex gap-3">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-500 text-xs font-bold">Edit</a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="text-red-400 text-xs font-bold">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-center text-gray-400 text-sm py-10 italic">Belum ada produk.</p>
                @endforelse
            </div>

            <div class="mt-6 px-2">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>
<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Kelola Produk</h2>
                <a href="{{ route('admin.products.create') }}" class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded-lg shadow transition">
                    + Tambah Produk
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                <div class="overflow-x-auto">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr class="bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <th class="px-5 py-3 border-b-2 border-gray-200">Gambar</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200">Nama Produk</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200">Harga</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                            <tr>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="" class="w-16 h-16 object-cover rounded-md border">
                                    @else
                                        <span class="text-gray-400">No Image</span>
                                    @endif
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 font-semibold">{{ $product->name }}</p>
                                    <p class="text-gray-500 text-xs truncate w-48">{{ $product->description }}</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                    <div class="flex justify-center gap-2">
                                        {{-- TOMBOL EDIT --}}
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="text-yellow-600 hover:text-yellow-900 font-bold">
                                            Edit
                                        </a>
                                        
                                        <span class="text-gray-300">|</span>
                                        
                                        {{-- TOMBOL DELETE --}}
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin hapus produk ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-bold">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-5 py-10 text-center text-gray-500">
                                    Belum ada produk yang ditambahkan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 bg-gray-50">
                    {{ $products->links() }} 
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
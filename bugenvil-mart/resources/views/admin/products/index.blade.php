<x-admin-layout>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">Kelola Produk</h2>
        <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white rounded-xl font-semibold text-sm transition-colors shadow-lg shadow-teal-200 flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Produk
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-400 uppercase bg-gray-50 font-bold border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4">Gambar</th>
                        <th class="px-6 py-4">Nama Produk</th>
                        <th class="px-6 py-4">Harga</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $product)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-12 h-12 rounded-lg object-cover border border-gray-200" alt="{{ $product->name }}">
                            @else
                                <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 text-xs">No Img</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $product->name }}</td>
                        <td class="px-6 py-4 font-bold text-teal-600">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 flex justify-center gap-3">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-500 hover:text-blue-700 font-medium text-xs">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-medium text-xs">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-400">Belum ada produk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
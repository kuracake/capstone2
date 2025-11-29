<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800">Manajemen Produk</h2>
            <a href="{{ route('products.create') }}" class="bg-pink-600 text-white px-4 py-2 rounded text-sm">Tambah Produk Baru</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b bg-gray-100">
                            <th class="p-3">Nama</th>
                            <th class="p-3">Harga</th>
                            <th class="p-3">Deskripsi</th>
                            <th class="p-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr class="border-b">
                            <td class="p-3 font-bold">{{ $product->name }}</td>
                            <td class="p-3">Rp {{ number_format($product->price) }}</td>
                            <td class="p-3 text-sm text-gray-600">{{ Str::limit($product->description, 50) }}</td>
                            <td class="p-3">
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:text-red-900" onclick="return confirm('Hapus produk ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
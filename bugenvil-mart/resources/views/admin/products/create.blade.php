<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Tambah Produk Baru</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block mb-1">Nama Bunga</label>
                        <input type="text" name="name" class="w-full border p-2 rounded" required>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1">Harga (Rp)</label>
                        <input type="number" name="price" class="w-full border p-2 rounded" required>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1">Deskripsi</label>
                        <textarea name="description" class="w-full border p-2 rounded" required></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1">Foto Bunga</label>
                        <input type="file" name="image" class="w-full border p-2">
                    </div>
                    <button class="bg-pink-600 text-white px-4 py-2 rounded">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
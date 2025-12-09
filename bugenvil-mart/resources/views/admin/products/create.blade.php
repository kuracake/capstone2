<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900">
                    
                    <div class="flex justify-between items-center mb-8">
                        <h2 class="text-2xl font-bold text-gray-800">Tambah Produk Baru</h2>
                        <a href="{{ route('admin.products.index') }}" class="text-gray-500 hover:text-gray-700">
                            &larr; Kembali
                        </a>
                    </div>

                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-lg border-gray-300 focus:border-fuchsia-500 focus:ring-fuchsia-500 shadow-sm" required placeholder="Contoh: Bugenvil Merah Rimbun">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Informasi Penjualan / Deskripsi</label>
                            <textarea name="description" rows="4" class="w-full rounded-lg border-gray-300 focus:border-fuchsia-500 focus:ring-fuchsia-500 shadow-sm" placeholder="Jelaskan kondisi tanaman...">{{ old('description') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Harga Asli (Rp)</label>
                                <input type="number" name="price" value="{{ old('price') }}" class="w-full rounded-lg border-gray-300 focus:border-fuchsia-500 focus:ring-fuchsia-500 shadow-sm" required placeholder="50000">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Harga Diskon (Opsional)</label>
                                <input type="number" name="discount_price" value="{{ old('discount_price') }}" class="w-full rounded-lg border-gray-300 focus:border-fuchsia-500 focus:ring-fuchsia-500 shadow-sm" placeholder="Contoh: 45000">
                                <p class="text-xs text-gray-500 mt-1">*Harga ini yang akan tampil sebagai harga jual.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Stok Barang</label>
                                <input type="number" name="stock" value="{{ old('stock', 10) }}" class="w-full rounded-lg border-gray-300 focus:border-fuchsia-500 focus:ring-fuchsia-500 shadow-sm" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Berat Produk (Gram)</label>
                                <input type="number" name="weight" value="{{ old('weight', 1000) }}" class="w-full rounded-lg border-gray-300 focus:border-fuchsia-500 focus:ring-fuchsia-500 shadow-sm" required>
                                <p class="text-xs text-gray-500 mt-1">*Penting untuk ongkir (1000 gram = 1kg).</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Foto Produk</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:bg-gray-50 transition relative">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <span class="relative cursor-pointer bg-white rounded-md font-medium text-fuchsia-600 hover:text-fuchsia-500 focus-within:outline-none">
                                            <span>Upload file</span>
                                            <input id="file-upload" name="image" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-500">Klik area ini untuk memilih gambar</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end pt-4">
                            <button type="submit" class="bg-fuchsia-600 text-white font-bold py-3 px-8 rounded-full shadow-lg hover:bg-fuchsia-700 transition transform hover:scale-105">
                                Simpan Produk
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
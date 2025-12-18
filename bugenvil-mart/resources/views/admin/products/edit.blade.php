<x-admin-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-8 border-b border-gray-100">
                    
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Edit Produk: {{ $product->name }}</h2>
                        <a href="{{ route('admin.products.index') }}" class="text-gray-500 hover:text-gray-700 font-medium transition">
                            &larr; Batal
                        </a>
                    </div>

                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- Nama Produk --}}
                        <div>
                            <x-input-label for="name" :value="__('Nama Produk')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $product->name)" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- Deskripsi --}}
                        <div>
                            <x-input-label for="description" :value="__('Deskripsi Produk')" />
                            <textarea id="description" name="description" rows="4" class="block mt-1 w-full border-gray-300 focus:border-pink-500 focus:ring-pink-500 rounded-md shadow-sm">{{ old('description', $product->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        {{-- Grid Harga --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="price" :value="__('Harga Asli (Rp)')" />
                                <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price', $product->price)" required />
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="discount_price" :value="__('Harga Diskon (Opsional)')" />
                                <x-text-input id="discount_price" class="block mt-1 w-full" type="number" name="discount_price" :value="old('discount_price', $product->discount_price)" />
                                <x-input-error :messages="$errors->get('discount_price')" class="mt-2" />
                            </div>
                        </div>

                         {{-- Grid Stok & Berat --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-4 rounded-xl border border-gray-100">
    <div>
        <x-input-label for="stock" :value="__('Jumlah Stok')" class="text-teal-700 font-bold" />
        <x-text-input id="stock" class="block mt-1 w-full border-teal-200 focus:ring-teal-500" type="number" name="stock" :value="old('stock', $product->stock ?? 0)" required min="0" />
        <p class="text-[10px] text-gray-500 mt-1">Stok akan berkurang otomatis saat checkout.</p>
    </div>
    <div>
        <x-input-label for="weight" :value="__('Berat Satuan (Gram)')" class="text-teal-700 font-bold" />
        <x-text-input id="weight" class="block mt-1 w-full border-teal-200 focus:ring-teal-500" type="number" name="weight" :value="old('weight', $product->weight ?? 1000)" required min="1" />
        <p class="text-[10px] text-gray-500 mt-1">Digunakan untuk hitung ongkir otomatis.</p>
    </div>
</div>

                        {{-- Gambar --}}
                        <div>
                            <x-input-label for="image" :value="__('Ganti Gambar (Opsional)')" />
                            
                            @if($product->image)
                                <div class="mb-3 p-2 border rounded-lg inline-block bg-gray-50">
                                    <p class="text-xs text-gray-500 mb-1">Gambar saat ini:</p>
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="Current Image" class="h-32 object-contain rounded">
                                </div>
                            @endif

                            <input id="image" name="image" type="file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" accept="image/*">
                            <p class="mt-1 text-sm text-gray-500">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        {{-- Tombol --}}
                        <div class="flex justify-end pt-4">
                            <x-primary-button class="bg-pink-600 hover:bg-pink-700 py-3 px-6 text-base">
                                {{ __('Simpan Perubahan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
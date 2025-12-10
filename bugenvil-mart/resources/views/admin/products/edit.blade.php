<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-8 border-b border-gray-100">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Produk: {{ $product->name }}</h2>

                    {{-- Perhatikan action route ke update dan method PUT --}}
                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="name" :value="__('Nama Produk')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $product->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="price" :value="__('Harga (Rp)')" />
                            <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price', $product->price)" required />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Deskripsi Produk')" />
                            <textarea id="description" name="description" rows="4" class="block mt-1 w-full border-gray-300 focus:border-pink-500 focus:ring-pink-500 rounded-md shadow-sm">{{ old('description', $product->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="image" :value="__('Ganti Gambar (Opsional)')" />
                            
                            @if($product->image)
                                <div class="mb-2">
                                    <p class="text-sm text-gray-500 mb-1">Gambar saat ini:</p>
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="Current Image" class="w-32 h-32 object-cover rounded-lg border">
                                </div>
                            @endif

                            <input id="image" name="image" type="file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" accept="image/*">
                            <p class="mt-1 text-sm text-gray-500">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        <div class="flex justify-end gap-3 mt-8">
                            <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition">
                                Batal
                            </a>
                            <x-primary-button class="bg-pink-600 hover:bg-pink-700">
                                {{ __('Simpan Perubahan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
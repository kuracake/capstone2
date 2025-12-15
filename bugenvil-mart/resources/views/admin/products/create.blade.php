<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-8 border-b border-gray-100">
                    
                    {{-- Header --}}
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Tambah Produk Baru</h2>
                        <a href="{{ route('admin.products.index') }}" class="text-gray-500 hover:text-gray-700 font-medium transition">
                            &larr; Kembali
                        </a>
                    </div>

                    {{-- Form --}}
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        {{-- Nama Produk --}}
                        <div>
                            <x-input-label for="name" :value="__('Nama Produk')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus placeholder="Contoh: Bugenvil Merah Rimbun" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- Deskripsi --}}
                        <div>
                            <x-input-label for="description" :value="__('Deskripsi Produk')" />
                            <textarea id="description" name="description" rows="4" class="block mt-1 w-full border-gray-300 focus:border-pink-500 focus:ring-pink-500 rounded-md shadow-sm" placeholder="Jelaskan kondisi tanaman...">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        {{-- Grid Harga --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="price" :value="__('Harga Asli (Rp)')" />
                                <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price')" required placeholder="50000" />
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="discount_price" :value="__('Harga Diskon (Opsional)')" />
                                <x-text-input id="discount_price" class="block mt-1 w-full" type="number" name="discount_price" :value="old('discount_price')" placeholder="45000" />
                                <p class="text-xs text-gray-500 mt-1">*Harga ini yang akan dipakai checkout.</p>
                            </div>
                        </div>

                        {{-- Grid Stok & Berat (PENTING: Jangan sampai hilang) --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="stock" :value="__('Stok Barang')" />
                                <x-text-input id="stock" class="block mt-1 w-full" type="number" name="stock" :value="old('stock', 10)" required />
                                <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="weight" :value="__('Berat (Gram)')" />
                                <x-text-input id="weight" class="block mt-1 w-full" type="number" name="weight" :value="old('weight', 1000)" required />
                                <p class="text-xs text-gray-500 mt-1">*Wajib untuk hitung ongkir (1000 = 1kg).</p>
                                <x-input-error :messages="$errors->get('weight')" class="mt-2" />
                            </div>
                        </div>

                        {{-- Gambar --}}
                        <div>
                            <x-input-label for="image" :value="__('Foto Produk')" />
                            <input id="image" name="image" type="file" class="block w-full mt-1 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" accept="image/*" required>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        {{-- Tombol --}}
                        <div class="flex justify-end pt-4">
                            <x-primary-button class="bg-pink-600 hover:bg-pink-700 py-3 px-6 text-base">
                                {{ __('Simpan Produk') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
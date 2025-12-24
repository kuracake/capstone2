<x-admin-layout>
    <div class="py-4 md:py-8 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto px-4">
            {{-- Header --}}
            <div class="mb-6">
                <a href="{{ route('admin.products.index') }}" class="inline-flex items-center text-teal-600 font-bold text-sm mb-2">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Kembali
                </a>
                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900">Tambah Produk</h2>
            </div>

            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 md:space-y-6">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6">
                    
                    {{-- Detail Produk --}}
                    <div class="lg:col-span-2 space-y-4 md:space-y-6">
                        <div class="bg-white p-5 md:p-6 rounded-2xl shadow-sm border border-gray-100">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi Produk</h3>
                            <div class="space-y-4">
                                <div>
                                    <x-input-label for="name" :value="__('Nama Tanaman')" />
                                    <x-text-input id="name" class="block w-full mt-1 border-gray-200 focus:ring-teal-500 rounded-xl" type="text" name="name" :value="old('name')" required />
                                </div>
                                <div>
                                    <x-input-label for="description" :value="__('Deskripsi')" />
                                    <textarea id="description" name="description" rows="4" class="block w-full mt-1 border-gray-200 focus:ring-teal-500 rounded-xl shadow-sm">{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-5 md:p-6 rounded-2xl shadow-sm border border-gray-100">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Harga & Stok</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="price" :value="__('Harga (Rp)')" />
                                    <input type="number" name="price" id="price" class="w-full mt-1 border-gray-200 focus:ring-teal-500 rounded-xl shadow-sm" required>
                                </div>
                                <div>
                                    <x-input-label for="stock" :value="__('Jumlah Stok')" />
                                    <input type="number" name="stock" id="stock" class="w-full mt-1 border-gray-200 focus:ring-teal-500 rounded-xl shadow-sm" required>
                                </div>
                                <div>
                                    <x-input-label for="weight" :value="__('Berat (Gram)')" />
                                    <input type="number" name="weight" id="weight" class="w-full mt-1 border-gray-200 focus:ring-teal-500 rounded-xl shadow-sm" value="1000" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Media & Submit --}}
                    <div class="space-y-4">
                        <div class="bg-white p-5 md:p-6 rounded-2xl shadow-sm border border-gray-100">
                            <h3 class="text-lg font-bold text-gray-800 mb-4">Foto Produk (Maks 10)</h3>
                            
                            {{-- Area Upload --}}
                            <label class="flex flex-col items-center justify-center w-full min-h-[12rem] border-2 border-dashed border-gray-200 rounded-2xl cursor-pointer hover:bg-gray-50 transition-all p-4">
                                
                                {{-- Icon Default (Akan hilang saat ada foto) --}}
                                <div id="icon" class="flex flex-col items-center text-gray-400 text-center">
                                    <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="2" stroke-linecap="round"/></svg>
                                    <span class="text-xs font-medium">Klik untuk Pilih Banyak Foto</span>
                                </div>

                                {{-- Container Preview Grid --}}
                                <div id="preview-container" class="hidden grid grid-cols-3 gap-2 w-full">
                                    {{-- Gambar preview akan muncul di sini via JS --}}
                                </div>

                                {{-- INPUT UTAMA: name="images[]" dan multiple --}}
                                <input type="file" name="images[]" multiple class="hidden" accept="image/*" onchange="showPreview(event)" required>
                            </label>

                            {{-- Pesan Error Validasi --}}
                            @error('images') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                            @error('images.*') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit" class="w-full py-4 bg-teal-600 text-white rounded-2xl font-bold text-lg shadow-lg shadow-teal-100 hover:bg-teal-700 active:scale-95 transition-all">
                            Simpan Produk
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Script Baru untuk Preview Banyak Gambar --}}
    <script>
        function showPreview(event){
            const files = event.target.files;
            const previewContainer = document.getElementById("preview-container");
            const icon = document.getElementById("icon");
            
            // Reset preview
            previewContainer.innerHTML = '';

            if(files.length > 0){
                icon.classList.add("hidden");
                previewContainer.classList.remove("hidden");

                // Loop setiap file yang dipilih
                Array.from(files).forEach(file => {
                    let src = URL.createObjectURL(file);
                    
                    // Buat elemen gambar
                    let img = document.createElement('img');
                    img.src = src;
                    img.className = "w-full h-20 object-cover rounded-lg border border-gray-200";
                    
                    // Masukkan ke container
                    previewContainer.appendChild(img);
                });
            } else {
                icon.classList.remove("hidden");
                previewContainer.classList.add("hidden");
            }
        }
    </script>
</x-admin-layout>
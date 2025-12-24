<x-admin-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-8 border-b border-gray-100">
                    
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Edit Produk: {{ $product->name }}</h2>
                        <a href="{{ route('admin.products.index') }}" class="text-gray-500 hover:text-gray-700 font-medium transition flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            Kembali
                        </a>
                    </div>

                    {{-- Pesan Sukses / Error --}}
                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                            <p>{{ session('error') }}</p>
                        </div>
                    @endif

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
                            <textarea id="description" name="description" rows="4" class="block mt-1 w-full border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-md shadow-sm">{{ old('description', $product->description) }}</textarea>
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
                                <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ada diskon.</p>
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

                        {{-- AREA MANAJEMEN FOTO --}}
                        <div class="border-t pt-6 mt-6">
                            
                            {{-- BAGIAN A: FOTO YANG SUDAH ADA (DARI DATABASE) --}}
                            <h3 class="text-lg font-bold text-gray-800 mb-4">1. Foto Saat Ini</h3>
                            @if($product->images->count() > 0)
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                                    @foreach($product->images as $img)
                                        <div class="relative group border border-gray-200 rounded-lg p-2 bg-white shadow-sm">
                                            {{-- Gambar --}}
                                            <img src="{{ asset('storage/' . $img->image_path) }}" class="w-full h-24 object-cover rounded">
                                            
                                            {{-- Label Thumbnail --}}
                                            @if($product->image == $img->image_path)
                                                <span class="absolute top-0 left-0 bg-teal-600 text-white text-[10px] px-2 py-1 rounded-br-lg rounded-tl-lg shadow font-bold z-10">Utama</span>
                                            @endif

                                            {{-- Tombol Hapus (Overlay) --}}
                                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center rounded-lg">
                                                <button type="submit" 
                                                        formaction="{{ route('admin.product.image.delete', $img->id) }}" 
                                                        formmethod="POST"
                                                        name="_method" value="DELETE"
                                                        class="bg-red-600 hover:bg-red-700 text-white p-2 rounded-full shadow-lg transform hover:scale-110 transition"
                                                        onclick="return confirm('Yakin hapus foto ini secara permanen?')">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-400 italic mb-4 text-sm">Tidak ada foto tersimpan.</p>
                            @endif

                            {{-- BAGIAN B: UPLOAD FOTO BARU (FITUR SATU PER SATU) --}}
                            <h3 class="text-lg font-bold text-gray-800 mb-4">2. Tambah Foto Baru</h3>
                            
                            {{-- Input Asli (Hidden) --}}
                            <input type="file" name="images[]" id="real-input" multiple class="hidden">
                            {{-- Input Trigger (Hidden) --}}
                            <input type="file" id="trigger-input" multiple class="hidden" accept="image/*" onchange="addFiles(this)">

                            {{-- Tombol Upload Area --}}
                            <div onclick="document.getElementById('trigger-input').click()" 
                                 class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-2xl cursor-pointer hover:bg-gray-50 hover:border-teal-500 transition-all group p-4 mb-4">
                                <div class="flex flex-col items-center text-gray-500 group-hover:text-teal-600 transition">
                                    <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="2" stroke-linecap="round"/></svg>
                                    <span class="text-sm font-bold">Klik untuk Tambah Foto Baru</span>
                                    <span class="text-xs text-gray-400 mt-1">(Mode: Pilih satu per satu / banyak sekaligus)</span>
                                </div>
                            </div>

                            {{-- Container Preview Foto BARU --}}
                            <div id="preview-container" class="grid grid-cols-3 gap-3 w-full">
                                {{-- Preview via JS muncul di sini --}}
                            </div>

                            <x-input-error :messages="$errors->get('images')" class="mt-2" />

                            @if($errors->has('images.*'))
    <ul class="mt-2 list-disc list-inside text-sm text-red-600">
        @foreach($errors->get('images.*') as $errorGroup)
            @foreach($errorGroup as $errorMessage)
                <li>{{ $errorMessage }}</li>
            @endforeach
        @endforeach
    </ul>
@endif 
                        </div>

                        {{-- Tombol Simpan --}}
                        <div class="flex justify-end pt-6 border-t border-gray-100">
                            <x-primary-button class="bg-teal-600 hover:bg-teal-700 py-3 px-8 text-base shadow-lg shadow-teal-100">
                                {{ __('Simpan Perubahan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPT SAMA PERSIS DENGAN CREATE.BLADE.PHP --}}
    <script>
        const dt = new DataTransfer(); 

        function addFiles(input) {
            const files = input.files;
            const previewContainer = document.getElementById("preview-container");
            
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                dt.items.add(file);

                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = "relative group w-full h-24 border border-teal-200 bg-teal-50 rounded-lg overflow-hidden"; // Beda warna dikit biar tau ini foto baru
                    
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = "w-full h-full object-cover opacity-80"; // Agak transparan menandakan 'draft'
                    
                    const btn = document.createElement('button');
                    btn.innerHTML = '&times;';
                    btn.className = "absolute top-1 right-1 bg-red-500 text-white w-5 h-5 rounded-full flex items-center justify-center text-xs hover:bg-red-600 transition shadow-md cursor-pointer";
                    btn.type = "button";
                    
                    btn.onclick = function() {
                        div.remove();
                        removeFileFromFileList(file.name);
                    };

                    // Label 'BARU'
                    const label = document.createElement('span');
                    label.innerText = "BARU";
                    label.className = "absolute bottom-1 right-1 bg-teal-600 text-white text-[9px] px-1 rounded opacity-80";

                    div.appendChild(img);
                    div.appendChild(btn);
                    div.appendChild(label);
                    previewContainer.appendChild(div);
                };
            }
            document.getElementById('real-input').files = dt.files;
            input.value = ''; 
        }

        function removeFileFromFileList(fileName) {
            const newDt = new DataTransfer();
            const currentFiles = dt.files;
            for (let i = 0; i < currentFiles.length; i++) {
                if (currentFiles[i].name !== fileName) {
                    newDt.items.add(currentFiles[i]);
                }
            }
            dt.items.clear();
            for (let i = 0; i < newDt.files.length; i++) {
                dt.items.add(newDt.files[i]);
            }
            document.getElementById('real-input').files = dt.files;
        }
    </script>
</x-admin-layout>
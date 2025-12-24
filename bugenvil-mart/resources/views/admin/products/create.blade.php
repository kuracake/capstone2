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
                            
                            {{-- 1. INPUT ASLI (Disembunyikan, ini yang dikirim ke Server) --}}
                            <input type="file" name="images[]" id="real-input" multiple class="hidden" required>

                            {{-- 2. INPUT PEMICU (Disembunyikan, cuma buat buka window file) --}}
                            <input type="file" id="trigger-input" multiple class="hidden" accept="image/*" onchange="addFiles(this)">

                            {{-- 3. AREA TOMBOL UPLOAD (Klik ini akan memicu trigger-input) --}}
                            <div onclick="document.getElementById('trigger-input').click()" 
                                 class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-teal-300 rounded-2xl cursor-pointer hover:bg-teal-50 hover:border-teal-500 transition-all group p-4 mb-4">
                                
                                <div class="flex flex-col items-center text-teal-500 group-hover:text-teal-700 transition">
                                    <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="2" stroke-linecap="round"/></svg>
                                    <span class="text-sm font-bold">Klik untuk Tambah Foto</span>
                                    <span class="text-xs text-gray-400 mt-1">(Bisa pilih satu per satu berulang kali)</span>
                                </div>
                            </div>

                            {{-- 4. CONTAINER PREVIEW (Menampilkan foto yang sudah ditampung) --}}
                            <div id="preview-container" class="grid grid-cols-3 gap-3 w-full">
                                {{-- Gambar akan muncul di sini via JS --}}
                            </div>

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

    {{-- SCRIPT BARU UNTUK FITUR 'SATU PER SATU' --}}
    <script>
        // Membuat "Keranjang File" sementara
        const dt = new DataTransfer(); 

        function addFiles(input) {
            const files = input.files;
            const previewContainer = document.getElementById("preview-container");
            
            // Loop setiap file yang baru dipilih
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                
                // Tambahkan file ke keranjang "dt"
                dt.items.add(file);

                // --- Buat Elemen Preview ---
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = "relative group w-full h-24 border border-gray-200 rounded-lg overflow-hidden";
                    
                    // Gambar
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = "w-full h-full object-cover";
                    
                    // Tombol Hapus (X)
                    const btn = document.createElement('button');
                    btn.innerHTML = '&times;';
                    btn.className = "absolute top-1 right-1 bg-red-500 text-white w-6 h-6 rounded-full flex items-center justify-center text-sm hover:bg-red-600 opacity-0 group-hover:opacity-100 transition shadow-md";
                    btn.type = "button"; // Penting agar tidak submit form
                    
                    // Logic Hapus File Tertentu
                    btn.onclick = function() {
                        // Hapus elemen visual
                        div.remove();
                        // Hapus file dari keranjang dt
                        removeFileFromFileList(file.name);
                    };

                    div.appendChild(img);
                    div.appendChild(btn);
                    previewContainer.appendChild(div);
                };
            }

            // Update Input Asli dengan isi keranjang terbaru
            document.getElementById('real-input').files = dt.files;

            // Reset input pemicu agar bisa memilih file yang sama lagi jika perlu
            input.value = ''; 
        }

        function removeFileFromFileList(fileName) {
            const newDt = new DataTransfer();
            const currentFiles = dt.files;

            // Masukkan kembali semua file KECUALI yang mau dihapus
            for (let i = 0; i < currentFiles.length; i++) {
                if (currentFiles[i].name !== fileName) {
                    newDt.items.add(currentFiles[i]);
                }
            }

            // Update keranjang utama & input asli
            dt.items.clear();
            for (let i = 0; i < newDt.files.length; i++) {
                dt.items.add(newDt.files[i]);
            }
            document.getElementById('real-input').files = dt.files;
        }
    </script>
</x-admin-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajukan Laporan Kerusakan/Retur') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Card Utama --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                
                {{-- Header Card: Ringkasan Pesanan --}}
                <div class="bg-gray-50 p-6 border-b border-gray-100 flex items-start gap-4">
                    <div class="p-3 bg-red-100 text-red-600 rounded-full shrink-0">
                         <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                          </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Pesanan #{{ $order->tracking_number }}</h3>
                        <p class="text-sm text-gray-600 mt-1">
                            Total Order: Rp {{ number_format($order->total_price, 0, ',', '.') }}<br>
                            Silakan isi formulir di bawah ini untuk melaporkan masalah pada pesanan ini.
                        </p>
                    </div>
                </div>

                {{-- Form Area --}}
                <div class="p-6">
                    @if ($errors->any())
                        <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-red-700">
                                        Terdapat kesalahan pada input Anda.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('reports.store', $order->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        {{-- INPUT 1: Deskripsi Masalah --}}
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Detail Kendala / Kerusakan <span class="text-red-500">*</span>
                            </label>
                            <textarea id="description" name="description" rows="4" 
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                placeholder="Jelaskan secara rinci kerusakan atau ketidaksesuaian yang Anda terima..." required>{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- INPUT 2: Bukti Foto (UI Kamera Modern) --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Bukti Foto Barang <span class="text-red-500">*</span>
                            </label>
                            
                            {{-- 
                                PERBAIKAN: 
                                - Input file sekarang memiliki 'absolute inset-0' dan 'opacity-0'.
                                - Posisinya ada di atas seluruh kotak (z-50).
                                - Ini membuat SELURUH kotak garis putus-putus bisa diklik.
                            --}}
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-red-400 transition-colors group relative bg-gray-50" id="image-dropzone">
                                
                                {{-- INPUT FILE TRANSFARAN (Covering the whole area) --}}
                                <input id="image-upload" name="image" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-50" accept="image/png, image/jpeg, image/jpg" capture="environment" required>

                                <div class="space-y-1 text-center pointer-events-none">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-red-500 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <span class="relative bg-white rounded-md font-medium text-red-600 px-2 group-hover:text-red-500">
                                            <span>Ambil Foto / Pilih File</span>
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, JPEG (Max. 2MB)</p>
                                </div>
                            </div>

                            {{-- Area Preview Gambar --}}
                            <div id="image-preview-container" class="mt-4 hidden">
                                <p class="text-sm font-medium text-gray-700 mb-2">Preview Foto:</p>
                                <img id="image-preview" src="#" alt="Preview Bukti" class="w-full max-h-64 object-cover rounded-lg border border-gray-200 shadow-sm">
                                <button type="button" id="remove-image-btn" class="mt-2 text-sm text-red-600 hover:text-red-800 font-medium flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414 1.414L4.293 15.707a1 1 0 010-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                      </svg>
                                    Hapus & Ganti Foto
                                </button>
                            </div>

                            @error('image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="flex items-center justify-end gap-4 border-t border-gray-100 pt-6">
                            <a href="{{ route('orders.show', $order->id) }}" class="text-gray-500 hover:text-gray-700 font-medium transition">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-3 bg-red-600 text-white font-bold rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition w-full sm:w-auto">
                                Kirim Laporan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Script JavaScript untuk Preview Gambar --}}
    <script>
        const imageUpload = document.getElementById('image-upload');
        const imagePreviewContainer = document.getElementById('image-preview-container');
        const imagePreview = document.getElementById('image-preview');
        const removeImageBtn = document.getElementById('remove-image-btn');
        const imageDropzone = document.getElementById('image-dropzone');

        // Saat file dipilih (dari kamera/galeri)
        imageUpload.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                // Buat pembaca file
                const reader = new FileReader();
                
                // Saat file selesai dibaca, tampilkan preview
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreviewContainer.classList.remove('hidden'); // Munculkan area preview
                    imageDropzone.classList.add('hidden'); // Sembunyikan area upload besar
                }
                
                reader.readAsDataURL(file);
            }
        });

        // Tombol Hapus Foto
        removeImageBtn.addEventListener('click', function() {
            imageUpload.value = ''; // Reset input file
            imagePreview.src = '#';
            imagePreviewContainer.classList.add('hidden'); // Sembunyikan preview
            imageDropzone.classList.remove('hidden'); // Munculkan kembali area upload besar
        });
    </script>
</x-app-layout>
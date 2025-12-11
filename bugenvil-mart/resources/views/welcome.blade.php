<x-app-layout>

    {{-- HERO SECTION --}}
    <div class="relative w-full h-[800px] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('img/background-utama.jpg') }}" alt="Background Bugenvil" class="w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 bg-black/50 z-10"></div>
        <div class="relative z-20 container mx-auto px-6 text-center text-white">
            <h1 class="text-5xl md:text-7xl font-bold serif mb-6 drop-shadow-lg">
                Bawa Keindahan Alam <br> Ke Taman Anda
            </h1>
            <p class="text-lg md:text-xl text-gray-100 mb-10 max-w-2xl mx-auto font-light leading-relaxed drop-shadow-md">
                Temukan koleksi premium bunga Bugenvil kami. Warna cerah, tanaman sehat, dikirim langsung ke depan pintu rumah Anda.
            </p>
            <a href="#products" class="inline-block bg-fuchsia-600 hover:bg-fuchsia-700 text-white font-bold py-4 px-12 rounded-full shadow-xl transition transform hover:scale-105">
                Belanja Sekarang
            </a>
        </div>
    </div>

    {{-- FITUR UNGGULAN --}}
    <div class="bg-white py-12">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="bg-fuchsia-100 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 text-fuchsia-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-800">Pengiriman Cepat</h3>
                    <p class="text-sm text-gray-500">Aman & Cepat Nasional</p>
                </div>
                <div>
                    <div class="bg-purple-100 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 text-purple-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-800">Tanaman Sehat</h3>
                    <p class="text-sm text-gray-500">Garansi Kualitas Bunga</p>
                </div>
                <div>
                    <div class="bg-fuchsia-100 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 text-fuchsia-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-800">Layanan 24/7</h3>
                    <p class="text-sm text-gray-500">Bantuan Ahli Kebun</p>
                </div>
                <div>
                    <div class="bg-purple-100 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 text-purple-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-800">Pembayaran Aman</h3>
                    <p class="text-sm text-gray-500">Transaksi Terjamin</p>
                </div>
            </div>
        </div>
    </div>

    {{-- PRODUK UNGGULAN --}}
    <div id="products" class="bg-pink-50 py-24">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-fuchsia-600 serif mb-4">Produk Unggulan</h2>
                <p class="text-gray-600 text-lg">Jelajahi varietas Bugenvil paling populer kami</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                @foreach($products as $product)
                <div class="bg-white rounded-3xl shadow-lg hover:shadow-xl transition overflow-hidden group border border-purple-50 flex flex-col h-full">
                    <div class="relative h-64 bg-gray-200 flex-shrink-0 cursor-pointer">
                        <a href="{{ route('products.show', $product->id) }}" class="block w-full h-full">
                            @php
                                $badges = ['Paling Laris', 'Tersedia', 'Baru', 'Favorit'];
                                $badge = $badges[array_rand($badges)];
                                $color = $badge == 'Paling Laris' ? 'bg-fuchsia-500' : ($badge == 'Tersedia' ? 'bg-green-500' : 'bg-orange-500');
                            @endphp
                            <span class="absolute top-4 right-4 {{ $color }} text-white text-xs font-bold px-3 py-1 rounded-full z-10">{{ $badge }}</span>
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://source.unsplash.com/random/400x400?bougainvillea,flower&sig='.$product->id }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </a>
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <a href="{{ route('products.show', $product->id) }}" class="hover:text-fuchsia-600 transition">
                            <h3 class="font-bold text-lg text-gray-800 mb-1 serif">{{ $product->name }}</h3>
                        </a>
                        <div class="flex text-yellow-400 text-xs mb-3">
                            ★★★★★ <span class="text-gray-400 ml-1">({{ rand(20, 100) }})</span>
                        </div>
                        <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-100">
                            <span class="text-xl font-bold text-fuchsia-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            @if(!Auth::check() || (Auth::check() && !Auth::user()->is_admin))
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-purple-100 text-purple-600 p-3 rounded-full hover:bg-fuchsia-500 hover:text-white transition shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-16">
                 <a href="{{ route('products.index') }}" class="bg-fuchsia-500 hover:bg-fuchsia-600 text-white font-bold py-3 px-10 rounded-full shadow-lg transition">Lihat Semua Produk</a>
            </div>
        </div>
    </div>

    {{-- VIDEO TUTORIAL --}}
    <section id="tutorials" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-fuchsia-600 font-bold tracking-wider uppercase text-sm">Edukasi Pelanggan</span>
                <h2 class="mt-2 text-4xl font-extrabold text-gray-900 serif">Video Tutorial & Panduan</h2>
                <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">
                    Pelajari cara merawat tanaman dan tips budidaya terbaik langsung dari ahli kami.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($videos as $video)
                    <div x-data="{ playing: false }" class="group bg-white rounded-[2rem] shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col h-full p-3">
                        <div class="relative h-60 rounded-[1.5rem] overflow-hidden bg-black">
                            <video
                                class="w-full h-full object-contain"
                                controls
                                preload="metadata"
                                poster="https://source.unsplash.com/random/800x450?garden,plant&sig={{ $video->id }}"
                                @play="playing = true"
                                @pause="playing = false"
                                @ended="playing = false"
                            >
                                <source src="{{ asset('storage/' . $video->video_url) }}" type="video/mp4">
                                Browser Anda tidak mendukung pemutar video.
                            </video>
                            <div x-show="!playing" class="absolute inset-0 flex items-center justify-center pointer-events-none bg-black/30 group-hover:bg-black/20 transition-colors">
                                <div class="w-16 h-16 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-fuchsia-600 pl-1">
                                        <path fill-rule="evenodd" d="M4.5 5.653c0-1.426 1.529-2.33 2.779-1.643l11.54 6.348c1.295.712 1.295 2.573 0 3.285L7.28 19.991c-1.25.687-2.779-.217-2.779-1.643V5.653z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 pt-5 pb-4 flex-1 flex flex-col">
                            <div class="mb-3">
                                <span class="inline-block bg-fuchsia-100 text-fuchsia-600 text-xs font-extrabold px-3 py-1.5 rounded-full tracking-wider uppercase">Tutorial</span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 leading-tight mb-2 line-clamp-2 group-hover:text-fuchsia-600 transition-colors">{{ $video->title }}</h3>
                            @if($video->description)
                                <p class="text-gray-500 text-sm line-clamp-3">{{ $video->description }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            @if($videos->isEmpty())
                <div class="text-center py-16 bg-white rounded-[2rem] shadow-sm border-2 border-dashed border-gray-200 mx-auto max-w-2xl">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Belum ada video tutorial</h3>
                    <p class="text-gray-500 max-w-md mx-auto">Kami sedang menyiapkan konten video menarik untuk Anda.</p>
                </div>
            @endif
        </div>
    </section>

    {{-- LAYANAN PENGADUAN & UPLOAD BUKTI --}}
    <div id="report-issue" class="bg-pink-50 pb-24 pt-10">
        <div class="container mx-auto px-6 flex justify-center">

            <div class="bg-white rounded-[2rem] shadow-2xl overflow-hidden max-w-5xl w-full flex flex-col md:flex-row">

                {{-- Kolom Kiri: Info --}}
                <div class="bg-[#d946ef] md:w-2/5 p-12 text-white flex flex-col justify-center relative overflow-hidden">
                    <div class="absolute -top-10 -left-10 w-40 h-40 bg-white/20 rounded-full blur-2xl"></div>
                    <div class="absolute bottom-10 right-10 w-32 h-32 bg-purple-600/20 rounded-full blur-xl"></div>
                    <div class="relative z-10">
                        <div class="bg-white/20 w-14 h-14 rounded-2xl flex items-center justify-center mb-6 backdrop-blur-sm shadow-inner">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <h2 class="text-3xl font-bold serif mb-4">Layanan Pengaduan</h2>
                        <p class="text-fuchsia-50 mb-8 leading-relaxed text-sm">
                            Sampaikan keluhan Anda beserta bukti foto agar kami dapat segera menanganinya.
                        </p>
                        <ul class="space-y-4 text-sm font-medium">
                            <li class="flex items-center gap-3"><div class="bg-white/20 p-1 rounded-full"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div> Respon cepat 1x24 jam</li>
                            <li class="flex items-center gap-3"><div class="bg-white/20 p-1 rounded-full"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div> Garansi ganti baru</li>
                        </ul>
                    </div>
                </div>

                {{-- Kolom Kanan: Form --}}
                <div class="bg-white md:w-3/5 p-12">
                    <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div>
                            <label class="block text-gray-700 font-bold mb-2 text-xs uppercase tracking-wide">Nomor Pesanan</label>
                            <input type="text" name="subject" class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:ring-fuchsia-500 focus:border-fuchsia-500 placeholder-gray-400" placeholder="Contoh: ORD-2024-001" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-bold mb-2 text-xs uppercase tracking-wide">Detail Kendala</label>
                            <textarea name="description" rows="3" class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:ring-fuchsia-500 focus:border-fuchsia-500 placeholder-gray-400 resize-none" placeholder="Jelaskan kondisi bunga..." required></textarea>
                        </div>

                        {{-- BAGIAN PILIHAN UPLOAD FOTO (MODIFIED) --}}
                        <div>
                            <label class="block text-gray-700 font-bold mb-3 text-xs uppercase tracking-wide">Unggah Foto Bukti</label>
                            
                            {{-- Input Tersembunyi --}}
                            <input type="file" id="evidenceInput" name="evidence" class="hidden" accept="image/*" onchange="previewFile()">

                            {{-- Area Pilihan Tombol --}}
                            <div class="grid grid-cols-2 gap-4 mb-3" id="uploadButtons">
                                {{-- Tombol 1: Galeri (Default) --}}
                                <button type="button" onclick="openGallery()" class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-gray-300 rounded-xl hover:bg-fuchsia-50 hover:border-fuchsia-500 transition group">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400 group-hover:text-fuchsia-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-sm font-bold text-gray-600 group-hover:text-fuchsia-600">Pilih dari Galeri</span>
                                </button>

                                {{-- Tombol 2: Kamera Langsung (Capture) --}}
                                <button type="button" onclick="openCamera()" class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-gray-300 rounded-xl hover:bg-fuchsia-50 hover:border-fuchsia-500 transition group">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400 group-hover:text-fuchsia-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="text-sm font-bold text-gray-600 group-hover:text-fuchsia-600">Ambil Foto (Kamera)</span>
                                </button>
                            </div>

                            {{-- Area Preview File --}}
                            <div id="filePreview" class="hidden bg-fuchsia-50 border border-fuchsia-200 rounded-lg p-3 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="bg-fuchsia-100 p-2 rounded-lg text-fuchsia-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <span id="fileName" class="text-sm text-gray-700 font-medium truncate max-w-[200px]">File Terpilih</span>
                                </div>
                                <button type="button" onclick="resetFile()" class="text-xs text-red-500 hover:text-red-700 font-bold hover:underline">Hapus</button>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-[#d946ef] text-white font-bold py-3.5 rounded-lg shadow-lg hover:bg-fuchsia-600 transition transform active:scale-95">
                            Kirim Laporan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Script untuk Logika Kamera vs Galeri --}}
    <script>
        function openGallery() {
            const input = document.getElementById('evidenceInput');
            input.removeAttribute('capture'); // Hapus mode kamera paksa
            input.click();
        }

        function openCamera() {
            const input = document.getElementById('evidenceInput');
            input.setAttribute('capture', 'environment'); // Paksa kamera belakang
            input.click();
        }

        function previewFile() {
            const input = document.getElementById('evidenceInput');
            const preview = document.getElementById('filePreview');
            const buttons = document.getElementById('uploadButtons');
            const fileName = document.getElementById('fileName');

            if (input.files && input.files[0]) {
                fileName.textContent = input.files[0].name;
                preview.classList.remove('hidden');
                // Opsional: Sembunyikan tombol biar rapi
                // buttons.classList.add('hidden'); 
            }
        }

        function resetFile() {
            const input = document.getElementById('evidenceInput');
            const preview = document.getElementById('filePreview');
            const buttons = document.getElementById('uploadButtons');
            
            input.value = ''; // Reset input
            preview.classList.add('hidden');
            // buttons.classList.remove('hidden');
        }
    </script>

</x-app-layout>
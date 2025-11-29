<x-app-layout>
    
    <div class="relative h-[600px] w-full bg-cover bg-center flex items-center" style="background-image: url('https://images.unsplash.com/photo-1572969032062-8e7c1f10777e?q=80&w=1920&auto=format&fit=crop');">
        <div class="absolute inset-0 bg-fuchsia-900/60 mix-blend-multiply"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-fuchsia-900/80 to-transparent"></div>

        <div class="container mx-auto px-6 relative z-10 text-white">
            <h1 class="text-5xl md:text-7xl font-bold serif mb-6 leading-tight">
                Bawa Keindahan Alam <br> Ke Taman Anda
            </h1>
            <p class="text-lg md:text-xl text-fuchsia-100 mb-8 max-w-xl font-light">
                Temukan koleksi premium bunga Bugenvil kami. Warna cerah, tanaman sehat, dikirim langsung ke depan pintu rumah Anda.
            </p>
            <div class="flex gap-4">
                <a href="#products" class="bg-fuchsia-500 hover:bg-fuchsia-600 text-white font-bold py-3 px-8 rounded-full shadow-lg transition transform hover:scale-105">
                    Belanja Sekarang
                </a>
                <a href="#tutorials" class="bg-transparent border-2 border-white text-white font-bold py-3 px-8 rounded-full hover:bg-white hover:text-fuchsia-900 transition">
                    Pelajari Lebih Lanjut
                </a>
            </div>
        </div>
    </div>

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
                        <a href="{{ route('product.detail', $product->id) }}" class="block w-full h-full">
                            @php 
                                $badges = ['Paling Laris', 'Tersedia', 'Baru', 'Favorit'];
                                $badge = $badges[array_rand($badges)];
                                $color = $badge == 'Paling Laris' ? 'bg-fuchsia-500' : ($badge == 'Tersedia' ? 'bg-green-500' : 'bg-orange-500');
                            @endphp
                            <span class="absolute top-4 right-4 {{ $color }} text-white text-xs font-bold px-3 py-1 rounded-full z-10">{{ $badge }}</span>
                            
                            <img src="{{ $product->image_path ? asset('storage/' . $product->image_path) : 'https://source.unsplash.com/random/400x400?bougainvillea,flower&sig='.$product->id }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </a>
                    </div>
                    
                    <div class="p-6 flex flex-col flex-grow">
                        <a href="{{ route('product.detail', $product->id) }}" class="hover:text-fuchsia-600 transition">
                            <h3 class="font-bold text-lg text-gray-800 mb-1 serif">{{ $product->name }}</h3>
                        </a>

                        <div class="flex text-yellow-400 text-xs mb-3">
                            ★★★★★ <span class="text-gray-400 ml-1">({{ rand(20, 100) }})</span>
                        </div>
                        
                        <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-100">
                            <span class="text-xl font-bold text-fuchsia-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            
                            @if(!Auth::check() || (Auth::check() && !Auth::user()->is_admin))
                                <a href="{{ route('cart.add', $product->id) }}" class="bg-purple-100 text-purple-600 p-3 rounded-full hover:bg-fuchsia-500 hover:text-white transition shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-16">
                 <a href="{{ route('products.all') }}" class="bg-fuchsia-500 hover:bg-fuchsia-600 text-white font-bold py-3 px-10 rounded-full shadow-lg transition">Lihat Semua Produk</a>
            </div>
        </div>
    </div>

    <div id="tutorials" class="bg-white py-20">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-fuchsia-500 serif mb-3">Tutorial Perawatan</h2>
                <p class="text-gray-500">Pelajari cara merawat bunga Bugenvil Anda</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($videos as $index => $video)
                <div class="bg-pink-50 rounded-3xl p-6 hover:shadow-lg transition">
                    <div class="relative h-48 rounded-2xl overflow-hidden mb-6 group cursor-pointer">
                        <img src="https://source.unsplash.com/random/400x300?gardening&sig={{$index}}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-black/10 transition"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="bg-white w-12 h-12 rounded-full flex items-center justify-center text-fuchsia-600 shadow-lg group-hover:scale-110 transition">
                                <svg class="w-6 h-6 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            </div>
                        </div>
                        <a href="{{ $video->video_url }}" target="_blank" class="absolute inset-0 z-10"></a>
                    </div>

                    <div class="flex justify-between items-center mb-2">
                        <span class="bg-fuchsia-100 text-fuchsia-600 text-xs font-bold px-2 py-1 rounded">Langkah {{ $index + 1 }}</span>
                        <span class="text-gray-400 text-xs flex items-center"><svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> {{ rand(3,10) }}:00</span>
                    </div>

                    <h3 class="font-bold text-xl text-gray-800 mb-2 serif">{{ $video->title }}</h3>
                    <p class="text-sm text-gray-500 mb-4">{{ Str::limit($video->description, 60) }}</p>
                    
                    <a href="{{ $video->video_url }}" class="text-fuchsia-600 font-bold text-sm flex items-center hover:underline">
                        Tonton Tutorial <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="bg-pink-50 py-20">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-fuchsia-500 serif mb-3">Ulasan Pelanggan</h2>
                <p class="text-gray-500">Lihat apa kata pelanggan bahagia kami</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-3xl shadow-sm">
                    <div class="text-yellow-400 text-sm mb-4">★★★★★</div>
                    <p class="text-gray-600 italic mb-6">"Bunga-bunga yang benar-benar menakjubkan! Sampai dalam kondisi sempurna dan kemasannya sangat bagus. Video tutorial sangat membantu."</p>
                    <div class="flex items-center gap-4">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" class="w-12 h-12 rounded-full">
                        <div>
                            <h4 class="font-bold text-sm">Siti Aminah</h4>
                            <p class="text-xs text-green-500">Pembeli Terverifikasi</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-sm">
                    <div class="text-yellow-400 text-sm mb-4">★★★★★</div>
                    <p class="text-gray-600 italic mb-6">"Layanan pelanggan yang hebat! Saya memiliki sedikit masalah pengiriman dan mereka menyelesaikannya dengan cepat. Kualitas tanaman luar biasa."</p>
                    <div class="flex items-center gap-4">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" class="w-12 h-12 rounded-full">
                        <div>
                            <h4 class="font-bold text-sm">Budi Santoso</h4>
                            <p class="text-xs text-green-500">Pembeli Terverifikasi</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-sm">
                    <div class="text-yellow-400 text-sm mb-4">★★★★★</div>
                    <p class="text-gray-600 italic mb-6">"Taman saya terlihat luar biasa sekarang! Warnanya sangat cerah dan tanamannya tumbuh subur. Sangat merekomendasikan BougainVilla!"</p>
                    <div class="flex items-center gap-4">
                        <img src="https://randomuser.me/api/portraits/women/68.jpg" class="w-12 h-12 rounded-full">
                        <div>
                            <h4 class="font-bold text-sm">Rina Wati</h4>
                            <p class="text-xs text-green-500">Pembeli Terverifikasi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="report-issue" class="bg-pink-50 pb-24 pt-10">
        <div class="container mx-auto px-6 flex justify-center">
            
            <div class="bg-white rounded-[2rem] shadow-2xl overflow-hidden max-w-5xl w-full flex flex-col md:flex-row">
                
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
                            Apakah pesanan Anda mengalami kendala? Kami berkomitmen memberikan garansi kepuasan. Sampaikan keluhan Anda, dan kami akan segera menanganinya.
                        </p>

                        <ul class="space-y-4 text-sm font-medium">
                            <li class="flex items-center gap-3">
                                <div class="bg-white/20 p-1 rounded-full"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div>
                                Respon cepat maksimal 1x24 jam
                            </li>
                            <li class="flex items-center gap-3">
                                <div class="bg-white/20 p-1 rounded-full"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div>
                                Garansi ganti baru atau uang kembali
                            </li>
                            <li class="flex items-center gap-3">
                                <div class="bg-white/20 p-1 rounded-full"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div>
                                Transparansi status laporan
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="bg-white md:w-3/5 p-12">
                    <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label class="block text-gray-700 font-bold mb-2 text-xs uppercase tracking-wide">Nomor Pesanan</label>
                            <input type="text" name="subject" class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:ring-fuchsia-500 focus:border-fuchsia-500 placeholder-gray-400" placeholder="Contoh: ORD-2024-001" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-bold mb-2 text-xs uppercase tracking-wide">Detail Kendala</label>
                            <textarea name="description" rows="4" class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:ring-fuchsia-500 focus:border-fuchsia-500 placeholder-gray-400 resize-none" placeholder="Mohon jelaskan kondisi bunga saat diterima (layu, patah, atau kemasan rusak)..." required></textarea>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-bold mb-2 text-xs uppercase tracking-wide">Unggah Foto Bukti</label>
                            <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:bg-gray-50 transition cursor-pointer relative group">
                                <input type="file" name="evidence" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" required accept="image/*">
                                <div class="flex flex-col items-center">
                                    <svg class="h-10 w-10 text-gray-400 group-hover:text-fuchsia-500 transition" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-600 font-medium">Klik untuk unggah atau tarik berkas ke sini</p>
                                    <p class="mt-1 text-xs text-gray-400">Format: JPG, PNG (Maks. 10MB)</p>
                                </div>
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

</x-app-layout>
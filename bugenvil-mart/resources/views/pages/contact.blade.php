<x-app-layout>
    {{-- 1. HERO HEADER --}}
    <div class="bg-fuchsia-900 py-16 md:py-20 relative overflow-hidden">
        {{-- Elemen Dekorasi --}}
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full translate-x-1/2 -translate-y-1/2 blur-2xl"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full -translate-x-1/2 translate-y-1/2 blur-2xl"></div>
        
        <div class="container mx-auto px-6 text-center relative z-10">
            <h1 class="text-3xl md:text-5xl font-bold text-white mb-4 font-serif tracking-wide">
                Hubungi Kami
            </h1>
            <p class="text-fuchsia-100 max-w-2xl mx-auto text-base md:text-lg font-light leading-relaxed">
                Kami siap membantu menjawab pertanyaan Anda seputar perawatan tanaman dan pesanan.
            </p>
        </div>
    </div>

    {{-- 2. KONTEN UTAMA --}}
    <div class="bg-gray-50 py-12 md:py-16">
        <div class="container mx-auto px-6">
            
            {{-- BAGIAN A: KARTU INFORMASI --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12 md:mb-16">
                
                {{-- Info 1: Telepon --}}
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 text-center hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-fuchsia-50 text-fuchsia-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    </div>
                    <h3 class="font-bold text-lg text-gray-900 mb-2">WhatsApp / Telepon</h3>
                    <p class="text-sm text-gray-500 mb-4">Senin - Minggu, 08:00 - 21:00</p>
                    <a href="https://wa.me/6285736383649" class="inline-block px-4 py-2 bg-fuchsia-50 text-fuchsia-700 rounded-full text-sm font-bold hover:bg-fuchsia-100 transition">
                        +62 857-3638-3649
                    </a>
                </div>

                {{-- Info 2: Email --}}
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 text-center hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="font-bold text-lg text-gray-900 mb-2">Email Support</h3>
                    <p class="text-sm text-gray-500 mb-4">Respon cepat dalam 24 jam</p>
                    <a href="mailto:halo@aininarstore.com" class="inline-block px-4 py-2 bg-purple-50 text-purple-700 rounded-full text-sm font-bold hover:bg-purple-100 transition">
                        halo@aininarstore.com
                    </a>
                </div>

                {{-- Info 3: Lokasi (SUDAH DIUPDATE) --}}
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 text-center hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-fuchsia-50 text-fuchsia-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-lg text-gray-900 mb-2">Lokasi Toko</h3>
                    <p class="text-sm text-gray-500 mb-4">Kunjungi kebun kami langsung</p>
                    <span class="inline-block px-4 py-2 bg-gray-100 text-gray-700 rounded-full text-xs font-bold leading-relaxed">
                        Jl. Nasional III No.22, Tulungagung
                    </span>
                </div>
            </div>

            {{-- BAGIAN B: FORM & PETA --}}
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="flex flex-col lg:flex-row">
                    
                    {{-- 1. Formulir Pesan --}}
                    <div class="w-full lg:w-1/2 p-8 md:p-12">
                        <h2 class="text-2xl md:text-3xl font-bold font-serif text-gray-800 mb-6">Kirim Pesan</h2>
                        
                        <form onsubmit="alert('Pesan terkirim! Terima kasih.'); return false;">
                            <div class="space-y-5">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                                        <input type="text" class="w-full rounded-xl border-gray-300 focus:border-fuchsia-500 focus:ring-fuchsia-500 transition shadow-sm" placeholder="Nama Anda" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                                        <input type="email" class="w-full rounded-xl border-gray-300 focus:border-fuchsia-500 focus:ring-fuchsia-500 transition shadow-sm" placeholder="email@contoh.com" required>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Subjek</label>
                                    <input type="text" class="w-full rounded-xl border-gray-300 focus:border-fuchsia-500 focus:ring-fuchsia-500 transition shadow-sm" placeholder="Tanya Stok / Konsultasi" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Isi Pesan</label>
                                    <textarea rows="5" class="w-full rounded-xl border-gray-300 focus:border-fuchsia-500 focus:ring-fuchsia-500 transition shadow-sm" placeholder="Tulis pesan Anda disini..." required></textarea>
                                </div>

                                <button type="submit" class="w-full bg-fuchsia-700 hover:bg-fuchsia-800 text-white font-bold py-4 rounded-xl shadow-md transition transform active:scale-95">
                                    Kirim Pesan Sekarang
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- 2. Google Maps (SUDAH DIUPDATE) --}}
                    <div class="w-full lg:w-1/2 bg-gray-200 min-h-[400px] lg:min-h-auto relative">
                        {{-- Menggunakan Maps Embed API dengan alamat spesifik Anda --}}
                        <iframe 
                            src="https://maps.google.com/maps?q=Jl.+Nasional+III+No.22,+Gempol,+Sumberdadi,+Kec.+Sumbergempol,+Kabupaten+Tulungagung,+Jawa+Timur+66291&t=&z=15&ie=UTF8&iwloc=&output=embed"
                            class="absolute inset-0 w-full h-full border-0" 
                            allowfullscreen="" 
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
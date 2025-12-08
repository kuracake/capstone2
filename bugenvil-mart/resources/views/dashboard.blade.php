<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Akun Saya') }}
        </h2>
    </x-slot>

    <!-- Container Utama dengan Alpine.js untuk Tab & Preview Gambar -->
    <div class="py-10 bg-gray-50 min-h-screen" x-data="{ 
        activeTab: 'profile',
        photoName: null,
        photoPreview: null,
        updatePhotoPreview() {
            const file = this.$refs.photo.files[0];
            if (! file) return;
            this.photoName = file.name;
            const reader = new FileReader();
            reader.onload = (e) => { this.photoPreview = e.target.result; };
            reader.readAsDataURL(file);
        }
    }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Grid Layout: Sidebar (Kiri) & Konten (Kanan) -->
            <div class="flex flex-col md:flex-row gap-6">

                <!-- 1. SIDEBAR MENU -->
                <div class="w-full md:w-1/4">
                    
                    <!-- Kartu Profil Mini -->
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4 mb-4">
                        <!-- Foto Profil Mini (Sinkron dengan Preview) -->
                        <div class="w-14 h-14 bg-fuchsia-100 rounded-full flex-shrink-0 flex items-center justify-center text-fuchsia-600 font-bold text-2xl border-2 border-white shadow-sm overflow-hidden">
                            <template x-if="photoPreview">
                                <img :src="photoPreview" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!photoPreview">
                                <span>{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </template>
                        </div>
                        <div class="overflow-hidden">
                            <h4 class="font-bold text-gray-800 truncate text-sm">{{ Auth::user()->name }}</h4>
                            <button @click="activeTab = 'profile'" class="text-xs text-gray-500 flex items-center hover:text-fuchsia-600 mt-1 transition">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                Edit Profil
                            </button>
                        </div>
                    </div>

                    <!-- Navigasi Menu -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <nav class="flex flex-col py-2">
                            <!-- Tombol Akun Saya -->
                            <button @click="activeTab = 'profile'" 
                                :class="activeTab === 'profile' ? 'text-fuchsia-600 font-bold bg-fuchsia-50 border-l-4 border-fuchsia-600' : 'text-gray-600 hover:text-fuchsia-600 hover:bg-gray-50 border-l-4 border-transparent'"
                                class="flex items-center gap-3 px-4 py-3 text-sm transition-all w-full text-left">
                                <div class="w-6 text-center"><svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg></div>
                                Akun Saya
                            </button>

                            <!-- Tombol Pesanan Saya -->
                            <button @click="activeTab = 'orders'" 
                                :class="activeTab === 'orders' ? 'text-fuchsia-600 font-bold bg-fuchsia-50 border-l-4 border-fuchsia-600' : 'text-gray-600 hover:text-fuchsia-600 hover:bg-gray-50 border-l-4 border-transparent'"
                                class="flex items-center gap-3 px-4 py-3 text-sm transition-all w-full text-left">
                                <div class="w-6 text-center"><svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg></div>
                                Pesanan Saya
                            </button>

                            <!-- Tombol Notifikasi -->
                            <button @click="activeTab = 'notifications'" 
                                :class="activeTab === 'notifications' ? 'text-fuchsia-600 font-bold bg-fuchsia-50 border-l-4 border-fuchsia-600' : 'text-gray-600 hover:text-fuchsia-600 hover:bg-gray-50 border-l-4 border-transparent'"
                                class="flex items-center gap-3 px-4 py-3 text-sm transition-all w-full text-left">
                                <div class="w-6 text-center"><svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg></div>
                                Notifikasi
                            </button>
                        </nav>
                    </div>
                </div>

                <!-- 2. KONTEN UTAMA (KANAN) -->
                <div class="w-full md:w-3/4">
                    
                    <!-- TAB 1: FORMULIR EDIT PROFIL -->
                    <div x-show="activeTab === 'profile'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                        <div class="border-b border-gray-100 pb-4 mb-6">
                            <h3 class="text-xl font-bold text-gray-800">Profil Saya</h3>
                            <p class="text-sm text-gray-500">Kelola informasi profil Anda untuk mengontrol, melindungi dan mengamankan akun</p>
                        </div>
                        
                        <!-- Form Update Profil -->
                        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="flex flex-col-reverse md:flex-row gap-8">
                            @csrf
                            @method('patch')

                            <!-- Kolom Kiri: Input Data -->
                            <div class="flex-1 space-y-5 pr-0 md:pr-8">
                                <!-- Username (Static) -->
                                <div class="grid grid-cols-1 md:grid-cols-3 items-center gap-2">
                                    <label class="text-gray-500 text-sm md:text-right">Username</label>
                                    <div class="col-span-2 text-gray-800 font-medium">{{ Auth::user()->name }}</div>
                                </div>

                                <!-- Nama (Input) -->
                                <div class="grid grid-cols-1 md:grid-cols-3 items-center gap-2">
                                    <label for="name" class="text-gray-500 text-sm md:text-right">Nama</label>
                                    <div class="col-span-2">
                                        <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" class="w-full border-gray-300 rounded-lg text-sm focus:border-fuchsia-500 focus:ring-fuchsia-500 shadow-sm transition" required>
                                        <x-input-error class="mt-1" :messages="$errors->get('name')" />
                                    </div>
                                </div>

                                <!-- Email (Input) -->
                                <div class="grid grid-cols-1 md:grid-cols-3 items-center gap-2">
                                    <label for="email" class="text-gray-500 text-sm md:text-right">Email</label>
                                    <div class="col-span-2">
                                        <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" class="w-full border-gray-300 rounded-lg text-sm focus:border-fuchsia-500 focus:ring-fuchsia-500 shadow-sm transition" required>
                                        <x-input-error class="mt-1" :messages="$errors->get('email')" />
                                    </div>
                                </div>

                                <!-- Nomor Telepon (UI Only - Belum ada di DB) -->
                                <div class="grid grid-cols-1 md:grid-cols-3 items-center gap-2">
                                    <label class="text-gray-500 text-sm md:text-right">Nomor Telepon</label>
                                    <div class="col-span-2">
                                        <input type="text" placeholder="Masukkan nomor telepon" class="w-full border-gray-300 rounded-lg text-sm focus:border-fuchsia-500 focus:ring-fuchsia-500 shadow-sm bg-gray-50" disabled title="Fitur akan segera hadir">
                                    </div>
                                </div>

                                <!-- Jenis Kelamin (UI Only) -->
                                <div class="grid grid-cols-1 md:grid-cols-3 items-center gap-2">
                                    <label class="text-gray-500 text-sm md:text-right">Jenis Kelamin</label>
                                    <div class="col-span-2 flex gap-4">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="gender" class="text-fuchsia-600 focus:ring-fuchsia-500" disabled>
                                            <span class="text-sm text-gray-600">Laki-laki</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" name="gender" class="text-fuchsia-600 focus:ring-fuchsia-500" disabled>
                                            <span class="text-sm text-gray-600">Perempuan</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Tombol Simpan -->
                                <div class="grid grid-cols-1 md:grid-cols-3 items-center gap-2 pt-4">
                                    <div class="col-start-2 col-span-2">
                                        <button type="submit" class="bg-fuchsia-600 text-white px-6 py-2.5 rounded-lg text-sm font-bold hover:bg-fuchsia-700 transition shadow-md w-full md:w-auto">
                                            Simpan Perubahan
                                        </button>
                                        @if (session('status') === 'profile-updated')
                                            <span x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600 ml-3">
                                                ✅ Disimpan.
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Kolom Kanan: Foto Profil -->
                            <div class="flex flex-col items-center justify-start border-l-0 md:border-l border-gray-100 md:pl-8 w-full md:w-1/3 pt-4">
                                <!-- Lingkaran Foto -->
                                <div class="w-32 h-32 bg-gray-100 rounded-full mb-6 flex items-center justify-center text-gray-300 text-5xl overflow-hidden border-4 border-white shadow-md relative group">
                                    <template x-if="photoPreview">
                                        <img :src="photoPreview" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!photoPreview">
                                        <!-- Placeholder inisial nama -->
                                        <span class="font-bold text-fuchsia-300 select-none">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    </template>
                                </div>

                                <!-- Input File Tersembunyi -->
                                <input type="file" name="photo" x-ref="photo" class="hidden" @change="updatePhotoPreview()" accept="image/*">

                                <!-- Tombol Pilih Gambar -->
                                <button type="button" x-on:click.prevent="$refs.photo.click()" class="px-5 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-fuchsia-600 transition mb-3 shadow-sm bg-white">
                                    Pilih Gambar
                                </button>
                                
                                <p class="text-xs text-gray-400 text-center leading-relaxed max-w-[200px]">
                                    Ukuran gambar: maks. 1 MB<br>Format: .JPEG, .PNG
                                </p>
                            </div>
                        </form>
                    </div>

                    <!-- TAB 2: PESANAN SAYA (Tidak Berubah) -->
                    <div x-show="activeTab === 'orders'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" class="space-y-4">
                        <div class="bg-white rounded-t-xl shadow-sm border-b border-gray-200 flex overflow-x-auto no-scrollbar">
                            <button class="flex-1 py-4 text-sm font-medium text-center border-b-2 border-fuchsia-600 text-fuchsia-600 px-6 whitespace-nowrap">Semua</button>
                            <button class="flex-1 py-4 text-sm font-medium text-center border-b-2 border-transparent text-gray-500 hover:text-fuchsia-600 px-6 whitespace-nowrap">Belum Bayar</button>
                            <button class="flex-1 py-4 text-sm font-medium text-center border-b-2 border-transparent text-gray-500 hover:text-fuchsia-600 px-6 whitespace-nowrap">Dikemas</button>
                            <button class="flex-1 py-4 text-sm font-medium text-center border-b-2 border-transparent text-gray-500 hover:text-fuchsia-600 px-6 whitespace-nowrap">Dikirim</button>
                            <button class="flex-1 py-4 text-sm font-medium text-center border-b-2 border-transparent text-gray-500 hover:text-fuchsia-600 px-6 whitespace-nowrap">Selesai</button>
                        </div>

                        @if(Auth::user()->orders->count() > 0)
                            @foreach(Auth::user()->orders as $order)
                                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                                    <div class="flex justify-between items-center border-b border-gray-50 pb-4 mb-4">
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-gray-800 text-sm">Bugenvil Mart</span>
                                            <span class="bg-fuchsia-600 text-white text-[10px] px-2 py-0.5 rounded">Official Store</span>
                                            <span class="text-gray-400 text-xs mx-2">|</span>
                                            <span class="text-xs text-gray-500">{{ $order->created_at->format('d M Y') }}</span>
                                        </div>
                                        <div class="text-sm font-bold text-fuchsia-600 uppercase tracking-wide">
                                            @if($order->status == 'pending') MENUNGGU PEMBAYARAN
                                            @elseif($order->status == 'packing') SEDANG DIKEMAS
                                            @elseif($order->status == 'shipping') SEDANG DIKIRIM
                                            @elseif($order->status == 'completed') SELESAI
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex gap-4">
                                        <div class="w-20 h-20 bg-gray-100 rounded-lg flex-shrink-0 overflow-hidden border border-gray-200">
                                            <img src="https://source.unsplash.com/random/150x150?flower&sig={{ $order->id }}" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-bold text-gray-800 text-sm">Pesanan #{{ $order->tracking_number }}</h4>
                                            <p class="text-xs text-gray-500 mt-1 line-clamp-1">
                                                @if($order->items->count() > 0)
                                                    {{ $order->items->first()->product_name }} 
                                                    @if($order->items->count() > 1) 
                                                        dan {{ $order->items->count() - 1 }} barang lainnya... 
                                                    @endif
                                                @else
                                                    Detail produk tidak tersedia
                                                @endif
                                            </p>
                                            <div class="text-xs text-gray-500 mt-2 bg-gray-50 inline-block px-2 py-1 rounded">
                                                x{{ $order->items->sum('quantity') }} Produk
                                            </div>
                                        </div>
                                        <div class="text-right flex flex-col justify-center">
                                            <span class="text-xs text-gray-400 line-through">Rp {{ number_format($order->total_price * 1.1) }}</span>
                                            <span class="text-fuchsia-600 font-bold text-base">Rp {{ number_format($order->total_price) }}</span>
                                        </div>
                                    </div>

                                    <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-50">
                                        @if($order->status == 'completed')
                                            <button class="px-6 py-2 bg-fuchsia-600 text-white rounded-lg text-sm font-bold hover:bg-fuchsia-700 transition shadow-sm">
                                                Beli Lagi
                                            </button>
                                        @else
                                            <button class="px-6 py-2 border border-gray-300 text-gray-600 rounded-lg text-sm font-medium hover:bg-gray-50 transition">
                                                Hubungi Penjual
                                            </button>
                                            <button class="px-6 py-2 bg-fuchsia-600 text-white rounded-lg text-sm font-bold hover:bg-fuchsia-700 transition shadow-sm">
                                                Rincian Pesanan
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="bg-white p-12 rounded-xl shadow-sm text-center flex flex-col items-center border border-gray-100">
                                <div class="w-32 h-32 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                </div>
                                <p class="text-gray-500 font-medium">Belum ada pesanan.</p>
                                <a href="{{ route('products.all') }}" class="mt-4 px-6 py-2 bg-fuchsia-600 text-white rounded-lg text-sm font-bold hover:bg-fuchsia-700 transition">
                                    Mulai Belanja
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- TAB 3: NOTIFIKASI (Tidak Berubah) -->
                    <div x-show="activeTab === 'notifications'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" class="bg-white rounded-2xl shadow-sm border border-gray-100">
                        <div class="p-4 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="font-bold text-gray-800">Notifikasi</h3>
                            <button class="text-xs text-fuchsia-600 hover:underline">Tandai sudah dibaca</button>
                        </div>
                        
                        <div class="divide-y divide-gray-50">
                            <div class="flex gap-4 p-4 hover:bg-fuchsia-50/50 transition cursor-pointer bg-white">
                                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center text-orange-600 flex-shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800 text-sm">Pesanan Dikemas</h4>
                                    <p class="text-sm text-gray-600 mt-1 leading-relaxed">Paket untuk pesanan <span class="font-medium text-fuchsia-600">#INV-29384</span> sedang disiapkan oleh penjual.</p>
                                    <span class="text-xs text-gray-400 mt-2 block">10:45 05-12-2025</span>
                                </div>
                            </div>
                            <div class="flex gap-4 p-4 hover:bg-fuchsia-50/50 transition cursor-pointer bg-white">
                                <div class="w-12 h-12 bg-fuchsia-100 rounded-lg flex items-center justify-center text-fuchsia-600 flex-shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800 text-sm">Promo Spesial Payday!</h4>
                                    <p class="text-sm text-gray-600 mt-1 leading-relaxed">Nikmati diskon hingga <span class="font-bold text-red-500">50%</span> untuk pembelian Bugenvil Import.</p>
                                    <span class="text-xs text-gray-400 mt-2 block">Kemarin 09:00</span>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 border-t border-gray-100 text-center">
                            <button class="text-sm text-gray-500 hover:text-fuchsia-600 font-medium">Lihat Semua Notifikasi</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
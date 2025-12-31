<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Ainin Ar Store') }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
        [x-cloak] { display: none !important; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e0e0e0; border-radius: 4px; }
        
        @keyframes bounce-short {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-25%); }
        }
        .animate-bounce-short {
            animation: bounce-short 0.5s ease-in-out 2;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased flex flex-col min-h-screen">

    {{-- NAVBAR --}}
    <nav x-data="{ open: false, scrolled: false }" 
         @scroll.window="scrolled = (window.pageYOffset > 20)"
         :class="{'bg-white/95 backdrop-blur-md shadow-sm': scrolled, 'bg-white': !scrolled}"
         class="fixed w-full top-0 z-50 transition-all duration-300 border-b border-gray-100">
        
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 md:h-20">
                
                {{-- LOGO BRAND (Hanya Teks) --}}
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="group flex items-center gap-2">
                        <div class="flex flex-col">
                            {{-- LOGO UTAMA --}}
                            <span class="text-lg md:text-2xl font-bold font-serif text-transparent bg-clip-text bg-gradient-to-r from-fuchsia-700 to-purple-600 tracking-tight leading-none group-hover:opacity-80 transition">
                                Ainin Ar Store
                            </span>
                            {{-- SUBTITLE --}}
                            <span class="text-[9px] md:text-[10px] text-fuchsia-500 font-medium tracking-[0.2em] uppercase mt-0.5 ml-0.5">
                                Eko Bugenvil 
                            </span>
                        </div>
                    </a>
                </div>

                {{-- MENU DESKTOP --}}
                <div class="hidden md:flex space-x-8 items-center">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">Beranda</x-nav-link>
                    <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')">Produk</x-nav-link>
                    <x-nav-link :href="route('tutorials.all')" :active="request()->routeIs('tutorials.all')">Tutorial</x-nav-link>
                    <x-nav-link :href="route('contact')" :active="request()->routeIs('contact')">Kontak</x-nav-link>
                </div>

                {{-- KANAN: ICON GROUP (Desktop) --}}
                <div class="hidden md:flex items-center gap-4">
                    
                    {{-- 1. KERANJANG --}}
                    <a href="{{ route('cart.index') }}" class="relative group text-gray-500 hover:text-fuchsia-600 transition p-2 rounded-full hover:bg-fuchsia-50">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        @auth
                            @php $cartCount = \App\Models\CartItem::where('user_id', Auth::id())->sum('quantity'); @endphp
                            @if($cartCount > 0)
                                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 border-2 border-white text-xs font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-red-500 rounded-full animate-bounce-short">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        @endauth
                    </a>

                    @auth
                        {{-- 2. NOTIFIKASI --}}
                        <div class="relative" x-data="{ openNotif: false }">
                            <button @click="openNotif = !openNotif" class="relative p-2 text-gray-500 hover:text-fuchsia-600 rounded-full hover:bg-fuchsia-50 transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                @if(Auth::user()->unreadNotifications->count() > 0)
                                    <span class="absolute top-1 right-1 flex h-2.5 w-2.5">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500 border border-white"></span>
                                    </span>
                                @endif
                            </button>

                            <div x-show="openNotif" 
                                 @click.outside="openNotif = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-3 w-80 bg-white rounded-xl shadow-xl border border-gray-100 z-50 overflow-hidden" 
                                 style="display: none;">
                                <div class="px-4 py-3 border-b border-gray-50 bg-gray-50 flex justify-between items-center">
                                    <span class="font-bold text-xs text-gray-500 uppercase">Notifikasi</span>
                                    @if(Auth::user()->unreadNotifications->count() > 0)
                                        <span class="text-[10px] bg-fuchsia-100 text-fuchsia-600 px-2 py-0.5 rounded-full font-bold">{{ Auth::user()->unreadNotifications->count() }} Baru</span>
                                    @endif
                                </div>
                                <div class="max-h-80 overflow-y-auto custom-scrollbar">
                                    @forelse(Auth::user()->notifications as $notification)
                                        <a href="{{ route('user.notification.read', $notification->id) }}" class="block p-4 hover:bg-fuchsia-50 transition border-b border-gray-50 {{ $notification->read_at ? 'opacity-60' : 'bg-fuchsia-50/20' }}">
                                            <div class="flex gap-3">
                                                <div class="flex-shrink-0 mt-1">
                                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-500 flex items-center justify-center">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                    </div>
                                                </div>
                                                <div>
                                                    <p class="text-sm text-gray-800 font-semibold leading-snug">{{ $notification->data['message'] }}</p>
                                                    <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        </a>
                                    @empty
                                        <div class="py-8 text-center text-gray-400 text-sm">Belum ada notifikasi.</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <div class="h-6 w-px bg-gray-200 mx-2"></div>

                        {{-- 3. PROFIL --}}
                        <div x-data="{ dropdownOpen: false }" class="relative">
                            <button @click="dropdownOpen = !dropdownOpen" @click.away="dropdownOpen = false" class="flex items-center gap-3 focus:outline-none group">
                                <div class="text-right hidden lg:block">
                                    <p class="text-xs text-gray-500">Halo,</p>
                                    <p class="text-sm font-bold text-gray-700 group-hover:text-fuchsia-700 transition">{{ Auth::user()->name }}</p>
                                </div>
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="h-10 w-10 rounded-full object-cover border-2 border-fuchsia-100 shadow-sm group-hover:border-fuchsia-300 transition">
                                @else
                                    <div class="h-10 w-10 rounded-full bg-fuchsia-100 text-fuchsia-600 flex items-center justify-center font-bold text-lg border border-fuchsia-200">{{ substr(Auth::user()->name, 0, 1) }}</div>
                                @endif
                            </button>
                            <div x-show="dropdownOpen" style="display: none;" class="absolute right-0 mt-3 w-48 bg-white rounded-xl shadow-xl py-2 border border-gray-100 z-50">
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-fuchsia-50 hover:text-fuchsia-700">Dashboard</a>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-fuchsia-50 hover:text-fuchsia-700">Profil Saya</a>
                                <div class="border-t border-gray-100 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Keluar</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-3">
                            <a href="{{ route('login') }}" class="text-sm font-bold text-gray-600 hover:text-fuchsia-600 transition">Masuk</a>
                            <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-bold text-white bg-gray-900 rounded-full hover:bg-fuchsia-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">Daftar</a>
                        </div>
                    @endauth
                </div>

                {{-- TOMBOL MOBILE (Cart + Hamburger) --}}
                <div class="flex items-center gap-3 md:hidden">
                    <a href="{{ route('cart.index') }}" class="relative text-gray-600 p-2 hover:bg-gray-100 rounded-full transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        @auth
                            @if(isset($cartCount) && $cartCount > 0)
                                <span class="absolute top-1 right-1 bg-red-500 text-white text-[9px] font-bold rounded-full h-3.5 w-3.5 flex items-center justify-center">{{ $cartCount }}</span>
                            @endif
                        @endauth
                    </a>
                    
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-lg text-gray-600 hover:text-fuchsia-600 hover:bg-fuchsia-50 focus:outline-none transition border border-gray-200">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- MOBILE MENU DROPDOWN --}}
        <div x-show="open" x-transition class="md:hidden border-t border-gray-100 bg-white shadow-lg h-screen overflow-y-auto pb-20">
            <div class="pt-2 pb-3 space-y-1 px-4">
                <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">Beranda</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')">Produk</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('tutorials.all')" :active="request()->routeIs('tutorials.all')">Tutorial</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('contact')" :active="request()->routeIs('contact')">Kontak</x-responsive-nav-link>
            </div>
            
            <div class="pt-4 pb-6 border-t border-gray-100 px-4 bg-gray-50">
                @auth
                    @if(Auth::user()->unreadNotifications->count() > 0)
                        <div class="mb-6 bg-white p-4 rounded-xl border border-fuchsia-100 shadow-sm">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                                <p class="text-xs font-bold text-gray-500 uppercase">Notifikasi Baru</p>
                            </div>
                            <div class="space-y-2">
                                @foreach(Auth::user()->unreadNotifications->take(3) as $notif)
                                    <a href="{{ route('user.notification.read', $notif->id) }}" class="flex items-start gap-3 p-2 hover:bg-fuchsia-50 rounded-lg transition">
                                        <svg class="w-4 h-4 text-fuchsia-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span class="text-sm text-gray-700 leading-tight">{{ $notif->data['message'] }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="flex items-center gap-4 mb-4 mt-2">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="h-12 w-12 rounded-full object-cover border border-gray-200">
                        @else
                            <div class="h-12 w-12 rounded-full bg-fuchsia-100 text-fuchsia-600 flex items-center justify-center font-bold text-lg border border-fuchsia-200">{{ substr(Auth::user()->name, 0, 1) }}</div>
                        @endif
                        <div>
                            <div class="font-bold text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="text-sm text-gray-500 truncate max-w-[150px]">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <a href="{{ route('dashboard') }}" class="block w-full text-center py-2.5 bg-white border border-gray-200 rounded-lg text-sm font-bold text-gray-700 hover:bg-gray-50">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full py-2.5 bg-red-50 border border-red-100 rounded-lg text-sm font-bold text-red-600 hover:bg-red-100 transition">Keluar</button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="block w-full text-center bg-gray-900 text-white py-3 rounded-xl font-bold shadow-md hover:bg-gray-800 transition">Masuk / Daftar Sekarang</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Content --}}
    @if (isset($header))
        <header class="bg-white shadow mt-16 md:mt-20">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">{{ $header }}</div>
        </header>
    @else
        <div class="h-16 md:h-20"></div> 
    @endif

    <main class="flex-grow">
        {{ $slot }}
    </main>

    {{-- FOOTER YANG DIPERBAIKI --}}
    <footer class="bg-gray-900 text-white pt-16 pb-8 mt-20 border-t-4 border-fuchsia-600">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                
                {{-- KOLOM 1: BRAND (Ainin Ar Store) --}}
                <div class="space-y-4">
                    <h2 class="text-3xl font-bold font-serif text-transparent bg-clip-text bg-gradient-to-r from-fuchsia-400 to-purple-400">
                        Ainin Ar Store
                    </h2>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Menghadirkan keindahan alam tropis langsung ke halaman rumah Anda dengan koleksi Bougenville premium kami.
                    </p>
                </div>

                {{-- KOLOM 2: JELAJAHI (Update: Tanpa Panah & Ada Kontak) --}}
                <div>
                    <h4 class="font-bold text-lg mb-6 text-white border-b border-gray-700 pb-2 inline-block">Jelajahi</h4>
                    <ul class="space-y-3 text-gray-400 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-fuchsia-400 transition flex items-center gap-2">Beranda</a></li>
                        <li><a href="{{ route('products.index') }}" class="hover:text-fuchsia-400 transition flex items-center gap-2">Katalog Produk</a></li>
                        <li><a href="{{ route('tutorials.all') }}" class="hover:text-fuchsia-400 transition flex items-center gap-2">Tips & Tutorial</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-fuchsia-400 transition flex items-center gap-2">Kontak Kami</a></li>
                    </ul>
                </div>

                {{-- KOLOM 3: KONTAK --}}
                <div>
                    <h4 class="font-bold text-lg mb-6 text-white border-b border-gray-700 pb-2 inline-block">Hubungi Kami</h4>
                    <ul class="space-y-4 text-gray-400 text-sm">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-fuchsia-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Jl. Nasional III No.22,<br>Tulungagung, Jawa Timur</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-fuchsia-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>halo@aininarstore.com</span>
                        </li>
                    </ul>
                </div>

                {{-- KOLOM 4: JAM OPERASIONAL --}}
                <div>
                    <h4 class="font-bold text-lg mb-6 text-white border-b border-gray-700 pb-2 inline-block">Jam Operasional</h4>
                    <p class="text-gray-400 text-sm mb-2">Senin - Jumat:</p>
                    <p class="font-bold text-white mb-4">08:00 - 17:00 WIB</p>
                    <p class="text-gray-400 text-sm mb-2">Sabtu - Minggu:</p>
                    <p class="font-bold text-white">09:00 - 15:00 WIB</p>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-500 text-xs text-center md:text-left">
                    &copy; {{ date('Y') }} <span class="text-fuchsia-500 font-bold">Ainin Ar Store</span>. All rights reserved.
                </p>
            </div>
        </div>
    </footer>


    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="fixed bottom-5 right-5 z-50 flex max-w-sm w-full bg-white shadow-2xl rounded-lg p-4 flex items-start gap-3 border-l-4 border-green-500">
            <div class="flex-shrink-0 text-green-500"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
            <div class="flex-1"><p class="text-sm font-bold text-gray-900">Berhasil!</p><p class="mt-1 text-sm text-gray-500">{{ session('success') }}</p></div>
            <button @click="show = false" class="text-gray-400 hover:text-gray-500">Tutup</button>
        </div>
    @endif
</body>
</html>
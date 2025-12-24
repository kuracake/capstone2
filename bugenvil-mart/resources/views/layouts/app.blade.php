<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>BougainVilla - Keindahan Alam</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
        h1, h2, h3, .serif { font-family: 'Playfair Display', serif; }
        [x-cloak] { display: none !important; }
        
        /* Animasi Bounce untuk Badge */
        @keyframes bounce-short {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-25%); }
        }
        .animate-bounce-short {
            animation: bounce-short 0.5s ease-in-out 2;
        }
    </style>
</head>
<body class="bg-pink-50 text-gray-800 antialiased flex flex-col min-h-screen">

    <nav x-data="{ open: false }" class="bg-white py-4 px-6 sticky top-0 z-50 shadow-sm">
        <div class="container mx-auto">
            <div class="flex justify-between items-center">
                
                {{-- LOGO --}}
                <a href="/" class="flex items-center gap-2">
                    <div class="border-2 border-fuchsia-500 rounded-full p-1 text-fuchsia-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    </div>
                    <span class="text-2xl font-bold text-fuchsia-600 serif tracking-wide">BougainVilla</span>
                </a>

                {{-- MENU DESKTOP --}}
                <div class="hidden md:flex space-x-8 text-gray-600 font-medium">
                    <a href="{{ route('home') }}" class="hover:text-fuchsia-600 transition {{ request()->routeIs('home') ? 'text-fuchsia-600 font-bold' : '' }}">Beranda</a>
                    <a href="{{ route('products.index') }}" class="hover:text-fuchsia-600 transition {{ request()->routeIs('products.index') ? 'text-fuchsia-600 font-bold' : '' }}">Produk</a>
                    <a href="{{ route('tutorials.all') }}" class="hover:text-fuchsia-600 transition {{ request()->routeIs('tutorials.all') ? 'text-fuchsia-600 font-bold' : '' }}">Tutorial</a>
                    <a href="{{ route('contact') }}" class="hover:text-fuchsia-600 transition {{ request()->routeIs('contact') ? 'text-fuchsia-600 font-bold' : '' }}">Kontak</a>
                </div>

                {{-- KERANJANG & USER (DESKTOP) --}}
                <div class="hidden md:flex items-center gap-5">
                    
                    {{-- IKON KERANJANG (LOGIKA DATABASE) --}}
                    <a href="{{ route('cart.index') }}" class="relative text-gray-600 hover:text-fuchsia-600 transition group">
                        <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 00-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        @auth
                            @php
                                // Hitung total item langsung dari DB agar akurat
                                $cartCount = \App\Models\CartItem::where('user_id', Auth::id())->sum('quantity');
                            @endphp
                            @if($cartCount > 0)
                                <span class="absolute -top-2 -right-2 bg-fuchsia-600 text-white text-[10px] font-bold rounded-full h-5 w-5 flex items-center justify-center border-2 border-white animate-bounce-short">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        @endauth
                    </a>

                    @auth
                        <div class="flex items-center gap-4 border-l border-gray-300 pl-4 ml-2">
                            <a href="{{ url('/dashboard') }}" class="flex items-center gap-2 text-gray-600 hover:text-fuchsia-600 transition" title="Ke Dashboard">
                                <div class="text-right">
                                    <div class="text-xs text-gray-500">Halo,</div>
                                    <div class="text-sm font-bold leading-none">{{ Auth::user()->name }}</div>
                                </div>
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-8 h-8 rounded-full object-cover border border-gray-200" alt="Avatar">
                                @else
                                    <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 font-bold">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endif
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-red-500 hover:text-red-700 p-1" title="Keluar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="border-l border-gray-300 pl-4 ml-2">
                            <a href="{{ route('login') }}" class="bg-fuchsia-600 text-white px-5 py-2 rounded-full font-bold text-sm hover:bg-fuchsia-700 transition shadow-md">Masuk</a>
                        </div>
                    @endauth
                </div>

                {{-- TOMBOL HAMBURGER (MOBILE) --}}
                <div class="-mr-2 flex items-center md:hidden gap-4">
                    {{-- Ikon Keranjang di Mobile --}}
                    <a href="{{ route('cart.index') }}" class="relative text-gray-600 hover:text-fuchsia-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 00-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        @auth
                            @if(isset($cartCount) && $cartCount > 0)
                                <span class="absolute -top-2 -right-2 bg-fuchsia-600 text-white text-[10px] font-bold rounded-full h-5 w-5 flex items-center justify-center border-2 border-white">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        @endauth
                    </a>

                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- MENU MOBILE (DROPDOWN) --}}
        <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden border-t border-gray-100 mt-4 bg-white shadow-lg">
            <div class="pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('home') ? 'border-fuchsia-400 text-fuchsia-700 bg-fuchsia-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50' }} text-base font-medium">Beranda</a>
                <a href="{{ route('products.index') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('products.index') ? 'border-fuchsia-400 text-fuchsia-700 bg-fuchsia-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50' }} text-base font-medium">Produk</a>
                <a href="{{ route('tutorials.all') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('tutorials.all') ? 'border-fuchsia-400 text-fuchsia-700 bg-fuchsia-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50' }} text-base font-medium">Tutorial</a>
                <a href="{{ route('contact') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('contact') ? 'border-fuchsia-400 text-fuchsia-700 bg-fuchsia-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50' }} text-base font-medium">Kontak</a>
            </div>
            
            <div class="pt-4 pb-4 border-t border-gray-200">
                @auth
                    <div class="px-4 flex items-center gap-3">
                        <div class="flex-shrink-0">
                            @if(Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-10 h-10 rounded-full object-cover">
                            @else
                                <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center font-bold text-gray-500">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div>
                            <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                    <div class="mt-3 space-y-1">
                        <a href="{{ route('dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 text-base font-medium">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-red-600 hover:text-red-800 hover:bg-red-50 text-base font-medium">Keluar</a>
                        </form>
                    </div>
                @else
                    <div class="px-4">
                        <a href="{{ route('login') }}" class="block w-full text-center bg-fuchsia-600 text-white px-5 py-3 rounded-lg font-bold hover:bg-fuchsia-700 transition">Masuk / Daftar</a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <main class="flex-grow">
        {{ $slot }}
    </main>

    <footer id="contact" class="bg-slate-900 text-white pt-16 pb-8 mt-auto">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 border-b border-slate-700 pb-12">
                <div>
                    <div class="flex items-center gap-2 mb-4 text-fuchsia-400">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        <span class="font-bold text-xl serif">BougainVilla</span>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed">Destinasi utama Anda untuk tanaman bugenvil yang indah.</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4 text-lg">Tautan Cepat</h4>
                    <ul class="space-y-2 text-slate-400 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-fuchsia-400">Beranda</a></li>
                        <li><a href="{{ route('products.index') }}" class="hover:text-fuchsia-400">Produk</a></li>
                        <li><a href="{{ route('tutorials.all') }}" class="hover:text-fuchsia-400">Tutorial</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4 text-lg">Info Kontak</h4>
                    <ul class="space-y-3 text-slate-400 text-sm">
                        <li class="flex items-center gap-2"> info@bougainvilla.com</li>
                        <li class="flex items-center gap-2"> Jl. Mawar No. 123, Jakarta</li>
                    </ul>
                </div>
            </div>
            <div class="pt-8 text-center text-slate-500 text-sm">
                &copy; {{ date('Y') }} BougainVilla Store. Hak Cipta Dilindungi.
            </div>
        </div>
    </footer>

    {{-- NOTIFIKASI MELAYANG (TOAST) --}}
    @if(session('success'))
    <div x-data="{ show: true }" 
         x-show="show" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-2"
         x-init="setTimeout(() => show = false, 4000)" 
         class="fixed bottom-5 right-5 z-50 bg-gray-900 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-4 max-w-sm border border-gray-700">
        
        <div class="bg-green-500 rounded-full p-1 flex-shrink-0">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <div>
            <h4 class="font-bold text-sm text-green-400 mb-1">Berhasil!</h4>
            <p class="text-xs text-gray-300 leading-snug">{!! session('success') !!}</p>
        </div>
        <button @click="show = false" class="text-gray-500 hover:text-white transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>
    @endif

</body>
</html>
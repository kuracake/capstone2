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
    </style>
</head>
<body class="bg-pink-50 text-gray-800 antialiased flex flex-col min-h-screen">

    <nav class="bg-white py-4 px-6 sticky top-0 z-50 shadow-sm">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="flex items-center gap-2">
                <div class="border-2 border-fuchsia-500 rounded-full p-1 text-fuchsia-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                </div>
                <span class="text-2xl font-bold text-fuchsia-600 serif tracking-wide">BougainVilla</span>
            </a>

            <div class="hidden md:flex space-x-8 text-gray-600 font-medium">
                <a href="{{ route('home') }}" class="hover:text-fuchsia-600 transition {{ request()->routeIs('home') ? 'text-fuchsia-600 font-bold' : '' }}">Beranda</a>
                <a href="{{ route('products.index') }}" class="hover:text-fuchsia-600 transition {{ request()->routeIs('products.index') ? 'text-fuchsia-600 font-bold' : '' }}">Produk</a>
                <a href="{{ route('tutorials.all') }}" class="hover:text-fuchsia-600 transition {{ request()->routeIs('tutorials.all') ? 'text-fuchsia-600 font-bold' : '' }}">Tutorial</a>
                <a href="{{ route('contact') }}" class="hover:text-fuchsia-600 transition {{ request()->routeIs('contact') ? 'text-fuchsia-600 font-bold' : '' }}">Kontak</a>
            </div>

            <div class="flex items-center gap-5">
                <a href="{{ route('cart.index') }}" class="relative text-gray-600 hover:text-fuchsia-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 00-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    @if(session('cart'))
                        <span class="absolute -top-2 -right-2 bg-fuchsia-600 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">{{ count(session('cart')) }}</span>
                    @endif
                </a>

                @auth
                    <div class="flex items-center gap-4 border-l border-gray-300 pl-4 ml-2">
                        <a href="{{ url('/dashboard') }}" class="flex items-center gap-2 text-gray-600 hover:text-fuchsia-600 transition" title="Ke Dashboard">
                            <div class="hidden md:block text-right">
                                <div class="text-xs text-gray-500">Halo,</div>
                                <div class="text-sm font-bold leading-none">{{ Auth::user()->name }}</div>
                            </div>
                            @if(Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-8 h-8 rounded-full object-cover border border-gray-200" alt="Avatar">
                            @else
                                <svg class="w-8 h-8 bg-gray-100 rounded-full p-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            @endif
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bg-red-50 text-red-600 hover:bg-red-600 hover:text-white px-3 py-2 rounded-lg text-sm font-bold transition flex items-center gap-1" title="Keluar dari Aplikasi">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                    </div>
                @else
                    <div class="border-l border-gray-300 pl-4 ml-2">
                        <a href="{{ route('login') }}" class="bg-fuchsia-600 text-white px-5 py-2 rounded-full font-bold text-sm hover:bg-fuchsia-700 transition shadow-md">
                            Masuk
                        </a>
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
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Destinasi utama Anda untuk tanaman bugenvil yang indah dan panduan berkebun ahli.
                    </p>
                </div>

                <div>
                    <h4 class="font-bold mb-4 text-lg">Tautan Cepat</h4>
                    <ul class="space-y-2 text-slate-400 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-fuchsia-400">Beranda</a></li>
                        <li><a href="{{ route('products.index') }}" class="hover:text-fuchsia-400">Produk</a></li>
                        <li><a href="{{ route('tutorials.all') }}" class="hover:text-fuchsia-400">Tutorial</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-fuchsia-400">Kontak</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold mb-4 text-lg">Layanan Pelanggan</h4>
                    <ul class="space-y-2 text-slate-400 text-sm">
                        <li><a href="{{ route('reports.create') }}" class="hover:text-fuchsia-400">Lapor Masalah</a></li>
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
</body>
</html>
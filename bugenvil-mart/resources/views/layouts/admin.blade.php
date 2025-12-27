<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Panel - Ainin Ar Store</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
        [x-cloak] { display: none !important; }
    </style>

    {{-- Script AlpineJS & Vite --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">
        
        {{-- HEADER MOBILE (Hanya tampil di HP) --}}
        <div class="fixed w-full z-40 flex items-center justify-between h-16 bg-white border-b border-gray-200 px-4 md:hidden shadow-sm">
            <span class="text-fuchsia-700 font-bold text-lg font-serif">Ainin Ar Store</span>
            <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none p-2 rounded-md hover:bg-gray-100">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>

        {{-- SIDEBAR UTAMA (Bagian Kiri) --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-white transition-transform duration-300 ease-in-out md:relative md:translate-x-0 flex flex-col shadow-xl border-r border-gray-100">
            
            {{-- 1. LOGO BRAND (Ganti BougainVilla jadi Ainin Ar Store) --}}
            <div class="h-24 flex flex-col items-center justify-center border-b border-gray-100">
                <h1 class="text-2xl font-bold font-serif text-transparent bg-clip-text bg-gradient-to-r from-fuchsia-700 to-purple-600 tracking-tight">
                    Ainin Ar Store
                </h1>
                <span class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mt-1">Administrator Panel</span>
            </div>

            {{-- 2. MENU NAVIGASI --}}
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                
                {{-- Dashboard --}}
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.dashboard') ? 'bg-fuchsia-600 text-white shadow-lg shadow-fuchsia-200' : 'text-gray-500 hover:bg-fuchsia-50 hover:text-fuchsia-600' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span class="font-medium text-sm">Dashboard</span>
                </a>

                {{-- Produk --}}
                <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.products.*') ? 'bg-fuchsia-600 text-white shadow-lg shadow-fuchsia-200' : 'text-gray-500 hover:bg-fuchsia-50 hover:text-fuchsia-600' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    <span class="font-medium text-sm">Produk</span>
                </a>

                {{-- Daftar Pesanan --}}
                <a href="{{ route('admin.orders.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.orders.*') ? 'bg-fuchsia-600 text-white shadow-lg shadow-fuchsia-200' : 'text-gray-500 hover:bg-fuchsia-50 hover:text-fuchsia-600' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    <span class="font-medium text-sm">Daftar Pesanan</span>
                </a>

                {{-- Tutorial Video --}}
                <a href="{{ route('admin.videos.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.videos.*') ? 'bg-fuchsia-600 text-white shadow-lg shadow-fuchsia-200' : 'text-gray-500 hover:bg-fuchsia-50 hover:text-fuchsia-600' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-medium text-sm">Tutorial Video</span>
                </a>
                
                {{-- Laporan --}}
                <a href="{{ route('admin.reports.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.reports.*') ? 'bg-fuchsia-600 text-white shadow-lg shadow-fuchsia-200' : 'text-gray-500 hover:bg-fuchsia-50 hover:text-fuchsia-600' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <span class="font-medium text-sm">Laporan</span>
                </a>
            </nav>

            {{-- FOOTER SIDEBAR --}}
            <div class="p-4 border-t border-gray-100 bg-gray-50">
                <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-center w-full px-4 py-2.5 mb-3 text-xs font-bold text-fuchsia-600 bg-white border border-fuchsia-200 hover:bg-fuchsia-50 rounded-xl transition-colors gap-2 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Lihat Website
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center justify-center w-full px-4 py-2.5 text-xs font-bold text-red-500 bg-white border border-red-100 hover:bg-red-50 hover:text-red-600 rounded-xl transition-colors gap-2 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 h-screen overflow-y-auto bg-gray-50 pt-16 md:pt-0">
            {{-- Top Bar Desktop --}}
            <div class="hidden md:flex justify-between items-center px-8 py-5 bg-white border-b border-gray-100 sticky top-0 z-30 shadow-sm">
                <h2 class="text-xl font-bold text-gray-800 font-serif">
                    {{-- Judul Halaman Otomatis --}}
                    @if(request()->routeIs('admin.dashboard')) Dashboard Overview
                    @elseif(request()->routeIs('admin.products.*')) Manajemen Produk
                    @elseif(request()->routeIs('admin.orders.*')) Daftar Pesanan
                    @elseif(request()->routeIs('admin.videos.*')) Tutorial Video
                    @elseif(request()->routeIs('admin.reports.*')) Laporan Pelanggan
                    @else Panel Admin
                    @endif
                </h2>
                
                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-700">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-fuchsia-600 font-bold uppercase tracking-wider">Administrator</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-fuchsia-500 to-purple-600 flex items-center justify-center text-white font-bold shadow-md border-2 border-white">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            </div>

            <div class="p-6 md:p-8 max-w-7xl mx-auto">
                {{ $slot }}
            </div>
        </main>
        
        {{-- Overlay untuk Mobile --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm md:hidden" style="display: none;"></div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Ainin Ar Store') }} - Admin</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    {{-- Scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }
        .font-serif { font-family: 'Playfair Display', serif; }
        
        /* Sidebar Styles */
        .sidebar-menu-link {
            display: flex; items-center: center; padding: 12px 16px; margin-bottom: 4px;
            border-radius: 12px; font-size: 0.95rem; font-weight: 500;
            transition: all 0.2s; color: #4b5563; 
        }
        .sidebar-menu-link:hover { background-color: #f9fafb; color: #111827; }
        .sidebar-menu-link.active { background-color: #fdf4ff; color: #a21caf; font-weight: 600; }
        .sidebar-icon { width: 20px; height: 20px; margin-right: 12px; }

        /* Desktop Sidebar Fixed */
        @media (min-width: 768px) {
            #mobile-overlay { display: none !important; }
            #sidebar { 
                transform: translateX(0) !important; position: fixed !important;
                top: 0; bottom: 0; left: 0; width: 16rem; z-index: 30;
            }
            #main-content { margin-left: 16rem; }
            #mobile-header { display: none !important; }
        }
    </style>
</head>
<body class="antialiased text-gray-900 bg-gray-50">

    {{-- 1. HEADER MOBILE (Tetap ada) --}}
    <header id="mobile-header" class="bg-white shadow-sm h-16 fixed top-0 left-0 right-0 z-40 flex items-center justify-between px-4">
        <div class="flex items-center gap-3">
            <button onclick="toggleSidebar()" class="p-2 -ml-2 rounded-lg text-gray-600 hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <span class="font-bold text-lg text-gray-800">Admin Menu</span>
        </div>
        {{-- Lonceng Mobile --}}
        <div class="relative" x-data="{ open: false }">
             <button @click="open = !open" class="p-2 text-gray-500 hover:text-fuchsia-600 relative">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="absolute top-1 right-1 flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                    </span>
                @endif
            </button>
            {{-- Dropdown Mobile (Sederhana) --}}
            <div x-show="open" @click.outside="open = false" class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden z-50" style="display: none;">
                <div class="p-3 border-b border-gray-100 font-bold text-xs text-gray-500 uppercase">Notifikasi</div>
                <div class="max-h-64 overflow-y-auto">
                    @forelse(auth()->user()->unreadNotifications as $notification)
                        <a href="{{ route('admin.notification.read', $notification->id) }}" class="block p-3 hover:bg-fuchsia-50 transition border-b border-gray-50">
                            <p class="text-sm font-semibold text-gray-800">{{ $notification->data['message'] }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                        </a>
                    @empty
                        <div class="p-4 text-center text-sm text-gray-400">Tidak ada notifikasi baru</div>
                    @endforelse
                </div>
            </div>
        </div>
    </header>

    {{-- OVERLAY MOBILE --}}
    <div id="mobile-overlay" onclick="closeSidebar()" class="fixed inset-0 bg-black/50 z-40 hidden transition-opacity opacity-0"></div>

    {{-- 2. SIDEBAR (Kiri) --}}
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transform -translate-x-full transition-transform duration-300 ease-in-out flex flex-col h-full shadow-2xl md:shadow-none">
        
        <div class="h-16 flex items-center justify-center border-b border-gray-100 shrink-0">
            <h1 class="text-2xl font-bold tracking-tight text-gray-800 font-serif">
                <span class="text-fuchsia-600">Ainin Ar Store</span>
            </h1>
        </div>

        <nav class="flex-1 overflow-y-auto p-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Dashboard
            </a>
            <a href="{{ route('admin.products.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}">
                <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                Produk
            </a>
            <a href="{{ route('admin.orders.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                Pesanan
            </a>
            <a href="{{ Route::has('admin.videos.index') ? route('admin.videos.index') : '#' }}" class="sidebar-menu-link {{ request()->routeIs('admin.videos*') ? 'active' : '' }}">
                <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Video Tutorial
            </a>
            <a href="{{ Route::has('admin.reports.index') ? route('admin.reports.index') : '#' }}" class="sidebar-menu-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
                <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Laporan
            </a>
        </nav>

        <div class="border-t border-gray-200 p-4 bg-gray-50">
            <div class="flex items-center">
                <div class="w-9 h-9 rounded-full bg-fuchsia-600 flex items-center justify-center text-white font-bold shrink-0 shadow-md">
                    {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                </div>
                <div class="ml-3 min-w-0 flex-1">
                    <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->name ?? 'Administrator' }}</p>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-xs text-red-500 hover:text-red-700 font-medium hover:underline">Log Out</button>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    {{-- 3. KONTEN UTAMA --}}
    <div id="main-content" class="min-h-screen flex flex-col pt-16 md:pt-0 transition-all duration-300">
        
        {{-- TOP BAR DESKTOP (BARU DITAMBAHKAN) --}}
        <div class="hidden md:flex bg-white h-16 border-b border-gray-100 items-center justify-between px-8 sticky top-0 z-20">
            {{-- Breadcrumb / Judul --}}
            <div class="flex items-center text-sm font-medium text-gray-500">
                <span>Admin</span>
                <svg class="w-4 h-4 mx-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-fuchsia-600 font-bold">Panel</span>
            </div>

            {{-- Kanan: Notifikasi & Profil --}}
            <div class="flex items-center gap-6">
                
                {{-- FITUR NOTIFIKASI --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="text-gray-400 hover:text-fuchsia-600 transition relative p-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        
                        {{-- Badge Merah (Jika ada notifikasi belum dibaca) --}}
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="absolute top-0 right-0 flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500 border-2 border-white"></span>
                            </span>
                        @endif
                    </button>

                    {{-- Dropdown Notifikasi --}}
                    <div x-show="open" @click.outside="open = false" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden z-50 origin-top-right" 
                         style="display: none;">
                        
                        <div class="px-4 py-3 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
                            <h3 class="font-bold text-gray-800 text-sm">Notifikasi</h3>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <span class="bg-fuchsia-100 text-fuchsia-600 text-[10px] px-2 py-0.5 rounded-full font-bold">
                                    {{ auth()->user()->unreadNotifications->count() }} Baru
                                </span>
                            @endif
                        </div>

                        <div class="max-h-[300px] overflow-y-auto custom-scrollbar">
                            @forelse(auth()->user()->notifications as $notification)
                                <a href="{{ route('admin.notification.read', $notification->id) }}" class="block px-4 py-3 hover:bg-gray-50 transition border-b border-gray-50 {{ $notification->read_at ? 'opacity-60' : 'bg-fuchsia-50/30' }}">
                                    <div class="flex gap-3">
                                        <div class="mt-1 flex-shrink-0">
                                            @if($notification->data['type'] == 'new_order')
                                                <div class="w-8 h-8 bg-green-100 text-green-600 rounded-full flex items-center justify-center">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                                </div>
                                            @else
                                                <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-800 {{ $notification->read_at ? 'font-normal' : '' }}">
                                                {{ $notification->data['message'] }}
                                            </p>
                                            <p class="text-xs text-gray-400 mt-1">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="px-4 py-8 text-center">
                                    <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-2">
                                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                    </div>
                                    <p class="text-gray-400 text-sm">Belum ada notifikasi.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Profil --}}
                <div class="flex items-center gap-3">
                    <div class="text-right hidden md:block">
                        <div class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-gray-500">Administrator</div>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-fuchsia-600 to-purple-600 text-white flex items-center justify-center font-bold shadow-md">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>

            </div>
        </div>

        {{-- Slot Konten Halaman --}}
        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            {{ $slot }}
        </main>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('mobile-overlay');

        function toggleSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            setTimeout(() => { overlay.classList.remove('opacity-0'); }, 10);
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('opacity-0');
            setTimeout(() => { overlay.classList.add('hidden'); }, 300);
        }
    </script>
</body>
</html>
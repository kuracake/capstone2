<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - AininArStore</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        teal: {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            400: '#2dd4bf',
                            500: '#14b8a6',
                            600: '#0d9488',
                        },
                        emerald: {
                            500: '#10b981',
                            600: '#059669',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        /* Hilangkan scrollbar default tapi tetap bisa scroll */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">
    
    <div class="min-h-screen flex flex-row">
        
        <aside class="w-64 bg-white border-r border-gray-100 hidden md:flex flex-col fixed h-full z-30 shadow-[4px_0_24px_rgba(0,0,0,0.02)]">
            <div class="h-24 flex items-center px-8 border-b border-gray-50">
                <div class="flex items-center gap-2">
                
                    <h1 class="text-xl font-extrabold text-fuchsia-600 tracking-tight">Ainin Ar Store</span></h1>
                </div>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto no-scrollbar">
                
                {{-- Dashboard Link --}}
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3.5 text-sm font-semibold rounded-2xl transition-all duration-300 group {{ request()->routeIs('admin.dashboard') ? 'bg-fuchsia-600 text-white shadow-lg shadow-teal-200 translate-x-1' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-400 group-hover:text-teal-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>

                {{-- Products Link --}}
                <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 py-3.5 text-sm font-medium rounded-2xl transition-all duration-300 group {{ request()->routeIs('admin.products*') ? 'bg-fuchsia-600 text-white shadow-lg shadow-teal-200 translate-x-1' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.products*') ? 'text-white' : 'text-gray-400 group-hover:text-teal-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    Produk
                </a>

               {{-- Orders Link (Gaya Teal/White - Sesuai Tema Asli) --}}
                <a href="{{ route('admin.orders.index') }}" class="flex items-center px-4 py-3.5 text-sm font-medium rounded-2xl transition-all duration-300 group {{ request()->routeIs('admin.orders*') ? 'bg-fuchsia-600 text-white shadow-lg shadow-teal-200 translate-x-1' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.orders*') ? 'text-white' : 'text-gray-400 group-hover:text-teal-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Daftar Pesanan
                </a>

                {{-- Videos Link --}}
                <a href="{{ route('admin.videos.index') }}" class="flex items-center px-4 py-3.5 text-sm font-medium rounded-2xl transition-all duration-300 group {{ request()->routeIs('admin.videos*') ? 'bg-fuchsia-600 text-white shadow-lg shadow-teal-200 translate-x-1' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.videos*') ? 'text-white' : 'text-gray-400 group-hover:text-teal-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Tutorial Video
                </a>

                {{-- Laporan Link --}}
                <a href="{{ route('admin.reports.index') }}" class="flex items-center px-4 py-3.5 text-sm font-medium rounded-2xl transition-all duration-300 group {{ request()->routeIs('admin.reports*') ? 'bg-fuchsia-600 text-white shadow-lg shadow-teal-200 translate-x-1' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.reports*') ? 'text-white' : 'text-gray-400 group-hover:text-teal-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Laporan
                </a>
            </nav>

            <div class="p-6 border-t border-gray-50 flex flex-col gap-3">
                {{-- Tombol BARU: Kembali ke Website --}}
                <a href="{{ route('home') }}" class="flex items-center justify-center w-full px-4 py-3 text-sm font-bold text-teal-700 bg-teal-50 rounded-xl hover:bg-teal-100 transition-colors group">
                    <svg class="w-5 h-5 mr-2 text-teal-500 group-hover:text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Lihat Website
                </a>

                {{-- Tombol Logout (Tetap Ada) --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center justify-center w-full px-4 py-3 text-sm font-bold text-red-500 bg-red-50 rounded-xl hover:bg-red-100 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 md:ml-64 bg-gray-50 min-h-screen relative">
            

            <div class="p-8">
                {{ $slot }}
            </div>
        </main>
        
    </div>
</body>
</html>
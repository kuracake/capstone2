<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Dashboard - Bugenvil Mart</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        
        <aside class="w-64 bg-slate-900 text-white flex flex-col shadow-xl z-20">
            <div class="h-16 flex items-center justify-center border-b border-slate-700 bg-slate-950">
                <h1 class="text-xl font-bold tracking-wider text-blue-400">ADMIN PANEL</h1>
            </div>

            <nav class="flex-1 px-2 py-4 space-y-2 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>

                <a href="{{ route('admin.products.index') }}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.products.*') ? 'bg-blue-600 text-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    Produk
                </a>

                <a href="{{ route('admin.videos.index') }}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.videos.*') ? 'bg-blue-600 text-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Video Tutorial
                </a>
                
                <a href="{{ route('admin.reports.index') }}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-800 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin.reports.*') ? 'bg-blue-600 text-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Laporan Kerusakan
                </a>
            </nav>

            <div class="p-4 border-t border-slate-700 bg-slate-950">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-400">Administrator</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 text-sm text-center text-slate-300 bg-slate-800 hover:bg-red-600 hover:text-white rounded transition-colors">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 h-screen overflow-y-auto bg-gray-50">
            <div class="p-8">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>
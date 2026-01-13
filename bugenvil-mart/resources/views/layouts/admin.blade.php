<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Ainin Ar Store') }} - Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }
        
        /* Sidebar Styles */
        .sidebar-menu-link {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            margin-bottom: 4px;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.2s;
            color: #4b5563; /* text-gray-600 */
        }
        
        .sidebar-menu-link:hover {
            background-color: #f9fafb; /* gray-50 */
            color: #111827; /* text-gray-900 */
        }

        .sidebar-menu-link.active {
            background-color: #fdf4ff; /* fuchsia-50 */
            color: #a21caf; /* fuchsia-700 */
            font-weight: 600;
        }

        .sidebar-icon {
            width: 20px;
            height: 20px;
            margin-right: 12px;
        }

        /* Responsive Utilities */
        @media (min-width: 768px) {
            #mobile-overlay { display: none !important; }
            #sidebar { 
                transform: translateX(0) !important; 
                position: fixed !important;
                top: 0; bottom: 0; left: 0;
                width: 16rem; /* 64 aka 256px */
                z-index: 30;
            }
            #main-content {
                margin-left: 16rem; /* Same as sidebar width */
            }
            #mobile-header { display: none !important; }
        }
    </style>
</head>
<body class="antialiased text-gray-900">

    <header id="mobile-header" class="bg-white shadow-sm h-16 fixed top-0 left-0 right-0 z-40 flex items-center justify-between px-4">
        <div class="flex items-center gap-3">
            <button onclick="toggleSidebar()" class="p-2 -ml-2 rounded-lg text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-fuchsia-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <span class="font-bold text-lg text-gray-800">Menu Admin</span>
        </div>
        <div class="text-fuchsia-600 font-bold">BMart</div>
    </header>

    <div id="mobile-overlay" onclick="closeSidebar()" class="fixed inset-0 bg-black/50 z-40 hidden transition-opacity opacity-0"></div>

    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transform -translate-x-full transition-transform duration-300 ease-in-out flex flex-col h-full shadow-2xl md:shadow-none">
        
        <div class="h-16 flex items-center justify-center border-b border-gray-100 shrink-0">
            <h1 class="text-2xl font-bold tracking-tight text-gray-800">
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

    <div id="main-content" class="min-h-screen flex flex-col pt-16 md:pt-0 transition-all duration-300">
        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            {{ $slot }}
        </main>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('mobile-overlay');

        function toggleSidebar() {
            // Tampilkan Sidebar
            sidebar.classList.remove('-translate-x-full');
            // Tampilkan Overlay
            overlay.classList.remove('hidden');
            setTimeout(() => { overlay.classList.remove('opacity-0'); }, 10);
        }

        function closeSidebar() {
            // Sembunyikan Sidebar
            sidebar.classList.add('-translate-x-full');
            // Sembunyikan Overlay
            overlay.classList.add('opacity-0');
            setTimeout(() => { overlay.classList.add('hidden'); }, 300);
        }
    </script>

</body>
</html>
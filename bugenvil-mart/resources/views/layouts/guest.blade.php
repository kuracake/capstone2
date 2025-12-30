<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Ainin Ar Store') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-50">
        
        {{-- Container Utama: Flexbox untuk menengahkan konten secara vertikal & horizontal --}}
        <div class="min-h-screen flex flex-col justify-center items-center p-6 sm:p-12 relative">
            
            {{-- Tombol Kembali ke Beranda (Pojok Kiri Atas) --}}
            <a href="/" class="absolute top-6 left-6 flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-fuchsia-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span class="hidden sm:inline">Kembali ke Beranda</span>
            </a>

            {{-- Kartu Formulir --}}
            <div class="w-full max-w-md bg-white rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden p-8 sm:p-10">
                
                {{-- Logo Brand --}}
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-fuchsia-700 to-purple-600">
                        Ainin Ar Store
                    </h1>
                </div>

                {{-- Slot Konten (Login/Register) --}}
                {{ $slot }}
            </div>

            {{-- Footer Kecil (Opsional) --}}
            <div class="mt-8 text-center text-xs text-gray-400">
                &copy; {{ date('Y') }} Ainin Ar Store. All rights reserved.
            </div>
        </div>
    </body>
</html>
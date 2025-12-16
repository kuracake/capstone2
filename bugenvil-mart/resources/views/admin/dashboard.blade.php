<x-app-layout>
    {{-- Kita override slot header bawaan agar kosong, karena kita buat header sendiri di dalam --}}
    <x-slot name="header"></x-slot>

    <div class="flex min-h-screen bg-gray-100">
        
        {{-- === SIDEBAR NAVIGASI (KIRI) === --}}
        <aside class="w-64 bg-white border-r border-gray-200 hidden md:block fixed h-full z-10">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-pink-600 flex items-center gap-2">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    Bugenvil Admin
                </h1>
            </div>
            
            <nav class="mt-2 px-4 space-y-2">
                {{-- 1. Dashboard / Rekapan --}}
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-pink-50 text-pink-700 font-bold' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span>Dashboard & Rekap</span>
                </a>

                {{-- 2. Manajemen Produk --}}
                <a href="{{ route('admin.products.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.products.*') ? 'bg-pink-50 text-pink-700 font-bold' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    <span>Manajemen Produk</span>
                </a>

                {{-- 3. Manajemen Video --}}
                <a href="{{ route('admin.videos.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.videos.*') ? 'bg-pink-50 text-pink-700 font-bold' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    <span>Video Tutorial</span>
                </a>

                {{-- 4. Laporan Pelanggan --}}
                <a href="{{ route('admin.reports.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.reports.*') ? 'bg-pink-50 text-pink-700 font-bold' : 'text-gray-600 hover:bg-gray-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <span>Laporan Masalah</span>
                </a>

                 <div class="border-t border-gray-200 my-4"></div>

                {{-- Link Kembali ke Home (Opsional) --}}
                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:text-gray-800 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    <span>Lihat Website</span>
                </a>
            </nav>
        </aside>

        {{-- === KONTEN UTAMA (KANAN) === --}}
        <main class="flex-1 md:ml-64 p-8">
            {{-- Header Konten --}}
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800">Dashboard Overview</h2>
                    <p class="text-gray-500">Rekapan aktivitas toko Bugenvil Mart.</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-sm font-medium text-gray-600">Admin: {{ Auth::user()->name }}</span>
                    {{-- Avatar sederhana --}}
                    <div class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center text-pink-600 font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            </div>

            {{-- 1. KARTU STATISTIK (REKAPAN) --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="p-4 bg-green-100 text-green-600 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Pendapatan</p>
                        <p class="text-xl font-bold text-gray-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4">
                     <div class="p-4 bg-blue-100 text-blue-600 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Pesanan</p>
                        <p class="text-xl font-bold text-gray-800">{{ $totalOrders }}</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4">
                     <div class="p-4 bg-pink-100 text-pink-600 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Jumlah Produk</p>
                        <p class="text-xl font-bold text-gray-800">{{ $totalProducts }}</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4">
                     <div class="p-4 bg-yellow-100 text-yellow-600 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Pelanggan</p>
                        <p class="text-xl font-bold text-gray-800">{{ $totalUsers }}</p>
                    </div>
                </div>
            </div>

            {{-- 2. TABEL TRANSAKSI TERBARU --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="font-bold text-gray-800">Transaksi Terbaru Masuk</h3>
                    {{-- Opsi filter bisa ditambahkan di sini --}}
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50 text-gray-700 uppercase font-bold text-xs">
                            <tr>
                                <th class="px-6 py-4">ID Order</th>
                                <th class="px-6 py-4">Pelanggan</th>
                                <th class="px-6 py-4">Tanggal</th>
                                <th class="px-6 py-4">Total</th>
                                <th class="px-6 py-4">Status Pembayaran</th>
                                <th class="px-6 py-4 text-center">Update Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($latestOrders as $order)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-mono text-pink-600 font-bold">#{{ $order->tracking_number }}</td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $order->user->name ?? 'Guest' }}</div>
                                    <div class="text-xs text-gray-400">{{ $order->user->email ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4">{{ $order->created_at->format('d M Y, H:i') }}</td>
                                <td class="px-6 py-4 font-bold text-gray-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $badgeClass = match($order->status) {
                                            'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                            'paid', 'completed', 'settlement' => 'bg-green-100 text-green-700 border-green-200',
                                            'cancelled', 'expire', 'deny' => 'bg-red-100 text-red-700 border-red-200',
                                            'shipping' => 'bg-blue-100 text-blue-700 border-blue-200',
                                            default => 'bg-gray-100 text-gray-700 border-gray-200'
                                        };
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $badgeClass }}">
                                        {{ strtoupper($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" 
                                            class="text-xs border-gray-200 rounded-lg py-1 px-2 focus:ring-pink-500 focus:border-pink-500 cursor-pointer hover:bg-white transition">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>✅ Selesai</option>
                                            <option value="shipping" {{ $order->status == 'shipping' ? 'selected' : '' }}>🚚 Dikirim</option>
                                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>❌ Batal</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-400">
                                    Belum ada transaksi hari ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
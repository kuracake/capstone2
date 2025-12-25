<x-app-layout>
    {{-- Load jQuery untuk mendukung logika asli --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <div class="bg-gray-50 min-h-screen py-6 md:py-10">
        <div class="container mx-auto px-4 md:px-6 max-w-6xl">
            
            {{-- 1. HEADER SEDERHANA --}}
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4 border-b border-gray-200 pb-6">
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-gray-800 font-serif">Dashboard Saya</h1>
                    <p class="text-xs md:text-sm text-gray-500 mt-1">Halo, {{ Auth::user()->name }}. Selamat datang kembali.</p>
                </div>
                <a href="{{ route('products.index') }}" class="w-full md:w-auto px-6 py-2 bg-fuchsia-600 text-white text-sm font-bold rounded-lg hover:bg-fuchsia-700 transition shadow-sm text-center">
                    Mulai Belanja
                </a>
            </div>

            {{-- 2. MENU NAVIGASI DASHBOARD (Simple Cards) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <a href="{{ route('cart.index') }}" class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:border-fuchsia-300 transition flex items-center gap-4">
                    <div class="w-10 h-10 bg-fuchsia-50 text-fuchsia-600 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-800">Keranjang</h3>
                        <p class="text-[11px] text-gray-500">Lihat item belanjaan Anda</p>
                    </div>
                </a>

                <a href="#riwayat" class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:border-fuchsia-300 transition flex items-center gap-4">
                    <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-800">Status Pesanan</h3>
                        <p class="text-[11px] text-gray-500">Lacak pengiriman & riwayat</p>
                    </div>
                </a>

                <a href="{{ route('profile.edit') }}" class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:border-fuchsia-300 transition flex items-center gap-4">
                    <div class="w-10 h-10 bg-purple-50 text-purple-600 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-800">Profil Akun</h3>
                        <p class="text-[11px] text-gray-500">Update data diri & password</p>
                    </div>
                </a>
            </div>

            {{-- 3. RIWAYAT PESANAN (Clean Table) --}}
            <div id="riwayat" class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <h2 class="text-sm font-bold text-gray-800">Riwayat Pesanan & Laporan</h2>
                </div>

                @if(isset($myOrders) && $myOrders->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-[11px] text-gray-400 uppercase tracking-wider border-b border-gray-100">
                                    <th class="px-6 py-4 font-bold">Tanggal</th>
                                    <th class="px-6 py-4 font-bold">ID Transaksi</th>
                                    <th class="px-6 py-4 font-bold">Total</th>
                                    <th class="px-6 py-4 font-bold">Status Pesanan</th>
                                    <th class="px-6 py-4 font-bold text-center">Status Laporan</th>
                                    <th class="px-6 py-4 font-bold text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($myOrders as $order)
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="px-6 py-4 text-xs text-gray-600 whitespace-nowrap">
                                            {{ $order->created_at->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-xs font-mono font-bold text-fuchsia-600">#{{ $order->tracking_number }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-xs font-bold text-gray-900 whitespace-nowrap">
                                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2.5 py-1 rounded text-[10px] font-bold uppercase
                                                {{ $order->status == 'pending' ? 'bg-orange-50 text-orange-600' : '' }}
                                                {{ $order->status == 'packing' ? 'bg-blue-50 text-blue-600' : '' }}
                                                {{ $order->status == 'shipping' ? 'bg-indigo-50 text-indigo-600' : '' }}
                                                {{ $order->status == 'completed' ? 'bg-green-50 text-green-600' : '' }}
                                                {{ $order->status == 'cancelled' ? 'bg-red-50 text-red-600' : '' }}">
                                                {{ $order->status }}
                                            </span>
                                            @if($order->resi)
                                                <div class="mt-1 text-[9px] text-gray-400 font-mono">Resi: {{ $order->resi }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if($order->report)
                                                <span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase border 
                                                    {{ $order->report->status == 'pending' ? 'border-orange-200 text-orange-500' : 'border-green-200 text-green-500' }}">
                                                    {{ $order->report->status }}
                                                </span>
                                            @else
                                                <span class="text-gray-300 text-[10px]">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('orders.show', $order->id) }}" class="text-xs font-bold text-fuchsia-600 hover:underline">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-16">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        </div>
                        <p class="text-sm text-gray-400">Belum ada riwayat pesanan.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>

    {{-- Script Scroll Bar Halus --}}
    <style>
        .overflow-x-auto::-webkit-scrollbar { height: 4px; }
        .overflow-x-auto::-webkit-scrollbar-track { background: transparent; }
        .overflow-x-auto::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 10px; }
    </style>
</x-app-layout>
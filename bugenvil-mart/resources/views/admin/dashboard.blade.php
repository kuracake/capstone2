<x-admin-layout>
    {{-- Section Atas: Welcome Banner & Stats --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        
        {{-- Card 1: Total Pendapatan (Gradient Besar) --}}
        <div class="lg:col-span-2 bg-gradient-to-br from-teal-500 to-emerald-600 rounded-[2rem] p-8 text-white shadow-xl shadow-teal-100 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-8 -mr-8 w-48 h-48 bg-white opacity-10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -mb-8 -ml-8 w-40 h-40 bg-black opacity-5 rounded-full blur-3xl"></div>
            
            <div class="relative z-10 flex flex-col h-full justify-between min-h-[180px]">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-teal-100 text-sm font-medium tracking-wide uppercase mb-1">Total Pendapatan</p>
                        <h3 class="text-4xl md:text-5xl font-bold tracking-tight">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    </div>
                    <div class="p-3 bg-white/10 backdrop-blur-sm rounded-2xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div class="flex items-center gap-2 mt-4 text-teal-50 text-sm font-medium">
                    <span class="px-2 py-1 bg-white/20 rounded-lg text-white">+12%</span>
                    <span>dari bulan lalu</span>
                </div>
            </div>
        </div>

        {{-- Card 2: Total Pesanan --}}
        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 flex flex-col justify-between">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-gray-500 text-sm font-bold uppercase tracking-wider">Pesanan</h4>
                    <span class="text-4xl font-extrabold text-gray-800 mt-2 block">{{ $totalOrders }}</span>
                </div>
                <div class="p-3 bg-blue-50 text-blue-600 rounded-2xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
            </div>
            
            <div class="mt-6">
                <div class="flex justify-between text-xs font-semibold text-gray-400 mb-2">
                    <span>Progress Bulan Ini</span>
                    <span>85%</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2">
                    <div class="bg-blue-500 h-2 rounded-full" style="width: 85%"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Section Bawah: Statistik & Tabel --}}
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        {{-- Kolom Kanan: Statistik Kecil --}}
        <div class="lg:col-span-1 flex flex-col gap-6">
            {{-- Stat: Produk --}}
            <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-gray-100">
                <div class="flex items-center gap-4">
                    <div class="p-4 bg-purple-50 text-purple-600 rounded-2xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase">Produk</p>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $totalProducts }}</h3>
                    </div>
                </div>
            </div>

            {{-- Stat: Laporan --}}
            <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-gray-100">
                <div class="flex items-center gap-4">
                    <div class="p-4 bg-rose-50 text-rose-600 rounded-2xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase">Laporan</p>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $pendingReports }}</h3>
                    </div>
                </div>
            </div>

             {{-- Promo/Action Box --}}
             <div class="bg-gray-900 rounded-[2rem] p-6 text-white text-center relative overflow-hidden">
                <div class="relative z-10">
                    <h4 class="font-bold text-lg mb-2">Butuh Bantuan?</h4>
                    <p class="text-xs text-gray-400 mb-4">Hubungi tim developer untuk update fitur.</p>
                    <button class="w-full py-2 bg-white/10 hover:bg-white/20 rounded-xl text-sm font-semibold transition-colors">Kontak Dev</button>
                </div>
             </div>
        </div>

        {{-- Kolom Tengah: Tabel Transaksi --}}
        <div class="lg:col-span-3 bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden flex flex-col">
            <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-lg text-gray-800">Transaksi Terbaru</h3>
                <a href="#" class="text-sm font-semibold text-teal-600 hover:text-teal-700">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs text-gray-400 uppercase bg-gray-50/50 font-bold tracking-wider">
                        <tr>
                            <th class="px-8 py-4">ID</th>
                            <th class="px-6 py-4">Pelanggan</th>
                            <th class="px-6 py-4">Total</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 pr-8">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($recentOrders as $order)
                        <tr class="hover:bg-gray-50/80 transition-colors">
                            <td class="px-8 py-4 font-bold text-gray-900">#{{ $order->id }}</td>
                            <td class="px-6 py-4 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-500">
                                    {{ substr($order->user->name ?? 'U', 0, 1) }}
                                </div>
                                <span class="font-medium text-gray-700">{{ $order->user->name ?? 'User Terhapus' }}</span>
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                @if($order->status == 'pending')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-yellow-50 text-yellow-700">Pending</span>
                                @elseif($order->status == 'completed')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-green-50 text-green-700">Selesai</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-gray-100 text-gray-700">{{ ucfirst($order->status) }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 pr-8 text-gray-400 font-medium">{{ $order->created_at->format('d M, Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-12 text-center text-gray-400">Belum ada transaksi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-admin-layout>
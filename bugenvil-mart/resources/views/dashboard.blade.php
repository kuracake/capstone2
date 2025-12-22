<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Halo, {{ Auth::user()->name }}! 👋</h3>
                    <p class="text-gray-600">Selamat datang kembali di Bugenvil Mart.</p>
                </div>
                <a href="{{ route('products.index') }}" class="bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded-lg shadow transition">
                    Mulai Belanja &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- KARTU 1: KERANJANG (Sudah Benar) --}}
                <a href="{{ route('cart.index') }}" class="block p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-50 transition">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-blue-100 text-blue-600 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <h5 class="mb-1 text-xl font-bold tracking-tight text-gray-900">Keranjang Saya</h5>
                            <p class="font-normal text-gray-700 text-sm">Cek barang yang akan dibeli.</p>
                        </div>
                    </div>
                </a>

                {{-- KARTU 2: STATUS PESANAN (PERBAIKAN: Link ke Anchor Tabel di bawah) --}}
                <a href="#riwayat-pesanan" class="block p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-50 transition">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-green-100 text-green-600 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div>
                            <h5 class="mb-1 text-xl font-bold tracking-tight text-gray-900">Status Pesanan</h5>
                            <p class="font-normal text-gray-700 text-sm">Lihat status pembayaran & pengiriman.</p>
                        </div>
                    </div>
                </a>

                {{-- KARTU 3: AKUN (Sudah Benar) --}}
                <a href="{{ route('profile.edit') }}" class="block p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-50 transition">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-purple-100 text-purple-600 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <h5 class="mb-1 text-xl font-bold tracking-tight text-gray-900">Pengaturan Akun</h5>
                            <p class="font-normal text-gray-700 text-sm">Update password & alamat.</p>
                        </div>
                    </div>
                </a>
            </div>

            {{-- TABEL RIWAYAT PESANAN --}}
            <div id="riwayat-pesanan" class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-lg">Riwayat Pesanan & Laporan</h3>
                    </div>
                    
                    @if(isset($myOrders) && $myOrders->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                                    <tr>
                                        <th class="px-6 py-3">Tanggal</th>
                                        <th class="px-6 py-3">Tracking ID</th>
                                        <th class="px-6 py-3">Total</th>
                                        <th class="px-6 py-3">Status Pesanan</th>
                                        {{-- KOLOM BARU: Status Laporan --}}
                                        <th class="px-6 py-3 text-center">Status Laporan</th> 
                                        <th class="px-6 py-3 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($myOrders as $order)
                                    <tr class="bg-white hover:bg-gray-50 transition">
                                        <td class="px-6 py-4">{{ $order->created_at->format('d M Y') }}</td>
                                        <td class="px-6 py-4 font-mono text-xs font-bold text-gray-600">
                                            #{{ $order->tracking_number }}
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-900">
                                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                        </td>
                                        
                                        {{-- Kolom Status Pesanan --}}
                                        <td class="px-6 py-4">
                                            @php
                                                $statusColor = match($order->status) {
                                                    'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                    'packing' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                    'shipping' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                                                    'completed' => 'bg-green-100 text-green-800 border-green-200',
                                                    'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                                                    default => 'bg-gray-100 text-gray-800',
                                                };
                                            @endphp
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $statusColor }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>

                                        {{-- KOLOM BARU: Status Laporan --}}
                                        <td class="px-6 py-4 text-center">
                                            @if($order->report)
                                                {{-- Logika Warna Badge Laporan --}}
                                                @php
                                                    $reportColor = match($order->report->status) {
                                                        'pending' => 'bg-orange-100 text-orange-700 border-orange-200',
                                                        'process' => 'bg-blue-100 text-blue-700 border-blue-200',
                                                        'resolved' => 'bg-green-100 text-green-700 border-green-200',
                                                        'rejected' => 'bg-red-100 text-red-700 border-red-200',
                                                        default => 'bg-gray-100 text-gray-600',
                                                    };
                                                    
                                                    // Terjemahan Status untuk Tampilan
                                                    $statusLabel = match($order->report->status) {
                                                        'pending' => 'Menunggu Respon',
                                                        'process' => 'Sedang Diproses',
                                                        'resolved' => 'Selesai / Disetujui',
                                                        'rejected' => 'Ditolak',
                                                        default => ucfirst($order->report->status),
                                                    };
                                                @endphp
                                                
                                                <div class="inline-flex flex-col items-center gap-1">
                                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] uppercase tracking-wide font-bold border {{ $reportColor }}">
                                                        {{ $statusLabel }}
                                                    </span>
                                                    <span class="text-[10px] text-gray-400">
                                                        {{ $order->report->created_at->diffForHumans() }}
                                                    </span>
                                                </div>
                                            @else
                                                <span class="text-gray-300 text-xs">-</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('orders.show', $order->id) }}" class="inline-flex items-center text-sm font-medium text-fuchsia-600 hover:text-fuchsia-800 transition">
                                                Detail
                                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada pesanan</h3>
                            <p class="mt-1 text-sm text-gray-500">Mulai belanja untuk melihat riwayat pesanan di sini.</p>
                            <div class="mt-6">
                                <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-fuchsia-600 hover:bg-fuchsia-700 focus:outline-none">
                                    Belanja Sekarang
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
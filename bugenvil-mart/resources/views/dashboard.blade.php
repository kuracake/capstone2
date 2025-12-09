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

                <a href="{{ route('checkout') }}" class="block p-6 bg-white rounded-lg border border-gray-200 shadow-md hover:bg-gray-50 transition">
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold text-lg mb-4">Riwayat Pesanan Terakhir</h3>
                    
                    @if(isset($myOrders) && $myOrders->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3">Tanggal</th>
                                        <th class="px-6 py-3">Total Harga</th>
                                        <th class="px-6 py-3">Status</th>
                                        <th class="px-6 py-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($myOrders as $order)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4">{{ $order->created_at->format('d M Y') }}</td>
                                        <td class="px-6 py-4">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full">
                                                {{ $order->status ?? 'Menunggu' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="#" class="font-medium text-blue-600 hover:underline">Detail</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8 bg-gray-50 rounded-lg">
                            <p class="text-gray-500 mb-2">Belum ada riwayat pesanan.</p>
                            <a href="{{ route('products.index') }}" class="text-pink-600 hover:underline font-semibold">Yuk belanja sekarang!</a>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
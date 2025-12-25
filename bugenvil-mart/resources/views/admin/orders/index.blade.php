<x-admin-layout>
    <div class="p-4 sm:ml-64">
        <div class="p-4 mt-14">
            
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Daftar Pesanan</h1>
                    <p class="text-gray-500 text-sm">Kelola semua transaksi masuk.</p>
                </div>
            </div>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-3">ID Order</th>
                                <th class="px-6 py-3">Pembeli</th>
                                <th class="px-6 py-3">Total</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    #{{ $order->tracking_number }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold">{{ $order->user->name }}</div>
                                    <div class="text-xs text-gray-400">{{ $order->user->email }}</div>
                                </td>
                                <td class="px-6 py-4 font-bold text-fuchsia-600">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-0.5 rounded text-xs font-bold
                                        {{ $order->status == 'pending' ? 'bg-orange-100 text-orange-600' : '' }}
                                        {{ $order->status == 'packing' ? 'bg-blue-100 text-blue-600' : '' }}
                                        {{ $order->status == 'shipping' ? 'bg-purple-100 text-purple-600' : '' }}
                                        {{ $order->status == 'completed' ? 'bg-green-100 text-green-600' : '' }}
                                        {{ $order->status == 'cancelled' ? 'bg-red-100 text-red-600' : '' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{-- TOMBOL LIHAT DETAIL (INI YANG PENTING) --}}
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="inline-flex items-center gap-1 px-3 py-2 bg-fuchsia-50 text-fuchsia-600 rounded-lg hover:bg-fuchsia-100 transition font-bold text-xs border border-fuchsia-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        Kelola
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-4">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
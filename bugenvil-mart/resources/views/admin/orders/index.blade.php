<x-admin-layout>
    
    {{-- HEADER --}}
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800 font-serif">Daftar Pesanan</h2>
        <p class="text-sm text-gray-500">Pantau dan kelola semua transaksi yang masuk.</p>
    </div>

    {{-- TABEL PESANAN --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-gray-600">
                <thead class="bg-gray-50 text-xs uppercase text-gray-400 font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-5">ID Order</th>
                        <th class="px-6 py-5">Pembeli</th>
                        <th class="px-6 py-5">Total</th>
                        <th class="px-6 py-5">Status</th>
                        <th class="px-6 py-5">Tanggal</th>
                        <th class="px-6 py-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($orders as $order)
                        <tr class="hover:bg-fuchsia-50/30 transition duration-200 group">
                            
                            {{-- ID Order --}}
                            <td class="px-6 py-4">
                                <span class="font-mono text-xs font-bold text-fuchsia-600 bg-fuchsia-50 px-2 py-1 rounded-lg border border-fuchsia-100">
                                    #{{ $order->id }}
                                </span>
                            </td>

                            {{-- Info Pembeli --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-tr from-gray-100 to-gray-200 flex items-center justify-center text-xs font-bold text-gray-500 border border-white shadow-sm">
                                        {{ substr($order->user->name ?? '?', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-800">{{ $order->user->name ?? 'User Terhapus' }}</p>
                                        <p class="text-xs text-gray-400">{{ $order->user->email ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Total Harga --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-bold text-gray-900">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </span>
                            </td>

                            {{-- Status Badge --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusStyles = match($order->status) {
                                        'pending' => 'bg-amber-50 text-amber-700 border-amber-100',
                                        'packing' => 'bg-blue-50 text-blue-700 border-blue-100',
                                        'shipping' => 'bg-purple-50 text-purple-700 border-purple-100',
                                        'completed' => 'bg-green-50 text-green-700 border-green-100',
                                        'cancelled' => 'bg-red-50 text-red-700 border-red-100',
                                        default => 'bg-gray-50 text-gray-600 border-gray-100',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold uppercase border {{ $statusStyles }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>

                            {{-- Tanggal --}}
                            <td class="px-6 py-4 text-xs text-gray-500 font-medium whitespace-nowrap">
                                {{ $order->created_at->format('d M Y, H:i') }}
                            </td>

                            {{-- Tombol Aksi --}}
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-200 rounded-lg text-xs font-bold text-gray-700 hover:bg-fuchsia-50 hover:text-fuchsia-700 hover:border-fuchsia-200 transition shadow-sm gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 text-gray-300">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-800">Belum ada pesanan</h3>
                                    <p class="text-gray-500 text-sm mt-1">Pesanan yang masuk akan muncul di sini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($orders->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

</x-admin-layout>
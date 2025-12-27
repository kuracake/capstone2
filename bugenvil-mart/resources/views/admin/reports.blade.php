<x-admin-layout>
    
    {{-- HEADER --}}
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800 font-serif">Laporan Kendala</h2>
        <p class="text-sm text-gray-500">Kelola keluhan, retur, dan laporan kerusakan dari pelanggan.</p>
    </div>

    {{-- ALERT NOTIFIKASI --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" class="mb-6 flex items-center p-4 bg-green-50 border-l-4 border-green-500 rounded-r-xl shadow-sm">
            <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="text-green-800 font-medium text-sm">{{ session('success') }}</span>
            <button @click="show = false" class="ml-auto text-green-400 hover:text-green-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
    @endif

    {{-- TABEL LAPORAN --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-gray-600">
                <thead class="bg-gray-50 text-xs uppercase text-gray-400 font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-5">Pelanggan</th>
                        <th class="px-6 py-5">No. Pesanan</th>
                        <th class="px-6 py-5">Detail Masalah</th>
                        <th class="px-6 py-5 text-center">Bukti</th>
                        <th class="px-6 py-5 text-center">Status</th>
                        <th class="px-6 py-5 text-center">Tindak Lanjut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($reports as $report)
                        <tr class="hover:bg-fuchsia-50/30 transition duration-200 group">
                            
                            {{-- Info Pelanggan --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-fuchsia-100 to-purple-100 text-fuchsia-600 flex items-center justify-center font-bold text-xs border border-white shadow-sm">
                                        {{ substr($report->user->name ?? '?', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-800">{{ $report->user->name ?? 'User Hapus' }}</p>
                                        <p class="text-[10px] text-gray-400">{{ $report->created_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- No Pesanan --}}
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.orders.show', $report->order_id) }}" class="inline-flex items-center gap-1 px-3 py-1 bg-gray-50 text-gray-600 text-xs font-mono font-bold rounded-lg border border-gray-200 hover:bg-fuchsia-50 hover:text-fuchsia-600 hover:border-fuchsia-200 transition">
                                    #{{ $report->order->tracking_number ?? $report->order_id }}
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>
                            </td>

                            {{-- Detail Masalah --}}
                            <td class="px-6 py-4">
                                <p class="text-xs text-gray-600 leading-relaxed line-clamp-2 max-w-[200px]" title="{{ $report->description }}">
                                    {{ $report->description }}
                                </p>
                            </td>

                            {{-- Bukti Foto --}}
                            <td class="px-6 py-4 text-center">
                                @if($report->image)
                                    <a href="{{ asset('storage/' . $report->image) }}" target="_blank" class="inline-flex items-center justify-center p-2 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition shadow-sm" title="Lihat Foto Bukti">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </a>
                                @else
                                    <span class="text-xs text-gray-300 italic">-</span>
                                @endif
                            </td>

                            {{-- Status Badge --}}
                            <td class="px-6 py-4 text-center">
                                @php
                                    $statusColor = match($report->status) {
                                        'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                        'process' => 'bg-blue-50 text-blue-600 border-blue-100',
                                        'resolved' => 'bg-green-50 text-green-600 border-green-100',
                                        'rejected' => 'bg-red-50 text-red-600 border-red-100',
                                        default => 'bg-gray-50 text-gray-600',
                                    };
                                    $statusLabel = match($report->status) {
                                        'pending' => 'Menunggu',
                                        'process' => 'Diproses',
                                        'resolved' => 'Selesai',
                                        'rejected' => 'Ditolak',
                                        default => ucfirst($report->status),
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase border {{ $statusColor }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>

                            {{-- Aksi (Menggunakan Select Option - STABIL) --}}
                            <td class="px-6 py-4 text-center relative">
                                <form action="{{ route('admin.reports.update', $report->id) }}" method="POST">
                                    @csrf 
                                    @method('PATCH')
                                    
                                    <div class="relative w-32 mx-auto">
                                        <select name="status" onchange="this.form.submit()" class="appearance-none w-full bg-white border border-gray-200 text-gray-700 text-xs font-bold py-2 px-3 pr-8 rounded-lg focus:outline-none focus:border-fuchsia-500 focus:ring-1 focus:ring-fuchsia-500 cursor-pointer shadow-sm hover:bg-gray-50 transition">
                                            <option disabled selected>Update</option>
                                            <option value="process" class="text-blue-600 font-bold">🔹 Proses</option>
                                            <option value="resolved" class="text-green-600 font-bold">✅ Selesai</option>
                                            <option value="rejected" class="text-red-600 font-bold">❌ Tolak</option>
                                        </select>
                                        
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-green-50 rounded-full flex items-center justify-center mb-4 text-green-400">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-800">Tidak ada laporan</h3>
                                    <p class="text-gray-500 text-sm mt-1">Semua pesanan berjalan lancar tanpa kendala.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination --}}
        @if(isset($reports) && $reports instanceof \Illuminate\Pagination\LengthAwarePaginator && $reports->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                {{ $reports->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
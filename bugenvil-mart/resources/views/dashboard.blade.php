<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 border border-purple-100">
                <div class="p-6 text-gray-900 flex items-center justify-between">
                    <div>
                        Halo, <strong>{{ Auth::user()->name }}</strong>! Selamat datang kembali.
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ now()->format('d M Y') }}
                    </div>
                </div>
            </div>

         <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-8">
                <h3 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">Pesanan Saya</h3>
                
                @if(Auth::user()->orders && Auth::user()->orders->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm border-collapse">
                            <thead class="bg-gray-50 text-gray-600 font-bold border-b">
                                <tr>
                                    <th class="p-4">No. Resi</th>
                                    <th class="p-4">Total</th>
                                    <th class="p-4">Status</th> <th class="p-4">Tanggal</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                @foreach(Auth::user()->orders as $order)
                                <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                                    
                                    <td class="p-4 font-bold text-fuchsia-600">
                                        #{{ $order->tracking_number }}
                                    </td>

                                    <td class="p-4">
                                        Rp {{ number_format($order->total_price) }}
                                    </td>

                                    <td class="p-4">
                                        @if($order->status == 'pending')
                                            <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-bold border border-gray-200 inline-block">
                                                ⏳ Menunggu Konfirmasi
                                            </span>
                                        @elseif($order->status == 'packing')
                                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-bold border border-yellow-200 inline-block">
                                                📦 Sedang Dikemas
                                            </span>
                                        @elseif($order->status == 'shipping')
                                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold border border-blue-200 inline-block">
                                                🚚 Sedang Diantar
                                            </span>
                                        @elseif($order->status == 'completed')
                                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold border border-green-200 inline-block">
                                                ✅ Sampai Tujuan
                                            </span>
                                        @endif
                                    </td>

                                    <td class="p-4 text-gray-500">
                                        {{ $order->created_at->format('d M Y') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500 bg-gray-50 rounded-lg">
                        <p>Belum ada pesanan.</p>
                    </div>
                @endif
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-red-500">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-bold mb-1 text-gray-800">Layanan Garansi & Komplain</h3>
                        <p class="text-gray-500 text-sm mb-4">Pantau status laporan kerusakan bunga Anda di sini.</p>
                    </div>
                    <a href="{{ route('home') }}#report-issue" class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-red-700 transition shadow">
                        Buat Laporan Baru
                    </a>
                </div>
                
                <div class="mt-4 space-y-4">
                    @forelse(Auth::user()->reports as $report)
                        <div class="border rounded-lg p-4 flex justify-between items-center bg-gray-50">
                            <div>
                                <div class="font-bold text-gray-700">{{ $report->subject }}</div>
                                <div class="text-xs text-gray-500">{{ Str::limit($report->description, 50) }}</div>
                                <div class="text-xs text-gray-400 mt-1">{{ $report->created_at->diffForHumans() }}</div>
                            </div>
                            <div class="flex flex-col items-end gap-2">
                                <span class="px-3 py-1 rounded-full text-xs font-bold 
                                    {{ $report->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">
                                    {{ ucfirst($report->status) }}
                                </span>
                                <a href="{{ asset('storage/' . $report->evidence_image_path) }}" target="_blank" class="text-xs text-blue-600 underline hover:text-blue-800">
                                    Lihat Foto Bukti
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400 italic">Tidak ada laporan komplain aktif.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
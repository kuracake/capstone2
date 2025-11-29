<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard - Bugenvil Mart') }}
        </h2>
    </x-slot>

<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mt-8">
    <h3 class="text-xl font-bold mb-4 text-gray-800">Pesanan Masuk (Perlu Proses)</h3>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm border-collapse">
            <thead class="bg-gray-100 text-gray-700 font-bold border-b">
                <tr>
                    <th class="p-3">Pelanggan</th>
                    <th class="p-3">Total</th>
                    <th class="p-3 w-1/3">Alamat</th>
                    <th class="p-3">Status Saat Ini</th>
                    <th class="p-3">Aksi (Update Status)</th>
                </tr>
            </thead>
            <tbody>
                @foreach(\App\Models\Order::where('status', '!=', 'completed')->latest()->get() as $order)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">
                        <div class="font-bold text-gray-800">{{ $order->user->name }}</div>
                        <div class="text-xs text-gray-500">{{ $order->tracking_number }}</div>
                    </td>
                    <td class="p-3 text-fuchsia-600 font-bold">
                        Rp {{ number_format($order->total_price) }}
                    </td>
                    <td class="p-3 text-xs text-gray-600 leading-relaxed">
                        {{ $order->shipping_address }}
                    </td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded text-xs font-bold uppercase
                            {{ $order->status == 'pending' ? 'bg-gray-200 text-gray-700' : '' }}
                            {{ $order->status == 'packing' ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $order->status == 'shipping' ? 'bg-blue-100 text-blue-700' : '' }}">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td class="p-3">
                        @if($order->status == 'pending')
                            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="packing">
                                <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg text-xs font-bold shadow flex items-center gap-1 transition w-full justify-center">
                                    📦 Kemas
                                </button>
                            </form>

                        @elseif($order->status == 'packing')
                            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="shipping">
                                <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg text-xs font-bold shadow flex items-center gap-1 transition w-full justify-center">
                                    🚚 Kirim
                                </button>
                            </form>

                        @elseif($order->status == 'shipping')
                            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="completed">
                                <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg text-xs font-bold shadow flex items-center gap-1 transition w-full justify-center">
                                    ✅ Selesai
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mt-8">
    <h3 class="text-xl font-bold mb-4">Update Video Tutorial</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach(\App\Models\VideoTutorial::all() as $video)
        <form action="{{ route('admin.videos.update', $video->id) }}" method="POST" class="bg-gray-50 p-4 rounded-xl">
            @csrf @method('PUT')
            <div class="mb-2">
                <label class="text-xs font-bold text-gray-500">Judul</label>
                <input type="text" name="title" value="{{ $video->title }}" class="w-full text-sm border-gray-300 rounded">
            </div>
            <div class="mb-2">
                <label class="text-xs font-bold text-gray-500">Link Youtube</label>
                <input type="text" name="video_url" value="{{ $video->video_url }}" class="w-full text-sm border-gray-300 rounded">
            </div>
            <button class="w-full bg-fuchsia-600 text-white text-xs py-2 rounded font-bold">Simpan</button>
        </form>
        @endforeach
    </div>
</div>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-pink-500">
                    <div class="text-gray-500">Total Bunga Dijual</div>
                    <div class="text-3xl font-bold">{{ $totalProducts }}</div>
                    <a href="{{ route('products.index') }}" class="text-pink-600 hover:underline text-sm mt-2 block">Kelola Produk &rarr;</a>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-red-500">
                    <div class="text-gray-500">Komplain Pending</div>
                    <div class="text-3xl font-bold">{{ $totalReports }}</div>
                    <a href="{{ route('admin.reports') }}" class="text-red-600 hover:underline text-sm mt-2 block">Lihat Laporan &rarr;</a>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-gray-500">Video Tutorial</div>
                    <div class="text-3xl font-bold">3</div>
                    <a href="{{ route('admin.videos.index') }}" class="text-blue-600 hover:underline text-sm mt-2 block">Update Video &rarr;</a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-bold mb-4">Komplain Terbaru Masuk</h3>
                    @if($recentReports->isEmpty())
                        <p class="text-gray-500">Belum ada komplain baru.</p>
                    @else
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="p-3">User</th>
                                    <th class="p-3">Masalah</th>
                                    <th class="p-3">Status</th>
                                    <th class="p-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentReports as $report)
                                <tr class="border-b">
                                    <td class="p-3">{{ $report->user->name }}</td>
                                    <td class="p-3">{{ $report->subject }}</td>
                                    <td class="p-3">
                                        <span class="px-2 py-1 text-xs rounded {{ $report->status == 'pending' ? 'bg-red-200 text-red-800' : 'bg-green-200 text-green-800' }}">
                                            {{ ucfirst($report->status) }}
                                        </span>
                                    </td>
                                    <td class="p-3">
                                        <a href="{{ route('admin.reports') }}" class="text-blue-600 text-sm hover:underline">Detail</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
<x-app-layout>
    {{-- Scripts Midtrans --}}
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    <div class="bg-gray-50/50 min-h-screen py-8 md:py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">

            {{-- Breadcrumb & Back --}}
            <div class="flex items-center justify-between mb-8">
                <a href="{{ route('dashboard') }}" class="flex items-center text-gray-500 hover:text-fuchsia-600 transition gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span class="font-medium">Kembali ke Dashboard</span>
                </a>
                <span class="text-xs font-bold bg-gray-200 text-gray-600 px-3 py-1 rounded-full">
                    Order ID: #{{ $order->tracking_number }}
                </span>
            </div>

            <div class="flex flex-col lg:flex-row gap-8 items-start">
                
                {{-- KOLOM KIRI: Detail Item & Alamat --}}
                <div class="w-full lg:w-2/3 space-y-6">
                    
                    {{-- Status Banner --}}
                    <div class="rounded-3xl p-6 flex items-center gap-4 shadow-sm border
                        @if($order->status == 'pending') bg-orange-50 border-orange-100 text-orange-800
                        @elseif($order->status == 'completed') bg-green-50 border-green-100 text-green-800
                        @elseif($order->status == 'shipping') bg-blue-50 border-blue-100 text-blue-800
                        @else bg-gray-50 border-gray-100 text-gray-800 @endif">
                        
                        <div class="p-3 rounded-full bg-white shadow-sm">
                            @if($order->status == 'pending')
                                <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            @elseif($order->status == 'completed')
                                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            @elseif($order->status == 'shipping')
                                <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            @else
                                <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            @endif
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">
                                @if($order->status == 'pending') Menunggu Pembayaran
                                @elseif($order->status == 'packing') Sedang Dikemas
                                @elseif($order->status == 'shipping') Dalam Pengiriman
                                @elseif($order->status == 'completed') Pesanan Selesai
                                @else Status: {{ ucfirst($order->status) }}
                                @endif
                            </h3>
                            <p class="text-sm opacity-80">
                                @if($order->status == 'pending') Selesaikan pembayaran agar pesanan segera diproses.
                                @elseif($order->status == 'completed') Paket telah diterima. Terima kasih!
                                @elseif($order->status == 'shipping') Paket sedang dalam perjalanan.
                                @else Paket Anda sedang diproses.
                                @endif
                            </p>
                        </div>
                    </div>

                    {{-- === KOTAK RESI (INI BAGIAN PENTINGNYA) === --}}
                    @if($order->resi)
                        <div class="bg-white rounded-3xl shadow-lg shadow-blue-50 border border-blue-100 p-6 relative overflow-hidden">
                            <div class="absolute top-0 left-0 w-1 h-full bg-blue-500"></div>
                            
                            {{-- Header Kotak Resi --}}
                            <h4 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                PELACAKAN PAKET
                            </h4>

                            <div class="bg-blue-50/50 p-4 rounded-xl border border-blue-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                                <div>
                                    <p class="text-xs text-blue-400 uppercase font-bold mb-1">Nomor Resi / AWB</p>
                                    <p class="text-3xl font-mono font-bold text-gray-800 tracking-widest select-all">{{ $order->resi }}</p>
                                </div>
                                <button onclick="navigator.clipboard.writeText('{{ $order->resi }}'); alert('Resi disalin!')" class="px-4 py-2 bg-white text-blue-600 font-bold rounded-lg border border-blue-200 hover:bg-blue-50 transition shadow-sm text-sm">
                                    Salin Teks
                                </button>
                            </div>
                            <p class="text-xs text-gray-400 mt-3 italic text-center sm:text-left">
                                Gunakan nomor ini untuk melacak paket di website ekspedisi terkait.
                            </p>
                        </div>
                    @endif
                    {{-- ============================================== --}}

                    {{-- Card: Daftar Barang --}}
                    <div class="bg-white rounded-3xl shadow-lg shadow-gray-100 border border-gray-100 p-6 md:p-8">
                        <h4 class="font-bold text-gray-800 mb-6 flex items-center gap-2">
                            <span class="bg-fuchsia-100 text-fuchsia-600 p-2 rounded-lg"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg></span>
                            Rincian Produk
                        </h4>
                        <div class="space-y-6">
                            @foreach($order->items as $item)
                                <div class="flex gap-4 items-start">
                                    <div class="w-20 h-20 flex-shrink-0 bg-gray-100 rounded-xl overflow-hidden border border-gray-200">
                                        @if($item->product && $item->product->image)
                                            <img src="{{ asset('storage/'.$item->product->image) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">No Img</div>
                                        @endif
                                    </div>
                                    <div class="flex-grow">
                                        <h5 class="font-bold text-gray-800">{{ $item->product_name }}</h5>
                                        <div class="text-sm text-gray-500 mt-1">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                                    </div>
                                    <div class="font-bold text-fuchsia-600">
                                        Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                    </div>
                                </div>
                                @if(!$loop->last) <hr class="border-dashed border-gray-100"> @endif
                            @endforeach
                        </div>
                    </div>

                    {{-- Card: Alamat --}}
                    <div class="bg-white rounded-3xl shadow-lg shadow-gray-100 border border-gray-100 p-6 md:p-8">
                        <h4 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <span class="bg-blue-100 text-blue-600 p-2 rounded-lg"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg></span>
                            Tujuan Pengiriman
                        </h4>
                        <p class="text-gray-600 leading-relaxed bg-gray-50 p-4 rounded-xl border border-gray-100 text-sm">
                            {{ $order->shipping_address }}
                        </p>
                    </div>
                </div>

                {{-- KOLOM KANAN --}}
                <div class="w-full lg:w-1/3 space-y-6">
                    <div class="bg-white rounded-3xl shadow-xl shadow-fuchsia-50 border border-fuchsia-100 p-6 md:p-8 sticky top-8">
                        <h4 class="font-bold text-gray-800 mb-6 text-lg">Rincian Pembayaran</h4>
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between items-center text-gray-600">
                                <span>Status</span>
                                <span class="px-2 py-1 rounded text-xs font-bold uppercase tracking-wider
                                    {{ $order->status == 'pending' ? 'bg-orange-100 text-orange-600' : 'bg-green-100 text-green-600' }}">
                                    {{ $order->status }}
                                </span>
                            </div>
                            <div class="border-t border-gray-100 my-2"></div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-800 font-bold text-lg">Total Bayar</span>
                                <span class="text-2xl font-bold text-fuchsia-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        {{-- TOMBOL BAYAR --}}
                        @if($order->status == 'pending')
                            <button id="pay-button" class="w-full bg-gradient-to-r from-fuchsia-600 to-purple-600 text-white py-4 rounded-xl font-bold hover:shadow-lg hover:shadow-fuchsia-200 transition-all flex justify-center items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                Bayar Sekarang
                            </button>
                        @endif

                        {{-- TOMBOL LAPOR --}}
                        @if(($order->status == 'completed' || $order->status == 'shipping') && !$order->report)
                            <div class="mt-6 pt-6 border-t border-gray-100">
                                <p class="text-xs text-gray-500 mb-3 text-center">Ada masalah?</p>
                                <a href="{{ route('reports.create', $order->id) }}" class="block w-full text-center py-3 border border-red-200 text-red-600 rounded-xl font-bold hover:bg-red-50 transition">
                                    Ajukan Komplain / Retur
                                </a>
                            </div>
                        @elseif($order->report)
                             <div class="mt-6 pt-6 border-t border-gray-100 text-center">
                                <span class="inline-block px-4 py-2 bg-yellow-50 text-yellow-700 rounded-lg text-sm font-bold border border-yellow-200">
                                    Laporan: {{ ucfirst($order->report->status) }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Script JavaScript Midtrans --}}
    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        if(payButton) {
            payButton.addEventListener('click', function () {
                var snapToken = '{{ $order->snap_token }}';
                if (!snapToken) return;
                window.snap.pay(snapToken, {
                    onSuccess: function(result){ window.location.href = "{{ route('dashboard') }}?payment=success"; },
                    onPending: function(result){ window.location.reload(); },
                    onError: function(result){ window.location.reload(); }
                });
            });
        }
    </script>
</x-app-layout>
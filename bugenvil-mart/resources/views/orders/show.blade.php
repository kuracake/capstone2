<x-app-layout>
    {{-- 
        Konfigurasi Midtrans Snap
        Pastikan key 'services.midtrans.client_key' sudah ada di config/services.php 
    --}}
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" 
            data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl p-8 border border-gray-100">
                
                {{-- HEADER: ID Pesanan --}}
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-fuchsia-100 text-fuchsia-600 rounded-full mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Detail Pesanan</h2>
                    <p class="text-gray-500">ID: #{{ $order->tracking_number }}</p>
                </div>

                {{-- INFO PEMBAYARAN --}}
                <div class="border-t border-b border-gray-100 py-4 mb-6">
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Total Pembayaran</span>
                        <span class="font-bold text-fuchsia-600 text-lg">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Status Pembayaran</span>
                        <span class="px-3 py-1 rounded-full text-xs font-bold 
                            {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">
                            {{ strtoupper($order->status) }}
                        </span>
                    </div>
                </div>

                {{-- STATUS PENGIRIMAN / TOMBOL BAYAR --}}
                <div class="mt-6">
                    @if($order->status == 'pending')
                        <button id="pay-button" class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700 transition shadow-lg">
                            Bayar Sekarang
                        </button>
                    @else
                        <div class="p-4 rounded-lg bg-green-50 border border-green-200 text-green-800 text-center">
                            <span class="block text-sm text-green-600 mb-1">Status Pesanan:</span>
                            <span class="font-bold text-lg">
                                @if($order->status == 'packing') Sedang Dikemas
                                @elseif($order->status == 'shipping') Dalam Pengiriman
                                @elseif($order->status == 'completed') Selesai
                                @else {{ ucfirst($order->status) }}
                                @endif
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- BAGIAN TINDAKAN (LAPOR / KEMBALI) --}}
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-2xl p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Tindakan</h3>
                
                <div class="flex flex-wrap gap-4">
                    {{-- Tombol Kembali --}}
                    <a href="{{ route('dashboard') }}" class="px-5 py-2.5 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition font-medium">
                        &larr; Kembali
                    </a>

                    {{-- TOMBOL LAPOR KERUSAKAN --}}
                    {{-- Hanya muncul jika status completed/shipping DAN belum pernah lapor --}}
                    @if(($order->status == 'completed' || $order->status == 'shipping') && !$order->report)
                        <a href="{{ route('reports.create', $order->id) }}" 
                           class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow-md flex items-center gap-2 font-bold transition">
                           <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                           </svg>
                           Lapor Kerusakan / Retur
                        </a>
                    
                    {{-- Jika sudah lapor, tampilkan status --}}
                    @elseif($order->report)
                        <div class="px-5 py-2.5 bg-yellow-50 text-yellow-800 border border-yellow-200 rounded-lg flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Laporan Anda: <strong>{{ ucfirst($order->report->status) }}</strong></span>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    {{-- Script Trigger Snap Midtrans --}}
    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        
        if(payButton) {
            payButton.addEventListener('click', function () {
                var snapToken = '{{ $order->snap_token }}';
                console.log("Snap Token:", snapToken);

                if (!snapToken) {
                    alert('Error: Snap Token tidak ditemukan. Silakan hubungi admin.');
                    return;
                }

                window.snap.pay(snapToken, {
                    onSuccess: function(result){
                        alert("Pembayaran Berhasil!");
                        window.location.href = "{{ route('dashboard') }}";
                    },
                    onPending: function(result){
                        alert("Menunggu Pembayaran!");
                        window.location.reload();
                    },
                    onError: function(result){
                        alert("Pembayaran Gagal!");
                        window.location.reload();
                    },
                    onClose: function(){
                        alert('Anda menutup popup tanpa menyelesaikan pembayaran');
                    }
                });
            });
        }
    </script>
</x-app-layout>
<x-app-layout>
    {{-- Script Midtrans (Wajib Ada) --}}
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl p-8 border border-gray-100">
                
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-fuchsia-100 text-fuchsia-600 rounded-full mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Pesanan Berhasil Dibuat!</h2>
                    <p class="text-gray-500">ID Pesanan: #{{ $order->tracking_number }}</p>
                </div>

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

                {{-- Tombol Bayar --}}
                @if($order->status == 'pending')
                    <button id="pay-button" class="w-full bg-fuchsia-600 hover:bg-fuchsia-700 text-white font-bold py-4 rounded-xl shadow-lg transition transform hover:scale-105">
                        BAYAR SEKARANG
                    </button>
                @else
                    <div class="text-center p-4 bg-green-50 text-green-700 rounded-lg">
                        Pembayaran Lunas
                    </div>
                @endif

                <div class="mt-6 text-center">
                    <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:underline">Kembali ke Dashboard</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Script Trigger Snap --}}
    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        if(payButton) {
            payButton.addEventListener('click', function () {
                // Trigger snap popup
                window.snap.pay('{{ $order->snap_token }}', {
                    onSuccess: function(result){
                        alert("Pembayaran Berhasil!");
                        window.location.reload();
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
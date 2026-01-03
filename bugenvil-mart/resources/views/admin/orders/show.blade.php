<x-app-layout>
    <div class="p-4 sm:ml-64">
        <div class="p-4 mt-14">
            
            {{-- Header --}}
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Detail Pesanan</h2>
                    <p class="text-gray-500 text-sm">Order ID: #{{ $order->tracking_number }}</p>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition text-sm font-bold">
                    &larr; Kembali
                </a>
            </div>

            @if(session('success'))
                <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200 shadow-sm" role="alert">
                    <span class="font-bold">Berhasil!</span> {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                {{-- KOLOM KIRI: INFO (Tidak Berubah) --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="font-bold text-lg text-gray-800 mb-4">Data Pengiriman</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-xs text-gray-400 uppercase font-bold mb-1">Penerima</p>
                                <p class="text-gray-800 font-bold text-lg">{{ $order->user->name ?? 'User Terhapus' }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-xs text-gray-400 uppercase font-bold mb-1">Alamat</p>
                                <p class="text-gray-800 text-sm">{{ $order->shipping_address }}</p>
                            </div>
                        </div>
                    </div>
                    
                    {{-- List Produk --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="font-bold text-lg text-gray-800 mb-4">Barang</h3>
                        @foreach($order->items as $item)
                            <div class="flex items-center gap-4 bg-gray-50 p-3 rounded-lg mb-2">
                                <div class="font-bold">{{ $item->product_name }}</div>
                                <div class="text-sm text-gray-500">{{ $item->quantity }} pcs</div>
                                <div class="ml-auto font-mono text-sm">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                            </div>
                        @endforeach
                        <div class="mt-4 pt-4 border-t flex justify-between items-center">
                            <span class="font-bold text-gray-600">Total Transaksi</span>
                            <span class="font-bold text-xl text-fuchsia-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: STATUS & RESI (SUDAH DIPERBAIKI) --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-lg border border-fuchsia-100 p-6 sticky top-24">
                        <h3 class="font-bold text-lg text-gray-800 mb-4 border-b pb-2">Kelola Pesanan</h3>
                        
                        {{-- Form selalu muncul, tidak peduli sudah ada resi atau belum --}}
                        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            {{-- Status Dropdown --}}
                            <div class="mb-4">
                                <label class="block text-sm font-bold text-gray-600 mb-2">Update Status</label>
                                <select name="status" id="status" class="w-full border-gray-300 rounded-lg p-2.5 focus:ring-fuchsia-500 focus:border-fuchsia-500 transition" onchange="toggleResi()">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                                    <option value="packing" {{ $order->status == 'packing' ? 'selected' : '' }}>Packing (Dikemas)</option>
                                    <option value="shipping" {{ $order->status == 'shipping' ? 'selected' : '' }}>Shipping (Dikirim)</option>
                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled (Batal)</option>
                                </select>
                            </div>

                            {{-- Resi Input --}}
                            {{-- Logic class: Jika status shipping/completed ATAU resi sudah ada isinya, maka tampilkan --}}
                            <div id="resi_field" class="mb-6 {{ ($order->status == 'shipping' || $order->status == 'completed' || !empty($order->resi)) ? '' : 'hidden' }}">
                                <label class="block text-sm font-bold text-gray-600 mb-2">Nomor Resi / AWB</label>
                                <input type="text" 
                                       name="resi" 
                                       value="{{ old('resi', $order->resi) }}" 
                                       class="w-full border-gray-300 rounded-lg p-2.5 font-mono text-gray-800 focus:ring-fuchsia-500 focus:border-fuchsia-500" 
                                       placeholder="Masukkan Nomor Resi">
                                <p class="text-xs text-gray-400 mt-1">Isi nomor resi jika barang sudah dikirim.</p>
                            </div>

                            <button type="submit" class="w-full bg-fuchsia-600 text-white font-bold py-3 rounded-lg hover:bg-fuchsia-700 transition shadow-lg shadow-fuchsia-200">
                                Simpan Perubahan
                            </button>
                        </form>

                        {{-- Info Tambahan (Opsional) --}}
                        @if($order->resi)
                            <div class="mt-6 pt-4 border-t border-gray-100">
                                <p class="text-xs text-gray-400 mb-1">Resi Terakhir Disimpan:</p>
                                <p class="font-mono font-bold text-gray-600 bg-gray-50 p-2 rounded text-center">{{ $order->resi }}</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Script untuk Handle Tampilan Input Resi --}}
    <script>
        function toggleResi() {
            const status = document.getElementById('status').value;
            const resiField = document.getElementById('resi_field');
            
            // Tampilkan field resi jika status Shipping atau Completed
            if (status === 'shipping' || status === 'completed') {
                resiField.classList.remove('hidden');
            } else {
                // Opsional: Sembunyikan jika status kembali ke pending/packing
                // Tapi jika sudah ada isinya, sebaiknya biarkan saja user menghapusnya manual jika mau
                // resiField.classList.add('hidden'); 
                
                // Jika ingin strict (hidden kalau bukan shipping):
                 resiField.classList.add('hidden');
            }
        }
        
        // Jalankan saat halaman dimuat (agar field tidak hilang saat refresh jika status sudah shipping)
        document.addEventListener('DOMContentLoaded', function() {
            toggleResi();
        });
    </script>
</x-app-layout>
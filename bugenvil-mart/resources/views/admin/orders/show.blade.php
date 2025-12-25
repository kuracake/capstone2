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
                
                {{-- KOLOM KIRI: INFO (Biarkan tetap sama) --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="font-bold text-lg text-gray-800 mb-4">Data Pengiriman</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-xs text-gray-400 uppercase font-bold mb-1">Penerima</p>
                                <p class="text-gray-800 font-bold text-lg">{{ $order->user->name }}</p>
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
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- KOLOM KANAN: STATUS & RESI (LOGIKA PENGUNCI) --}}
                <div class="lg:col-span-1">
                    
                    {{-- JIKA RESI SUDAH ADA, KUNCI TAMPILAN --}}
                    @if($order->resi)
                        
                        <div class="bg-green-50 border border-green-200 rounded-xl p-6 sticky top-24 shadow-sm">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="bg-green-100 p-2 rounded-full text-green-600">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-green-800 text-lg">Tersimpan</h3>
                                    <p class="text-xs text-green-600">Data resi sudah permanen.</p>
                                </div>
                            </div>

                            <div class="bg-white p-4 rounded-xl border border-green-100 shadow-sm mb-4">
                                <p class="text-xs text-gray-400 uppercase font-bold mb-1">Status</p>
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-bold capitalize">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>

                            <div class="bg-white p-4 rounded-xl border border-green-100 shadow-sm">
                                <p class="text-xs text-gray-400 uppercase font-bold mb-1">Nomor Resi</p>
                                <p class="text-gray-800 font-mono text-xl font-bold tracking-wider">{{ $order->resi }}</p>
                            </div>
                        </div>

                    {{-- JIKA RESI KOSONG, TAMPILKAN FORM --}}
                    @else
                        
                        <div class="bg-white rounded-xl shadow-lg border border-fuchsia-100 p-6 sticky top-24">
                            <h3 class="font-bold text-lg text-gray-800 mb-4 border-b pb-2">Proses Pesanan</h3>
                            
                            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <div class="mb-4">
                                    <label class="block text-sm font-bold text-gray-600 mb-2">Update Status</label>
                                    <select name="status" id="status" class="w-full border-gray-300 rounded-lg p-2.5" onchange="toggleResi()">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="packing" {{ $order->status == 'packing' ? 'selected' : '' }}>Packing</option>
                                        <option value="shipping" {{ $order->status == 'shipping' ? 'selected' : '' }}>Shipping</option>
                                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>

                                <div id="resi_field" class="mb-6 {{ ($order->status == 'shipping' || $order->status == 'completed') ? '' : 'hidden' }}">
                                    <label class="block text-sm font-bold text-gray-600 mb-2">Nomor Resi / AWB</label>
                                    <input type="text" name="resi" class="w-full border-gray-300 rounded-lg p-2.5 font-mono" placeholder="Contoh: JP1234567890">
                                    <p class="text-xs text-gray-400 mt-1">Pastikan benar, tidak bisa diedit setelah disimpan.</p>
                                </div>

                                <button type="submit" class="w-full bg-fuchsia-600 text-white font-bold py-3 rounded-lg hover:bg-fuchsia-700 transition" onclick="return confirm('Yakin simpan resi? Data tidak bisa diubah lagi.')">
                                    Simpan Permanen
                                </button>
                            </form>
                        </div>

                    @endif
                </div>

            </div>
        </div>
    </div>

    <script>
        function toggleResi() {
            const status = document.getElementById('status').value;
            const resiField = document.getElementById('resi_field');
            if (status === 'shipping' || status === 'completed') {
                resiField.classList.remove('hidden');
            } else {
                resiField.classList.add('hidden');
            }
        }
    </script>
</x-app-layout>
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-6">Shopping Cart</h1>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                {{-- Cek apakah keranjang tidak kosong --}}
                @if($cartItems->count() > 0)
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b">
                                <th class="p-4">Product</th>
                                <th class="p-4">Price</th>
                                <th class="p-4">Quantity</th>
                                <th class="p-4">Subtotal</th>
                                <th class="p-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                                <tr class="border-b">
                                    <td class="p-4 flex items-center">
                                        {{-- Perhatikan akses object: $item->product->image --}}
                                        <img src="{{ $item->product->image ? asset('storage/'.$item->product->image) : 'https://via.placeholder.com/60' }}" 
                                             width="60" class="rounded mr-4 object-cover h-16 w-16">
                                        
                                        <span class="font-bold">{{ $item->product->name }}</span>
                                    </td>
                                    <td class="p-4">Rp{{ number_format($item->product->price, 0, ',', '.') }}</td>
                                    <td class="p-4">{{ $item->quantity }}</td>
                                    <td class="p-4 font-bold text-indigo-600">
                                        Rp{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                    </td>
                                    <td class="p-4">
                                        <form action="{{ route('cart.remove') }}" method="POST">
                                            @csrf @method('DELETE')
                                            {{-- Kirim ID dari tabel cart_items --}}
                                            <input type="hidden" name="id" value="{{ $item->id }}">
                                            <button class="text-red-500 hover:text-red-700 font-semibold">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-6 flex justify-between items-center">
                        <h3 class="text-2xl font-bold">Total: Rp{{ number_format($grandTotal, 0, ',', '.') }}</h3>
                        
                        <a href="{{ route('checkout') }}" class="bg-green-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-green-700 transition">
                            Proceed to Checkout
                        </a>
                    </div>
                @else
                    <div class="text-center py-10">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <p class="text-gray-500 text-lg mb-4">Keranjang belanja Anda kosong.</p>
                        <a href="{{ route('products.index') }}" class="text-indigo-600 hover:underline font-semibold">Mulai Belanja</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
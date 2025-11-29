<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-6">Shopping Cart</h1>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if(session('cart'))
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
                            @php $total = 0 @endphp
                            @foreach(session('cart') as $id => $details)
                                @php $total += $details['price'] * $details['quantity'] @endphp
                                <tr class="border-b">
                                    <td class="p-4 flex items-center">
                                        <img src="{{ $details['image'] ? asset('storage/'.$details['image']) : 'https://via.placeholder.com/60' }}" width="60" class="rounded mr-4">
                                        <span class="font-bold">{{ $details['name'] }}</span>
                                    </td>
                                    <td class="p-4">${{ $details['price'] }}</td>
                                    <td class="p-4">{{ $details['quantity'] }}</td>
                                    <td class="p-4 font-bold text-indigo-600">${{ $details['price'] * $details['quantity'] }}</td>
                                    <td class="p-4">
                                        <form action="{{ route('cart.remove') }}" method="POST">
                                            @csrf @method('DELETE')
                                            <input type="hidden" name="id" value="{{ $id }}">
                                            <button class="text-red-500 hover:text-red-700">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-6 flex justify-between items-center">
                        <h3 class="text-2xl font-bold">Total: ${{ $total }}</h3>
                        
                        <a href="{{ route('checkout') }}" class="bg-green-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-green-700">
                            Proceed to Checkout
                        </a>
                    </div>
                @else
                    <div class="text-center py-10">
                        <p class="text-gray-500 text-lg mb-4">Your cart is empty.</p>
                        <a href="{{ route('home') }}" class="text-indigo-600 hover:underline">Continue Shopping</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
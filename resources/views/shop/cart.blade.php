<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your Shopping Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if(session('cart'))
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="border-b py-2">Product</th>
                                <th class="border-b py-2">Price</th>
                                <th class="border-b py-2">Quantity</th>
                                <th class="border-b py-2">Subtotal</th>
                                <th class="border-b py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0 @endphp
                            @foreach(session('cart') as $id => $details)
                                @php $total += $details['price'] * $details['quantity'] @endphp
                                <tr>
                                    <td class="py-4">{{ $details['name'] }}</td>
                                    <td class="py-4">৳{{ number_format($details['price'], 2) }}</td>
                                    <td class="py-4">{{ $details['quantity'] }}</td>
                                    <td class="py-4 font-bold">৳{{ number_format($details['price'] * $details['quantity'], 2) }}</td>
                                    <td class="py-4">
                                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-bold">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <div class="mt-6 flex justify-between items-center bg-gray-50 p-4 rounded-lg">
                        <span class="text-xl font-bold text-gray-800">Total: ৳{{ number_format($total, 2) }}</span>
                        <a href="{{ route('checkout.index') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition">Proceed to Checkout</a>
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">Your cart is currently empty. Head back to the bazaar to find some local goods!</p>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
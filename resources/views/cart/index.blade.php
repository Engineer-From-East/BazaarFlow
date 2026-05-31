<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Shopping Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if(session('cart') && count(session('cart')) > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border-b py-3 px-4">Product</th>
                                    <th class="border-b py-3 px-4">Price</th>
                                    <th class="border-b py-3 px-4 text-center">Quantity</th>
                                    <th class="border-b py-3 px-4 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach(session('cart') as $id => $details)
                                    @php $total += $details['price'] * $details['quantity']; @endphp
                                    <tr class="hover:bg-gray-50 border-b">
                                        <td class="py-3 px-4 flex items-center space-x-4">
                                            @if(isset($details['image']))
                                                <img src="{{ asset('storage/' . $details['image']) }}" alt="{{ $details['name'] }}" class="w-12 h-12 object-cover rounded">
                                            @else
                                                <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center text-xs text-gray-500">No Img</div>
                                            @endif
                                            <span class="font-bold">{{ $details['name'] }}</span>
                                        </td>
                                        <td class="py-3 px-4">৳{{ number_format($details['price'], 2) }}</td>
                                        <td class="py-3 px-4 text-center">{{ $details['quantity'] }}</td>
                                        <td class="py-3 px-4 text-center">
                                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 font-bold text-sm">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 flex flex-col items-end border-t pt-4">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Total: ৳{{ number_format($total, 2) }}</h3>
                        <a href="{{ route('checkout.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-lg transition text-lg">
                            Proceed to Checkout
                        </a>
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-500 text-lg mb-4">The cart is currently empty.</p>
                        <a href="{{ route('shop.index') }}" class="text-indigo-600 hover:text-indigo-800 font-bold">
                            &larr; Return to Shop
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
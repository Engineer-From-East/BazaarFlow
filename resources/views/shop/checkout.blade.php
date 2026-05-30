<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <h3 class="text-lg font-bold mb-4 text-gray-900">Delivery Details</h3>
                
                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="phone_number" class="block text-gray-700 font-bold mb-2">Phone Number:</label>
                        <input type="text" name="phone_number" id="phone_number" class="w-full border-gray-300 rounded-md shadow-sm" required placeholder="e.g., 01XXXXXXXXX">
                    </div>

                    <div class="mb-6">
                        <label for="shipping_address" class="block text-gray-700 font-bold mb-2">Shipping Address:</label>
                        <textarea name="shipping_address" id="shipping_address" rows="3" class="w-full border-gray-300 rounded-md shadow-sm" required placeholder="Enter your full delivery address..."></textarea>
                    </div>

                    <div class="border-t pt-4 flex justify-between items-center">
                        <span class="text-xl font-bold text-gray-800">
                            @php $total = 0; @endphp
                            @foreach(session('cart') as $details)
                                @php $total += $details['price'] * $details['quantity']; @endphp
                            @endforeach
                            Total to Pay: ৳{{ number_format($total, 2) }}
                        </span>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition">
                            Place Order
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
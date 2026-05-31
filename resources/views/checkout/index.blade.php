<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Secure Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col md:flex-row gap-8">
                
                <div class="w-full md:w-1/2">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">Delivery Details</h3>
                    
                    <form action="{{ route('checkout.process') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="phone" class="block text-gray-700 font-bold mb-2">Phone Number:</label>
                            <input type="text" name="phone" id="phone" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required placeholder="e.g., 01712345678">
                        </div>

                        <div class="mb-6">
                            <label for="address" class="block text-gray-700 font-bold mb-2">Full Delivery Address:</label>
                            <textarea name="address" id="address" rows="4" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required placeholder="House, Road, Area, Rajshahi..."></textarea>
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg transition text-lg shadow-md">
                            Place Order (Cash on Delivery)
                        </button>
                    </form>
                </div>

                <div class="w-full md:w-1/2 bg-gray-50 p-6 rounded-lg border border-gray-200">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">Order Summary</h3>
                    
                    <ul class="space-y-4 mb-6">
                        @php $total = 0; @endphp
                        @foreach(session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity']; @endphp
                            <li class="flex justify-between items-center text-sm">
                                <span class="font-semibold text-gray-700">{{ $details['quantity'] }}x {{ $details['name'] }}</span>
                                <span class="text-gray-900 font-bold">৳{{ number_format($details['price'] * $details['quantity'], 2) }}</span>
                            </li>
                        @endforeach
                    </ul>
                    
                    <div class="border-t pt-4 flex justify-between items-center">
                        <span class="text-lg font-bold text-gray-900">Total to Pay:</span>
                        <span class="text-2xl font-extrabold text-indigo-600">৳{{ number_format($total, 2) }}</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
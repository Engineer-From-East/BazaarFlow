<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ Auth::user()->is_admin ? __('Admin Control Center') : __('My Orders') }}
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
                
                <h3 class="text-lg font-bold text-gray-900 mb-4">
                    {{ Auth::user()->is_admin ? 'All Customer Orders' : 'Your Order History' }}
                </h3>

                @if($orders->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border-b py-3 px-4">Order ID</th>
                                    <th class="border-b py-3 px-4">Date</th>
                                    <th class="border-b py-3 px-4">Phone Number</th>
                                    <th class="border-b py-3 px-4">Delivery Address</th>
                                    <th class="border-b py-3 px-4">Total Amount</th>
                                    <th class="border-b py-3 px-4">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border-b py-3 px-4 font-bold">#{{ $order->id }}</td>
                                        <td class="border-b py-3 px-4">{{ $order->created_at->format('M d, Y') }}</td>
                                        <td class="border-b py-3 px-4">{{ $order->phone_number }}</td>
                                        <td class="border-b py-3 px-4">{{ $order->shipping_address }}</td>
                                        <td class="border-b py-3 px-4 text-indigo-600 font-bold">৳{{ number_format($order->total_amount, 2) }}</td>
                                        <td class="border-b py-3 px-4">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 py-4">No orders found yet.</p>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
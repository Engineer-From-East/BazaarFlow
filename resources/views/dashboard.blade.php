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
                                    <tr class="hover:bg-gray-50 pt-2">
                                        <td class="py-3 px-4 font-bold text-gray-800">#{{ $order->id }}</td>
                                        <td class="py-3 px-4">{{ $order->created_at->format('M d, Y') }}</td>
                                        <td class="py-3 px-4">{{ $order->phone_number }}</td>
                                        <td class="py-3 px-4">{{ $order->shipping_address }}</td>
                                        <td class="py-3 px-4 text-indigo-600 font-bold">৳{{ number_format($order->total_amount, 2) }}</td>
                                        <td class="py-3 px-4">
                                            @if(Auth::user()->is_admin)
                                                <form action="{{ route('admin.order.update', $order->id) }}" method="POST" class="flex items-center space-x-2">
                                                    @csrf
                                                    @method('PUT')
                                                    <select name="status" class="text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                        <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                                                    </select>
                                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold py-1 px-2 rounded transition">
                                                        Update
                                                    </button>
                                                </form>
                                            @else
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $order->status == 'delivered' ? 'bg-green-100 text-green-800' : ($order->status == 'shipped' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    
                                    <tr class="border-b bg-gray-50/50">
                                        <td colspan="6" class="pb-4 pt-1 px-4">
                                            <div class="text-sm text-gray-700 bg-white p-3 rounded border border-gray-100 shadow-sm">
                                                <strong class="font-semibold text-gray-900 uppercase text-xs tracking-wider">Items in this order:</strong>
                                                <ul class="list-disc list-inside mt-2 space-y-1 ml-1">
                                                    @foreach($order->items as $item)
                                                        <li>
                                                            <span class="font-medium">{{ $item->quantity }}x</span> 
                                                            {{ $item->product->name ?? 'Unknown Product' }} 
                                                            <span class="text-gray-500">(৳{{ number_format($item->price, 2) }} each)</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
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
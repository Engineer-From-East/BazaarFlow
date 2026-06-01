<x-app-layout>
    @if(Auth::user()->is_admin)
        
        <div class="flex min-h-screen bg-gray-100">
            <div class="w-64 bg-gray-900 text-white flex flex-col shadow-lg">
                <div class="p-6 text-xl font-bold border-b border-gray-800 tracking-wider">
                    Admin Panel
                </div>
                <nav class="flex-1 px-4 py-6 space-y-3">
                    <a href="{{ route('dashboard') }}" class="block px-4 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow-md">
                        📋 All Customer Orders
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="block px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition">
                        📦 Products
                    </a>
                    <a href="{{ route('admin.customers') }}" class="block px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition">
                        👥 Customer Accounts
                    </a>
                </nav>
            </div>

            <div class="flex-1 p-8">
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">Control Center</h1>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center space-x-4">
                        <div class="p-3 bg-blue-100 text-blue-600 rounded-full">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Pending Orders</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $pendingOrders ?? 0 }}</p>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center space-x-4">
                        <div class="p-3 bg-green-100 text-green-600 rounded-full">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Total Sales</p>
                            <p class="text-2xl font-bold text-gray-900">৳{{ number_format($totalSales ?? 0, 2) }}</p>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center space-x-4">
                        <div class="p-3 bg-indigo-100 text-indigo-600 rounded-full">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Total Products</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalProducts ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">All Customer Orders</h2>
                    
                    @if(isset($orders) && $orders->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-50 text-gray-600 text-sm uppercase tracking-wider border-b">
                                        <th class="p-4 font-semibold">Order ID</th>
                                        <th class="p-4 font-semibold">Date</th>
                                        <th class="p-4 font-semibold">Phone Number</th>
                                        <th class="p-4 font-semibold">Delivery Address</th>
                                        <th class="p-4 font-semibold">Total Amount</th>
                                        <th class="p-4 font-semibold">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($orders as $order)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="p-4 text-gray-900 font-medium">#{{ $order->id }}</td>
                                            <td class="p-4 text-gray-600">{{ $order->created_at->format('M d, Y') }}</td>
                                            <td class="p-4 text-gray-600">{{ $order->phone_number }}</td>
                                            <td class="p-4 text-gray-600 truncate max-w-xs">{{ $order->shipping_address }}</td>
                                            <td class="p-4 text-indigo-600 font-bold">৳{{ number_format($order->total_amount, 2) }}</td>
                                            <td class="p-4">
                                                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="flex items-center space-x-2">
                                                    @csrf
                                                    <select name="status" class="text-sm border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                    </select>
                                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1.5 rounded-md text-sm font-bold shadow-sm transition">
                                                        Update
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        <tr class="bg-gray-50/50">
                                            <td colspan="6" class="p-4 border-b border-gray-200">
                                                <div class="text-sm text-gray-500 mb-1 font-bold uppercase tracking-wide">Items in this order:</div>
                                                <ul class="list-disc list-inside text-gray-700 ml-2">
                                                    @foreach($order->items as $item)
                                                        <li>{{ $item->quantity }}x {{ $item->product->name }} (৳{{ number_format($item->price, 2) }} each)</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-8 text-center text-gray-500">
                            <p>No orders have been placed yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    @else

        <div class="py-12 bg-gray-50 min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl mb-6 border border-gray-100">
                    <div class="p-6 bg-white flex items-center space-x-5">
                        <div class="h-16 w-16 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold text-2xl shadow-inner">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Welcome back, {{ Auth::user()->name }}!</h2>
                            <p class="text-gray-500 mt-1">Manage your recent orders and account details below.</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <div class="md:col-span-1">
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6 h-full">
                            <h3 class="font-bold text-lg text-gray-900 mb-4 border-b pb-2">Account Profile</h3>
                            <div class="mb-4">
                                <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Full Name</p>
                                <p class="font-semibold text-gray-800 text-lg">{{ Auth::user()->name }}</p>
                            </div>
                            <div class="mb-8">
                                <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Email Address</p>
                                <p class="font-semibold text-gray-800">{{ Auth::user()->email }}</p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="block w-full text-center bg-gray-50 hover:bg-gray-100 border border-gray-200 text-gray-800 font-bold py-2 px-4 rounded-lg transition shadow-sm">
                                Edit Profile Details
                            </a>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            <h3 class="font-bold text-lg text-gray-900 mb-4 border-b pb-2">Your Order History</h3>
                            
                            @if(isset($orders) && $orders->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left border-collapse">
                                        <thead>
                                            <tr class="bg-gray-50 text-gray-600 text-sm uppercase tracking-wider border-b">
                                                <th class="p-4 font-semibold">Order ID</th>
                                                <th class="p-4 font-semibold">Date</th>
                                                <th class="p-4 font-semibold">Total Amount</th>
                                                <th class="p-4 font-semibold">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100">
                                            @foreach($orders as $order)
                                                <tr class="hover:bg-gray-50 transition">
                                                    <td class="p-4 text-gray-900 font-medium">#{{ $order->id }}</td>
                                                    <td class="p-4 text-gray-600">{{ $order->created_at->format('M d, Y') }}</td>
                                                    <td class="p-4 text-indigo-600 font-bold">৳{{ number_format($order->total_amount, 2) }}</td>
                                                    <td class="p-4">
                                                        <span class="px-3 py-1 rounded-full text-xs font-bold 
                                                            {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                                            {{ ucfirst($order->status) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr class="bg-gray-50/50">
                                                    <td colspan="4" class="p-4 border-b border-gray-200">
                                                        <div class="text-sm text-gray-500 mb-1 font-bold uppercase tracking-wide">Items:</div>
                                                        <ul class="list-disc list-inside text-gray-700 ml-2 text-sm">
                                                            @foreach($order->items as $item)
                                                                <li>{{ $item->quantity }}x {{ $item->product->name }} (৳{{ number_format($item->price, 2) }} each)</li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="py-8 text-center text-gray-500">
                                    <p>You haven't placed any orders yet.</p>
                                    <a href="{{ route('shop.index') }}" class="mt-4 inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-md shadow-sm transition">
                                        Start Shopping
                                    </a>
                                </div>
                            @endif
                            
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

    @endif
</x-app-layout>
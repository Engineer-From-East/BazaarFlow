<x-app-layout>
    <div class="flex min-h-screen bg-gray-100">
        
        <div class="w-64 bg-gray-900 text-white flex flex-col shadow-lg">
            <div class="p-6 text-xl font-bold border-b border-gray-800 tracking-wider">
                Admin Panel
            </div>
            <nav class="flex-1 px-4 py-6 space-y-3">
                <a href="{{ route('dashboard') }}" class="block px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition">
                    📋 All Customer Orders
                </a>
                <a href="{{ route('admin.products.index') }}" class="block px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition">
                    📦 Products
                </a>
                <a href="{{ route('admin.customers') }}" class="block px-4 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow-md">
                    👥 Customer Accounts
                </a>
            </nav>
        </div>

        <div class="flex-1 p-8">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Registered Customers</h1>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                @if($customers->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-gray-600 text-sm uppercase tracking-wider border-b">
                                    <th class="p-4 font-semibold">Name</th>
                                    <th class="p-4 font-semibold">Email Address</th>
                                    <th class="p-4 font-semibold">Joined Date</th>
                                    <th class="p-4 font-semibold text-right">Account Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($customers as $customer)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="p-4 text-gray-900 font-bold">{{ $customer->name }}</td>
                                        <td class="p-4 text-gray-600">{{ $customer->email }}</td>
                                        <td class="p-4 text-gray-600">{{ $customer->created_at->format('M d, Y') }}</td>
                                        <td class="p-4 text-right">
                                            <button onclick="alert('Ban Customer feature coming soon!')" class="bg-red-100 text-red-600 hover:bg-red-600 hover:text-white px-4 py-2 rounded-md font-bold text-sm transition">
                                                Ban User
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-8 text-center text-gray-500">
                        <p>No customers have registered yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
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
                
                <a href="{{ route('admin.products.index') }}" class="block px-4 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow-md">
                    📦 Products
                </a>
                
                <a href="{{ route('admin.customers') }}" class="block px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition">
                    👥 Customer Accounts
                </a>
            </nav>
        </div>

        <div class="flex-1 p-8">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Manage Inventory</h1>
                <a href="{{ route('admin.products.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md font-bold transition shadow-sm">
                    + Add New Product
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                @if($products->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-gray-600 text-sm uppercase tracking-wider border-b">
                                    <th class="p-4 font-semibold">Image</th>
                                    <th class="p-4 font-semibold">Product Name</th>
                                    <th class="p-4 font-semibold">Stock</th>
                                    <th class="p-4 font-semibold">Price</th>
                                    <th class="p-4 font-semibold text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($products as $product)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="p-4">
                                            @if($product->image)
                                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="h-12 w-12 object-cover rounded shadow-sm">
                                            @else
                                                <div class="h-12 w-12 bg-gray-200 rounded flex items-center justify-center text-xs text-gray-500">No Img</div>
                                            @endif
                                        </td>
                                        <td class="p-4 text-gray-900 font-bold">{{ $product->name }}</td>
                                        <td class="p-4 text-gray-600">{{ $product->stock }}</td>
                                        <td class="p-4 text-indigo-600 font-bold">৳{{ number_format($product->price, 2) }}</td>
                                        <td class="p-4 text-right">
                                            
                                            <div class="flex justify-end space-x-2">
                                                <a href="{{ route('admin.products.edit', $product->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm font-bold shadow-sm transition">
                                                    Edit
                                                </a>
                                                
                                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Delete this product permanently?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm font-bold shadow-sm transition">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-8 text-center text-gray-500">
                        <p>No products exist in the inventory yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Inventory') }}
            </h2>
            <a href="{{ route('admin.products.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow">
                + Add New Perfume
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($products->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border-b py-3 px-4">Image</th>
                                    <th class="border-b py-3 px-4">Product Name</th>
                                    <th class="border-b py-3 px-4">Price</th>
                                    <th class="border-b py-3 px-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                    <tr class="hover:bg-gray-50 border-b">
                                        <td class="py-3 px-4">
                                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded shadow-sm bg-gray-200">
                                        </td>
                                        <td class="py-3 px-4 font-bold text-gray-800">{{ $product->name }}</td>
                                        <td class="py-3 px-4 text-indigo-600 font-bold">৳{{ number_format($product->price, 2) }}</td>
                                        <td class="py-3 px-4 text-right">
                                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this perfume?');" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="background-color: #ef4444; color: white; padding: 6px 12px; border-radius: 6px; font-weight: bold; font-size: 12px;" onmouseover="this.style.backgroundColor='#dc2626'" onmouseout="this.style.backgroundColor='#ef4444'">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 py-4 text-center">No products found. Click the button above to add your first perfume!</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
</button>
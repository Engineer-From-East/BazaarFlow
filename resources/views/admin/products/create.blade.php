<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-bold mb-2">Product Name</label>
                        <input type="text" name="name" id="name" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required placeholder="e.g., Creed Aventus">
                    </div>

                    <div class="mb-4">
                        <label for="category_id" class="block text-gray-700 font-bold mb-2">Product Category</label>
                        <select name="category_id" id="category_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="" disabled selected>Select a category...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="price" class="block text-gray-700 font-bold mb-2">Price (৳)</label>
                            <input type="number" name="price" id="price" step="0.01" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required placeholder="e.g., 2500">
                        </div>
                        
                        <div>
                            <label for="stock" class="block text-gray-700 font-bold mb-2">Initial Stock</label>
                            <input type="number" name="stock" id="stock" min="0" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required placeholder="e.g., 50">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 font-bold mb-2">Description</label>
                        <textarea name="description" id="description" rows="4" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required placeholder="Describe the item..."></textarea>
                    </div>

                    <div class="mb-6">
                        <label for="image" class="block text-gray-700 font-bold mb-2">Product Image (JPEG, PNG, WEBP)</label>
                        <input type="file" name="image" id="image" accept="image/*" class="w-full border border-gray-300 p-2 rounded-md" required>
                    </div>

                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('admin.products.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded transition">Cancel</a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded shadow-md transition">Save Product</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
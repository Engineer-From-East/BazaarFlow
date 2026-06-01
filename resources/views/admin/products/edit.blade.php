<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="mt-5 md:mt-0 md:col-span-2">
            <div class="px-4 py-5 bg-white sm:p-6 shadow-sm border border-gray-100 sm:rounded-xl">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b pb-2">Edit Product: {{ $product->name }}</h2>

                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Category</label>
                        <select name="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Product Name</label>
                        <input type="text" name="name" value="{{ $product->name }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Description</label>
                        <textarea name="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>{{ $product->description }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Price (৳)</label>
                            <input type="number" step="0.01" name="price" value="{{ $product->price }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Stock Quantity</label>
                            <input type="number" name="stock" value="{{ $product->stock }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                    </div>

                    <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-100">
                        <label class="block font-medium text-sm text-gray-700 mb-2">Product Image</label>
                        
                        @if($product->image)
                            <div class="mb-4 flex items-start space-x-4">
                                <img src="{{ asset($product->image) }}" alt="Current Image" class="h-24 w-24 object-cover rounded-md shadow-sm border border-gray-300">
                                <div class="text-sm text-gray-500 pt-2">
                                    <p class="font-bold">Current Image</p>
                                    <p>Uploading a new file below will permanently replace this image.</p>
                                </div>
                            </div>
                        @endif
                        
                        <input type="file" name="image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-100 file:text-indigo-700 hover:file:bg-indigo-200">
                    </div>

                    <div class="flex items-center justify-end mt-4 border-t pt-4">
                        <a href="{{ route('admin.products.index') }}" class="text-gray-500 hover:text-gray-900 mr-4 font-bold transition">Cancel</a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-md shadow-sm transition">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
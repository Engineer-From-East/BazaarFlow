<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('BazaarFlow Market') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row gap-6">
            
            <div class="w-full md:w-1/4 bg-white shadow-sm sm:rounded-lg p-6 h-fit">
                <h3 class="font-bold text-lg text-gray-900 mb-4 border-b pb-2">Categories</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('shop.index') }}" 
                           class="block text-gray-700 hover:text-indigo-600 font-medium {{ !request()->has('category') ? 'text-indigo-600 font-bold' : '' }}">
                            All Products
                        </a>
                    </li>
                    @foreach($categories as $category)
                        <li>
                            <a href="{{ route('shop.index', ['category' => $category->slug]) }}" 
                               class="block text-gray-700 hover:text-indigo-600 transition {{ request('category') == $category->slug ? 'text-indigo-600 font-bold' : '' }}">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="w-full md:w-3/4">
                
                <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 mb-6">
                    <form action="{{ route('shop.index') }}" method="GET" class="flex gap-2">
                        @if(request()->has('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search for fresh vegetables, fruits, etc..." class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md font-bold transition">Search</button>
                        
                        @if(request()->has('search'))
                            <a href="{{ route('shop.index', ['category' => request('category')]) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md font-bold transition">Clear</a>
                        @endif
                    </form>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                @if($products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($products as $product)
                            <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100 flex flex-col">
                                <div class="h-48 bg-gray-200 overflow-hidden">
                                    @if($product->image)
                                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-500">No Image</div>
                                    @endif
                                </div>
                                
                                <div class="p-4 flex-1 flex flex-col">
                                    <h4 class="font-bold text-lg text-gray-900">{{ $product->name }}</h4>
                                    
                                    @if($product->category)
                                        <span class="text-xs text-gray-500 mb-2 block">{{ $product->category->name }}</span>
                                    @endif

                                    <p class="text-indigo-600 font-bold text-xl mt-auto mb-2">৳{{ number_format($product->price, 2) }}</p>
                                    
                                    @if($product->stock > 0)
                                        <p class="text-sm text-green-600 mb-4">{{ $product->stock }} in stock</p>
                                    @else
                                        <p class="text-sm text-red-600 mb-4">Out of Stock</p>
                                    @endif

                                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-auto">
                                        @csrf
                                        <button type="submit" 
                                            @if($product->stock <= 0) disabled @endif
                                            class="w-full text-center py-2 px-4 rounded font-bold transition 
                                            {{ $product->stock > 0 ? 'bg-indigo-600 hover:bg-indigo-700 text-white shadow-md' : 'bg-gray-300 text-gray-500 cursor-not-allowed' }}">
                                            {{ $product->stock > 0 ? 'Add to Cart' : 'Sold Out' }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white rounded-lg shadow-sm p-12 text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p class="text-lg">No products found matching your search.</p>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Local Bazaar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                @foreach ($products as $product)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-500 mb-2">Category: {{ $product->category->name }}</p>
                        <p class="text-gray-700 mb-4">{{ $product->description }}</p>
                        
                        <div class="flex justify-between items-center mt-4 border-t pt-4">
                            <span class="text-xl font-extrabold text-indigo-600">৳{{ number_format($product->price, 2) }}</span>
                            
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</x-app-layout>
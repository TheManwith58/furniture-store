@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Filters -->
        <div class="md:w-1/4">
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="font-semibold text-lg mb-4">{{ __('Categories') }}</h3>
                <ul>
                    @foreach($categories as $category)
                    <li class="mb-2">
                        <a href="{{ route('products.index', ['category' => $category->id]) }}"
                           class="{{ request('category') == $category->id ? 'text-indigo-600 font-medium' : 'text-gray-600' }} hover:text-indigo-600">
                            {{ $category->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        
        <!-- Products -->
        <div class="md:w-3/4">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">{{ __('All Products') }}</h1>
                <div>
                    <form method="GET" action="{{ route('products.index') }}">
                        <select name="sort" onchange="this.form.submit()" class="border rounded-md px-4 py-2">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>{{ __('Newest First') }}</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>{{ __('Price: Low to High') }}</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>{{ __('Price: High to Low') }}</option>
                        </select>
                    </form>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($products as $product)
                <div class="bg-white rounded-xl shadow-md overflow-hidden group">
                    <div class="relative">
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                        <div class="absolute top-4 right-4">
                            <button class="bg-white rounded-full p-2 shadow-md hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-lg text-gray-800 group-hover:text-indigo-600">
                            <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                        </h3>
                        <div class="flex items-center mt-1">
                            <div class="flex text-yellow-400">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($product->averageRating()))
                                        <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 fill-current text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-gray-600 text-sm ml-2">({{ $product->reviews->count() }})</span>
                        </div>
                        <div class="mt-2">
                            <span class="text-lg font-semibold text-indigo-600">{{ format_currency($product->price) }}</span>
                        </div>
                        <div class="mt-4">
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-gray-800 text-white py-2 rounded hover:bg-gray-700">
                                    {{ __('Add to Cart') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
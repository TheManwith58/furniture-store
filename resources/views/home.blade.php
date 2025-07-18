@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <!-- Hero Section -->
    <div class="bg-gray-100 rounded-xl p-8 mb-12 text-center">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">{{ __('Welcome to Nilkamal Furniture') }}</h1>
        <p class="text-xl text-gray-600 mb-6">{{ __('Discover our collection of high-quality furniture') }}</p>
        <a href="{{ route('products.index') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-indigo-700">{{ __('Shop Now') }}</a>
    </div>

    <!-- Featured Categories -->
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ __('Featured Categories') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($categories as $category)
            <a href="{{ route('products.index', ['category' => $category->id]) }}" class="bg-white rounded-xl shadow-md overflow-hidden group">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 group-hover:text-indigo-600">{{ $category->name }}</h3>
                    <p class="text-gray-600">{{ __(':count products', ['count' => $category->products->count()]) }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    <!-- Featured Products -->
    <div class="mb-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">{{ __('Featured Products') }}</h2>
            <a href="{{ route('products.index') }}" class="text-indigo-600 hover:text-indigo-800">{{ __('View All') }}</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
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
    </div>
</div>
@endsection
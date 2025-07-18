@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Product Image -->
            <div class="md:w-1/2">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <img src="{{ asset('storage/' . $product->image_path) }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-auto rounded-lg object-cover">
                </div>
            </div>
            
            <!-- Product Details -->
            <div class="md:w-1/2">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $product->name }}</h1>
                    
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($product->averageRating()))
                                    <svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 fill-current text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <span class="ml-2 text-gray-600">({{ $product->reviews->count() }} {{ __('reviews') }})</span>
                    </div>
                    
                    <p class="text-2xl font-bold text-indigo-600 mb-4">{{ $product->formattedPrice() }}</p>
                    
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">{{ __('Description') }}</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                    </div>
                    
                    <div class="mb-6">
                        <div class="flex items-center mb-2">
                            <span class="text-gray-700 font-medium mr-4">{{ __('Availability') }}:</span>
                            @if($product->stock_quantity > 0)
                                <span class="text-green-600 font-semibold">{{ __('In Stock') }}</span>
                            @else
                                <span class="text-red-600 font-semibold">{{ __('Out of Stock') }}</span>
                            @endif
                        </div>
                        <div class="flex items-center">
                            <span class="text-gray-700 font-medium mr-4">{{ __('Category') }}:</span>
                            <span class="text-gray-600">{{ $product->category->name }}</span>
                        </div>
                    </div>
                    
                    @if($product->stock_quantity > 0)
                    <form action="{{ route('cart.add', $product) }}" method="POST">
                        @csrf
                        <div class="flex items-center mb-6">
                            <span class="text-gray-700 font-medium mr-4">{{ __('Quantity') }}:</span>
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}"
                                   class="w-20 px-3 py-2 border border-gray-300 rounded-md">
                        </div>
                        
                        <div class="flex flex-wrap gap-3">
                            <button type="submit" 
                                    class="px-6 py-3 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 transition">
                                {{ __('Add to Cart') }}
                            </button>
                            
                            <button type="button" 
                                    class="px-6 py-3 bg-gray-200 text-gray-800 font-medium rounded-md hover:bg-gray-300 transition">
                                {{ __('Add to Wishlist') }}
                            </button>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Reviews Section -->
        <div class="mt-12 bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ __('Customer Reviews') }}</h2>
            
            @auth
            <div class="mb-8">
                <h3 class="text-lg font-semibold mb-3">{{ __('Write a Review') }}</h3>
                <form action="{{ route('reviews.store', $product) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">{{ __('Rating') }}</label>
                        <div class="flex">
                            @for($i = 1; $i <= 5; $i++)
                                <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" 
                                       class="hidden" {{ $i == 5 ? 'checked' : '' }}>
                                <label for="star{{ $i }}" class="text-2xl cursor-pointer text-gray-300">
                                    <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                    </svg>
                                </label>
                            @endfor
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <textarea name="comment" rows="4" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                  placeholder="{{ __('Share your experience with this product') }}"></textarea>
                    </div>
                    
                    <button type="submit" 
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        {{ __('Submit Review') }}
                    </button>
                </form>
            </div>
            @endauth
            
            <div class="space-y-6">
                @forelse($product->reviews as $review)
                <div class="border-b border-gray-200 pb-6">
                    <div class="flex items-center mb-2">
                        <div class="flex text-yellow-400 mr-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 fill-current text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <span class="text-gray-600">{{ $review->created_at->format('M d, Y') }}</span>
                    </div>
                    
                    <h4 class="text-lg font-semibold">{{ $review->user->name }}</h4>
                    <p class="text-gray-600 mt-2">{{ $review->comment }}</p>
                </div>
                @empty
                <p class="text-gray-600">{{ __('No reviews yet. Be the first to review!') }}</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
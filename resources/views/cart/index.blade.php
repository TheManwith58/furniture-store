@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">{{ __('Your Shopping Cart') }}</h1>
    
    @if(count($cart) > 0)
    <div class="flex flex-col md:flex-row gap-8">
        <div class="md:w-2/3">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="py-3 px-4 text-left">{{ __('Product') }}</th>
                            <th class="py-3 px-4 text-left">{{ __('Price') }}</th>
                            <th class="py-3 px-4 text-left">{{ __('Quantity') }}</th>
                            <th class="py-3 px-4 text-left">{{ __('Total') }}</th>
                            <th class="py-3 px-4 text-left">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart as $item)
                        <tr class="border-b border-gray-200">
                            <td class="py-4 px-4">
                                <div class="flex items-center">
                                    <img src="{{ asset('storage/' . $item['image']) }}" 
                                         alt="{{ $item['name'] }}" 
                                         class="w-16 h-16 object-cover rounded-md mr-4">
                                    <div>
                                        <h3 class="font-medium text-gray-800">{{ $item['name'] }}</h3>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4">{{ format_currency($item['price']) }}</td>
                            <td class="py-4 px-4">
                                <form action="{{ route('cart.update', $item['id']) }}" method="POST">
                                    @csrf
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" 
                                           max="{{ $item['max_quantity'] }}" 
                                           class="w-20 px-2 py-1 border border-gray-300 rounded-md">
                                </form>
                            </td>
                            <td class="py-4 px-4 font-medium">{{ format_currency($item['price'] * $item['quantity']) }}</td>
                            <td class="py-4 px-4">
                                <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-6 flex justify-between">
                <a href="{{ route('home') }}" 
                   class="px-5 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">
                    {{ __('Continue Shopping') }}
                </a>
            </div>
        </div>
        
        <div class="md:w-1/3">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">{{ __('Order Summary') }}</h2>
                
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between">
                        <span class="text-gray-600">{{ __('Subtotal') }}</span>
                        <span class="font-medium">{{ format_currency($total) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">{{ __('Tax') }} (12%)</span>
                        <span class="font-medium">{{ format_currency($tax) }}</span>
                    </div>
                    <div class="flex justify-between pt-3 border-t border-gray-200">
                        <span class="text-lg font-bold text-gray-800">{{ __('Grand Total') }}</span>
                        <span class="text-lg font-bold text-indigo-600">{{ format_currency($grandTotal) }}</span>
                    </div>
                </div>
                
                <a href="{{ route('checkout.index') }}" 
                   class="block w-full px-4 py-3 bg-indigo-600 text-white text-center font-medium rounded-md hover:bg-indigo-700 transition">
                    {{ __('Proceed to Checkout') }}
                </a>
            </div>
            
            <div class="mt-6 bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">{{ __('Apply Coupon') }}</h3>
                <div class="flex">
                    <input type="text" placeholder="{{ __('Enter coupon code') }}" 
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none">
                    <button class="px-4 py-2 bg-gray-800 text-white rounded-r-md hover:bg-gray-700">
                        {{ __('Apply') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="bg-white rounded-xl shadow-lg p-8 text-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        <h3 class="text-2xl font-bold text-gray-700 mt-4 mb-2">{{ __('Your cart is empty') }}</h3>
        <p class="text-gray-600 mb-6">{{ __('Looks like you haven't added anything to your cart yet') }}</p>
        <a href="{{ route('home') }}" 
           class="px-6 py-3 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 transition">
            {{ __('Continue Shopping') }}
        </a>
    </div>
    @endif
</div>
@endsection
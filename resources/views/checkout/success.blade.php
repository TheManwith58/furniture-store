@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg p-8 text-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-500 mx-auto mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ __('Thank You For Your Order!') }}</h1>
        <p class="text-gray-600 mb-6">
            {{ __('Your order has been placed successfully. Order number is') }} 
            <span class="font-semibold">#{{ $order->id }}</span>.
        </p>
        <div class="mb-8">
            <p class="text-gray-600">{{ __('An email confirmation has been sent to') }} 
                <span class="font-semibold">{{ json_decode($order->contact_info)->email }}</span>.
            </p>
        </div>
        <div class="flex justify-center gap-4">
            <a href="{{ route('home') }}" 
               class="bg-indigo-600 text-white px-6 py-3 rounded-md font-medium hover:bg-indigo-700">
                {{ __('Continue Shopping') }}
            </a>
            <a href="{{ route('orders.show', $order) }}" 
               class="bg-white border border-gray-300 text-gray-800 px-6 py-3 rounded-md font-medium hover:bg-gray-50">
                {{ __('View Order Details') }}
            </a>
        </div>
    </div>
</div>
@endsection
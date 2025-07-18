@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">{{ __('Order Details') }} #{{ $order->id }}</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.orders.invoice', $order) }}" 
               class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                {{ __('Download Invoice') }}
            </a>
            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                @csrf
                <div class="flex">
                    <select name="status" onchange="this.form.submit()" 
                            class="border rounded-l-md px-4 py-2 focus:outline-none">
                        @foreach(['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                        <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-lg font-semibold mb-3">{{ __('Customer Information') }}</h2>
                <div class="space-y-2">
                    @php $contact = json_decode($order->contact_info) @endphp
                    <p><strong>{{ __('Name') }}:</strong> {{ $contact->name }}</p>
                    <p><strong>{{ __('Email') }}:</strong> {{ $contact->email }}</p>
                    <p><strong>{{ __('Phone') }}:</strong> {{ $contact->phone }}</p>
                    <p><strong>{{ __('Address') }}:</strong> {{ $order->shipping_address }}</p>
                </div>
            </div>
            <div>
                <h2 class="text-lg font-semibold mb-3">{{ __('Order Information') }}</h2>
                <div class="space-y-2">
                    <p><strong>{{ __('Order Date') }}:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</p>
                    <p><strong>{{ __('Order Status') }}:</strong> 
                        <span class="px-2 py-1 text-xs font-semibold rounded 
                            {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : 
                               ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                               ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800')) }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>
                    <p><strong>{{ __('Payment Method') }}:</strong> {{ ucfirst($order->payment_method) }}</p>
                    <p><strong>{{ __('Order Total') }}:</strong> {{ $order->formatted_total }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-lg font-semibold mb-4">{{ __('Order Items') }}</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Product') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Price') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Quantity') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Total') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($order->items as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-md object-cover" 
                                         src="{{ asset('storage/' . $item->product->image_path) }}" 
                                         alt="{{ $item->product->name }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $item->product->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $item->formatted_price }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $item->quantity }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            {{ $item->formatted_total }}
                        </td>
                    </tr>
                    @endforeach
                    <tr class="border-t">
                        <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-gray-900">
                            {{ __('Subtotal') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            {{ format_currency($order->total / 1.12) }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-gray-900">
                            {{ __('Tax') }} (12%)
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            {{ format_currency($order->total - ($order->total / 1.12)) }}
                        </td>
                    </tr>
                    <tr class="bg-gray-50">
                        <td colspan="3" class="px-6 py-4 text-right text-sm font-bold text-gray-900">
                            {{ __('Grand Total') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold">
                            {{ $order->formatted_total }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
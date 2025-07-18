<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Razorpay\Api\Api;

class CheckoutController extends Controller
{
    public function index(): View
    {
        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('home');
        }
        
        $total = 0;
        $taxRate = 0.12;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        $tax = $total * $taxRate;
        $grandTotal = $total + $tax;
        
        return view('checkout.index', compact('cart', 'grandTotal'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postcode' => 'required|string|max:20',
            'payment_method' => 'required|in:cod,razorpay',
        ]);
        
        $cart = Session::get('cart', []);
        $total = 0;
        $taxRate = 0.12;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        $tax = $total * $taxRate;
        $grandTotal = $total + $tax;
        
        // Create order
        $order = Order::create([
            'user_id' => Auth::id(),
            'total' => $grandTotal,
            'status' => 'pending',
            'payment_method' => $validated['payment_method'],
            'shipping_address' => implode(', ', [
                $validated['address'],
                $validated['city'],
                $validated['state'],
                $validated['postcode']
            ]),
            'contact_info' => json_encode([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
            ])
        ]);
        
        // Create order items
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }
        
        // Process payment
        if ($validated['payment_method'] === 'razorpay') {
            return $this->processRazorpayPayment($order);
        }
        
        // Clear cart
        Session::forget('cart');
        
        return redirect()->route('checkout.success', $order)
            ->with('success', __('Order placed successfully!'));
    }
    
    protected function processRazorpayPayment(Order $order): RedirectResponse
    {
        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
        
        $payment = $api->paymentLink->create([
            'amount' => $order->total * 100,
            'currency' => 'INR',
            'description' => 'Order #' . $order->id,
            'customer' => [
                'name' => json_decode($order->contact_info)->name,
                'email' => json_decode($order->contact_info)->email,
                'contact' => json_decode($order->contact_info)->phone,
            ],
            'notify' => ['sms' => true, 'email' => true],
            'callback_url' => route('checkout.success', $order),
            'callback_method' => 'get'
        ]);
        
        return redirect($payment['short_url']);
    }
    
    public function success(Order $order): View
    {
        return view('checkout.success', compact('order'));
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class CheckoutController extends Controller
{
    public function checkout()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Log in om af te rekenen.');
        }

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Je winkelwagen is leeg.');
        }

        // Bereid line items voor Stripe
        $lineItems = [];
        foreach ($cart as $id => $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $item['name'],
                        'images' => $item['image'] ? [asset('storage/' . $item['image'])] : [],
                    ],
                    'unit_amount' => (int)($item['price'] * 100), // Stripe gebruikt centen
                ],
                'quantity' => $item['quantity'],
            ];
        }

        // Zet Stripe API key (TEST MODE)
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            // Maak Stripe Checkout Session
            $checkoutSession = Session::create([
                'payment_method_types' => ['card', 'ideal'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('cart'),
                'customer_email' => auth()->user()->email,
            ]);

            return redirect($checkoutSession->url);
        } catch (\Exception $e) {
            return redirect()->route('cart')->with('error', 'Er is iets misgegaan: ' . $e->getMessage());
        }
    }

    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');

        if (!$sessionId) {
            return redirect()->route('home');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $session = Session::retrieve($sessionId);

            if ($session->payment_status === 'paid') {
                // Haal cart op
                $cart = session()->get('cart', []);
                
                if (!empty($cart)) {
                    // Bereken totaal
                    $total = 0;
                    foreach ($cart as $item) {
                        $total += $item['price'] * $item['quantity'];
                    }

                    // Maak order aan
                    $order = Order::create([
                        'user_id' => auth()->id(),
                        'total_price' => $total,
                        'status' => 'paid',
                    ]);

                    // Maak order items aan
                    foreach ($cart as $productId => $item) {
                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $productId,
                            'quantity' => $item['quantity'],
                            'price' => $item['price'],
                        ]);
                    }

                    // Leeg de winkelwagen
                    session()->forget('cart');
                }

                return view('checkout.success');
            }
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Er is iets misgegaan bij het verwerken van je betaling.');
        }

        return redirect()->route('home');
    }
}
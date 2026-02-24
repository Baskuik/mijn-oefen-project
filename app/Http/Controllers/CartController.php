<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return view('cart.index', compact('cart', 'total'));
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Item verwijderd!');
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);
        if(empty($cart)) return redirect()->route('home');

        // WE ZETTEN DE SLEUTEL HIER DIRECT NEER (Harde fix)
        $stripeSecret = env('STRIPE_SECRET');

        Stripe::setApiKey($stripeSecret);

        $line_items = [];
        foreach($cart as $id => $details) {
            $line_items[] = [
                'price_data' => [
                    'currency'     => 'eur',
                    'product_data' => [
                        'name' => $details['name'],
                    ],
                    'unit_amount'  => $details['price'] * 100, 
                ],
                'quantity' => $details['quantity'],
            ];
        }

        $session = Session::create([
            'payment_method_types' => ['card', 'ideal'],
            'line_items'           => $line_items,
            'mode'                 => 'payment',
            'success_url'          => route('cart.success'),
            'cancel_url'           => route('cart.index'),
        ]);

        return redirect()->away($session->url);
    }

    public function success()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        $itemNames = [];

        foreach($cart as $details) {
            $total += $details['price'] * $details['quantity'];
            $itemNames[] = $details['quantity'] . 'x ' . $details['name'];
        }

        if(!empty($cart)) {
            Order::create([
                'user_id'     => Auth::id() ?? 1,
                'total_price' => $total,
                'items'       => implode(', ', $itemNames),
                'status'      => 'paid' 
            ]);
        }

        session()->forget('cart');

        return view('cart.success');
    }
}
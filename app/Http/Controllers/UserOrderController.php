<?php

namespace App\Http\Controllers;

use App\Models\Order;

class UserOrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('items.product') // load product for names/images
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }
}
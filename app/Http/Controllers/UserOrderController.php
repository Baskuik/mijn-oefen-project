<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class UserOrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('items.product')   // ← was 'items', nu ook product geladen voor de foto
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }
}
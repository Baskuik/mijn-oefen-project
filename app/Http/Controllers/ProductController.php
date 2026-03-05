<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    // Voor de homepage (klanten)
    public function index()
    {
        $categories = Cache::remember('home_categories', 300, function () {
            return Category::with(['products' => function ($query) {
                $query->where('is_featured', true);
            }])->get();
        });

        $products = $categories->flatMap->products;

        return view('welcome', compact('products', 'categories'));
    }

    // Voor het admin dashboard (jouw beheerpagina)
    public function adminIndex()
    {
        $products   = Product::all();
        $categories = Category::all();
        $users      = User::all();

        return view('admin.index', compact('products', 'categories', 'users'));
    }
}
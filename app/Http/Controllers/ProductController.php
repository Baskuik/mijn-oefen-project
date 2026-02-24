<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User; // Voeg deze toe om gebruikers te kunnen ophalen
use App\Models\Category; // Waarschijnlijk heb je deze ook nodig voor je admin
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Voor de homepage (klanten)
    public function index()
    {
        $products = Product::all();
        return view('welcome', compact('products'));
    }

    // Voor het admin dashboard (jouw beheerpagina)
    public function adminIndex()
    {
        $products = Product::all();
        $categories = Category::all();
        $users = User::all(); // Hier halen we de gebruikers op!

        // We sturen alles naar je bestaande admin view
        return view('admin.index', compact('products', 'categories', 'users'));
    }
}
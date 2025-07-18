<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $featuredProducts = Product::where('featured', true)->take(8)->get();
        $categories = Category::with('products')->take(4)->get();

        return view('home', compact('featuredProducts', 'categories'));
    }
}
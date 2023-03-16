<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShoppingCartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        Log::info("ShoppingCart-Header number of categories: ".count($categories));
        return view('shoppingCart.shoppingCart', ['categories' => $categories]);
    }
}

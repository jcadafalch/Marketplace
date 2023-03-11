<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Pagination\Paginator;

class HomeController extends Controller
{
    public function index()
    {
        Paginator::useBootstrap();
        return view('home.index' , ['products' => Product::with('categories')->paginate(5)]);
    }

     public function show($id)
    {
        return view('home.singleProduct', ['product' => Product::findOrFail($id)]);
    }
}

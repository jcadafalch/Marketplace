<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index' , ['products' => Product::with('categories')->get()], ['categories' => Category::all()]);
    }

     public function show($id)
    {
        return view('home.singleProduct', ['product' => Product::findOrFail($id)], ['categories' => Category::all()]);
    }

    public function searchProduct(Request $request){
        
        $category = $request['category'];
        $fieldSearch = $request['search'];
        dd( $category . ' ' . $fieldSearch );



        return view('home.index', ['products' => Product::all()], ['categories' => Category::all()]);
    }
}

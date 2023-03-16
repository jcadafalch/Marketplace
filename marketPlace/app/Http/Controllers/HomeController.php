<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Pagination\Paginator;


class HomeController extends Controller
{
    public function index()
    {
        Paginator::defaultSimpleView('default');
        return view('home.index' , ['products' => Product::with('categories')->paginate(10)],['categories' => Category::all()]);
    }

     public function show($id)
    {
        return view('home.singleProduct', ['product' => Product::findOrFail($id)], ['categories' => Category::all()]);
    }

    public function searchProduct(Request $request){
        Paginator::defaultSimpleView('default');
        $request->session()->forget('status');
        if( $request['category'] == 'allCategories'){
            $productsFilter = Product::searchByName($request);
        }else{
            $productsFilter = Product::searchByAll($request);
        }
        if($productsFilter->count() == 0){
            $request->session()->flash('status','404 Not found!'); 
        }
        return view('home.index', ['products' => $productsFilter], ['categories' => Category::all()]);
    }
}

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
        Paginator::defaultView('default');

        return view('home.index' , ['products' => Product::with('categories')->paginate(env('PAGINATE', 10))],['categories' => Category::all()]);
    }

     public function show($id)
    {
        return view('home.singleProduct', ['product' => Product::findOrFail($id)], ['categories' => Category::all()]);
    }

    public function searchProduct(Request $request){
        // Paginator::defaultSimpleView('default');
        $fieldSearch = $request['search'];
        $category = $request['category'];
        $order = $request['order'];
        
        $request->session()->forget('status');
        if( $request['category'] == 'allCategories'){
            $productsFilter = Product::searchByName($request);
        }else{
            $productsFilter = Product::searchByAll($request);
        }
        if($productsFilter->count() == 0){
            $request->session()->flash('status','404 Not found!'); 
        }
        return view('home.index', ['products' => $productsFilter->appends(['category' => $category,'search' => $fieldSearch, 'order' => $order])], ['categories' => Category::all()]);
    }
}

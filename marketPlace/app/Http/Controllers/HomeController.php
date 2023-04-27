<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;


class HomeController extends Controller
{
    public function index()
    {
        Paginator::defaultView('default');

        return view('home.index' , ['products' => Product::with('categories')->paginate(env('PAGINATE', 10))],['categories' => Category::all()->where('parent_id', '=', null)]);
    }

     public function show($id)
    {   

        return view('home.singleProduct', ['product' => Product::findOrFail($id), 'shop' => Shop::getShopNameByProductId($id)], ['categories' => Category::all()->where('parent_id', '=', null)]);
    }

    public function searchProduct(Request $request){
        // Paginator::defaultSimpleView('default');
        $fieldSearch = $request['search'];
        $category = $request['category'];
        $order = $request['order'];
       
        // Guardem la categoria y la cerca a sessió  
        session()->put('category', $category);
        session()->put('search', $fieldSearch);

        if( $request['category'] == 'allCategories'){
            $productsFilter = Product::searchByName($request);
        }else{
            $productsFilter = Product::searchByAll($request);
        }
        if($productsFilter->count() == 0){
           return redirect()->route('error.productNotFoundError');
        }
        return view('home.index', ['products' => $productsFilter->appends(['category' => $category,'search' => $fieldSearch, 'order' => $order])], ['categories' => Category::all()->where('parent_id', '=', null)]);
    }
}

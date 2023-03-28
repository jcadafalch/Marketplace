<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\ShopCreate;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function createNewShop(){
        return view('shop.createNewShop',['categories' => Category::all()]);
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function registerShop(ShopCreate $request)
    {
        //dd($request);
            // Primera forma de crear un objecte
        $validated = $request->validated();

        dd($validated);
        $shop = new Shop();
        $shop->name =  $request['name'];;
        $shop->shop_name =  $request['shopName'];
        $shop->nif =  $request['nif'];
        $shop->product_id = 1;
        $shop->user_id = 1;
        $shop->save();  

        session()->flash( 'status','Tienda creada correctamente!!');
        return redirect()->route('home.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

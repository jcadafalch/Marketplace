<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\ShopCreate;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    /**
     * Funció que et retorna la vista de crear nova shop. 
     */
    public function createNewShop(){
        return view('shop.createNewShop',['categories' => Category::all()]);
    }
    
    /**
     * Funció per crear una nova shop. 
     */
    public function registerShop(ShopCreate $request)
    {
        //dd($request);
        $validated = $request->validated();
        
        
        //Obtenir l'id de l'usuari que està connectat
        $userId = Auth::id();


        dd($userId);
        $shop = new Shop();
        $shop->name = $request['name'];;
        $shop->shop_name = $request['shopName'];
        $shop->nif = $request['nif'];
        $shop->product_id = 1;
        $shop->user_id = $userId;  
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

<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Image;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\ShopCreate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ShopController extends Controller
{
    /**
     * Funció que et retorna la vista de crear nova shop. 
     */
    public function createNewShop(){
        return view('shop.createNewShop',['categories' => Category::all()->where('parent_id', '=', null)]);
    }
    
    /**
     * Funció per crear una nova shop. 
     */
    public function registerShop(ShopCreate $request)
    {
        // Validacions
        $validated = $request->validated();
        
        //Obtenir l'id de l'usuari que està connectat
        $userId = Auth::id();
    
        $extension = $request->file('profilePhoto')->getClientOriginalExtension();
        $img = 'profileImg' . Auth::user()->id . '.' .  $extension;
        $request->file('profilePhoto')->storeAs('public/img/shopProfile', $img);

        $image = new Image();
        $image->name = $request['shopName'];
        $image->url = $img;
        $image->save();

        $shop = new Shop();
        $shop->ownerName = $request['name'];;
        $shop->name = $request['shopName'];
        $shop->nif = $request['nif'];
        $shop->user_id = $userId; 
        $shop->logo_id = $image->id;
        $shop->save();  

        return redirect()->route('shop.show');
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

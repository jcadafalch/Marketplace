<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\User;
use App\Models\Image;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\ShopCreate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Http\FormRequest;

class ShopController extends Controller
{
    public function index(){
        $userId = Auth::id();
        
        if($userId != null){
            $shop = Shop::where('user_id', $userId)->first();
            $productsShop = $shop->getShopProducts();
        }else{
            return redirect()->route('error.shopNotFound');
        }
        return view('shop.index',['products' => Product::with('categories')->paginate(env('PAGINATE', 10))], ['categories' => Category::all()->where('parent_id', '=', null)]);
    }

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
    
        $img = self::saveImage($userId, $request, true);
        $image = Image::createImageObject($request['shopName'], $img);
        $shop = Shop::createShopObject($request['name'], $request['shopName'], $request['nif'], $userId, $image->id);
       
        return redirect()->route('shop.show');
    }

    public function newProduct()
    {
        return view('shop.newProductForm', ['categories' => Category::all()->where('parent_id', '=', null)]);

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
    public function showEdit()
    {   
        $userId = Auth::id();
        $shop = Shop::where('user_id', $userId)->first();
        
        if($userId != null){
            $productsShop = $shop->getAllShopProducts();
        }else{
            return redirect()->route('error.shopNotFound');
        }

        return view('shop.edit',['products' => $productsShop, 'shop' => $shop], ['categories' => Category::all()->where('parent_id', '=', null)]);
    }

    public function editShop(Request $request){
        $userId = Auth::id();
        $shop = Shop::where('user_id', '=' , $userId)->first();
        
        //dd($request);
        if($request->shopDescription != null){  
            $shop->description = $request->shopDescription;
            $shop->save();
        }if($request->shopBanner != null){
            if($shop->banner_id != null){
           
                self::deleteOldImage($shop);
            }  
            $img = self::saveImage($userId, $request,false);
            $image = Image::createImageObject($shop->nif, $img);

            $shop->banner_id = $image->id;
            $shop->save();
        }
        return redirect()->route('shop.edit');
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

    public function saveImage($userId, $request, $isLogo){
        $requestFile =  $request->file();
        $file = reset($requestFile);
        $extension = $file->getClientOriginalExtension();

        if($isLogo){
            $img = 'profileImg' . Auth::user()->id . '.' .  $extension;
            $file->storeAs('public/img/shopProfile', $img);
        }else{
            $img = 'profileBanner' . Auth::user()->id . '.' .  $extension;
            $file->storeAs('public/img/shopProfileBanner', $img);
        }
        return $img; 
    }


    public function deleteOldImage($shop){
        $image = Image::where('name',$shop->nif)->first();
        
        $disc = Storage::disk('img');
        $disc->delete('shopProfileBanner/' . $image->url);
        //$image->delete();
    }

}

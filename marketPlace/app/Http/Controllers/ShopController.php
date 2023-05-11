<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreate;
use App\Models\Shop;
use App\Models\User;
use App\Models\Image;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\ShopEdit;
use App\Http\Requests\ShopCreate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ShopController extends Controller
{
    public function index()
    {
    }

    /**
     * Funció que et retorna la vista de crear nova shop. 
     */
    public function createNewShop()
    {
        return view('shop.createNewShop', ['categories' => Category::all()->where('parent_id', '=', null)]);
    }

    /**
     * Funció per crear una nova shop. 
     */
    public function registerShop(ShopCreate $request)
    {
        // Validacions
        $request->validated();

        //Obtenir l'id de l'usuari que està connectat
        $userId = Auth::id();

        $img = self::saveImage($userId, $request);
        $image = Image::createImageObject($request['shopName'], $img);
        $shop = Shop::createShopObject($request['name'], $request['shopName'], $request['nif'], $userId, $image->id);

        return redirect()->route("shop.show", ['shopName' => $request['shopName']]);
    }

    public function newProduct()
    {
        return view('shop.newProductForm', ['categories' => Category::all()->where('parent_id', '=', null)], ['subcategories' => Category::all()]);
    }

    public function addProduct(Request $request)
    {
        $return = Product::addProduct($request);

        if (!$return) {
            return redirect()->route('shop.newProduct')->withInput()->with([
                "error" => "El nombre de este producto ya está registrado, prueba con otro nombre"
            ]);
        } else if ($return === "img") {
            return redirect()->route('shop.newProduct')->withInput()->with([
                "error" => "Por favor, escoge una imagen destacada"
            ]);
        } else {
            return redirect()->route('shop.newProduct')->with([
                "message" => "Producto añadido!"
            ]);
        }
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
    public function show(string $shopName)
    {
        Log::debug("Intentando acceder a la tienda: " . $shopName);

        try {

            $shop = Shop::where('name', '=', $shopName)->firstOrFail();
            Log::debug("Dentro del trycatch");

            if ($shop == null) {
                throw new Exception('No se ha encontrado la tienda con nombre ' . $shopName);
            }

            $productsShop = $shop->getShopProducts();

            $shopOwner = $shop->getOwner();

            return view('shop.index', ['productsShop' => $productsShop, 'shop' => $shop], ['categories' => Category::all()->where('parent_id', '=', null)]);
        } catch (ModelNotFoundException $e) {
            Log::error("Error en intentar acceder a la tienda con nombre: " . $shopName);
            Log::error($e->getMessage());
            return redirect()->route('error.shopNotFoundError');
        } catch (Exception $e) {
            Log::error("Error en intentar acceder a la tienda con nombre: " . $shopName);
            Log::error($e->getMessage());
            return redirect()->route('error.shopNotFoundError');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function showEdit()
    {
        $userId = Auth::id();
        $shop = Shop::where('user_id', $userId)->first();

        if ($userId != null) {
            $productsShop = $shop->getAllShopProducts();
        } else {
            return redirect()->route('error.shopNotFound');
        }

        return view('shop.edit', ['products' => $productsShop, 'shop' => $shop], ['categories' => Category::all()->where('parent_id', '=', null)]);
    }

    public function editShop(ShopEdit $request)
    {

        $request->validated();

        $userId = Auth::id();
        $shop = Shop::where('user_id', '=', $userId)->first();
        if ($request->shopDescription != null) {
            $shop->description = $request->shopDescription;
            $shop->save();
        }

        if ($request->shopBanner != null) {
            if ($shop->banner_id != null) {

                self::deleteOldImage($shop, $request);
                $img = self::saveImage($userId, $request);
                $image = Image::createImageObject($shop->nif, $img);

                $shop->banner_id = $image->id;
                $shop->save();
            } else {
                $img = self::saveImage($userId, $request);
                $image = Image::createImageObject($shop->nif, $img);

                $shop->banner_id = $image->id;
                $shop->save();
            }
        }

        if ($request->profileImg != null) {
            self::deleteOldImage($shop, $request);
            $img = self::saveImage($userId, $request);
            $image = Image::createImageObject($shop->name, $img);
            $shop->logo_id = $image->id;
            $shop->save();
        }
        return redirect()->route('shop.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProduct(Request $request, $id)
    {
        $return = Product::updateProduct($request, $id);

        $userId = Auth::id();

        if (!$return) {
            return redirect()->route('shop.showEditProduct', $id)->withInput()->with([
                "error" => "Producto actualizado!"
            ]);
        } else {
            return redirect()->route('shop.showEditProduct', $id)->with([
                "message" => "ERROR!"
            ]);
        }
    }

    public function showUpdateProduct($id)
    {
        $userId = Auth::id();
        $productsShop = Product::where('id', $id)->first()->shop_id;
        $userProductShop = Shop::where("id", $productsShop)->where("user_id", $userId)->first();

        if($userProductShop == null){
            return redirect()->route('shop.show', [Shop::where("user_id", $userId)->first()->name])->withInput()->with([
                "error" => "No tienes acceso a este producto"
            ]);
        }

        return view('shop.editProductForm', ['product' => Product::all()->where('id', '=', $id)->first()], ['categories' => Category::all()->where('parent_id', '=', null)]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function saveImage($userId, $request)
    {

        if ($request->shopName != null) {
            $file = $request->file('profilePhoto');
            $extension = $file->getClientOriginalExtension();

            $img = 'profileImg' . Auth::user()->id . '.' .  $extension;
            $file->storeAs('public/img/shopProfile', $img);
        }
        if ($request->profileImg != null) {
            $file = $request->file('profileImg');
            $extension = $file->getClientOriginalExtension();

            $img = 'profileImg' . Auth::user()->id . '.' .  $extension;
            $file->storeAs('public/img/shopProfile', $img);
        }
        if ($request->shopBanner != null) {
            $file = $request->file('shopBanner');

            $extension = $file->getClientOriginalExtension();
            $img = 'profileBanner' . Auth::user()->id . '.' .  $extension;
            $file->storeAs('public/img/shopProfileBanner', $img);
        }
        return $img;
    }

    public function deleteOldImage($shop, $request)
    {

        if ($request->shopBanner != null) {
            $image = Image::where('name', $shop->nif)->first();

            $disc = Storage::disk('img');
            $disc->delete('shopProfileBanner/' . $image->url);

            $shop->banner_id = null;
            $shop->save();
            $image->delete();
            return;
        }
        if ($request->profileImg != null) {
            $image = Image::where('name', $shop->name)->first();

            $disc = Storage::disk('img');
            $disc->delete('shopProfile/' . $image->url);

            $shop->logo_id = null;
            $shop->save();
            $image->delete();
            return;
        }
    }
}

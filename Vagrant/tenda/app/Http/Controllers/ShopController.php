<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\User;
use App\Models\Image;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\ShopEdit;
use App\Models\CategoryProduct;
use App\Http\Requests\ShopCreate;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ProductCreate;
use App\Http\Requests\ProductUpdate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;

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

        $img = self::saveImage($request);
        $image = Image::createImageObject($request['shopName'], $img);
        $shop = Shop::createShopObject($request['name'], $request['shopName'], $request['nif'], $userId, $image->id);

        Log::info("El usuario" . $userId . "ha creado una nueva tienda");

        return redirect()->route("shop.show", ['shopName' => $request['shopName']]);
    }

    public function getSubcategories(Request $request)
    {
        $categories = $request->get('categories');
        $categories_ids = Category::whereIn('name', explode(",", $categories))->pluck('id');
        $subcategories = Category::whereIn('parent_id', $categories_ids)->pluck('name');
        return new JsonResponse($subcategories);
    }

    public function newProduct()
    {
        return view('shop.newProductForm', ['categories' => Category::all()->where('parent_id', '=', null)]);
    }

    public function addProduct(ProductCreate $request)
    {
        $request->validated();

        $return = Product::addProduct($request);

        if (!$return) {
            return redirect()->route('shop.newProduct')->withInput()->with([
                "error" => "El nombre de este producto ya está registrado, prueba con otro nombre"
            ]);
        } else {
            return redirect()->route('shop.newProduct')->with([
                "message" => "Producto añadido!"
            ]);
        }

        Log::info("Se ha añadido un nuevo producto a una tienda:" . $return);
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

        Log::info("Intentando acceder a pagina de edición de tienda:" . $shop);

        if ($userId != null) {
            $productsShop = $shop->getAllShopProducts(); 
            
            if($productsShop->count() > 0){
                $lastOrder = Shop::getLastOrderProduct($shop->id);
                $firstOrder = Shop::getFirstOrderProduct($shop->id);
                return view('shop.edit', ['products' => $productsShop, 'shop' => $shop, 'lastOrder' =>  $lastOrder,'firstOrder'=> $firstOrder ], ['categories' => Category::all()->where('parent_id', '=', null)]);
            }
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
       
        Log::info("Intentando editar una tienda:" . $shop);

        $shop->description = $request->shopDescription;
        $shop->save();

        if ($request->shopBanner != null) {
            if ($shop->banner_id != null) {
                self::deleteOldShopBanner($shop, $request);
                $img = self::saveBannerImage($request);
                $image = Image::createImageObject($shop->nif, $img);

                $shop->banner_id = $image->id;
                $shop->save();
            } else {
                $img = self::saveBannerImage($request);
                $image = Image::createImageObject($shop->nif, $img);

                $shop->banner_id = $image->id;
                $shop->save();
            }
        }

        if ($request->profileImg != null) {
            self::deleteOldShopImage($shop, $request);
            $img = self::saveImage($request);
            $image = Image::createImageObject($shop->name, $img);
            $shop->logo_id = $image->id;
            $shop->save();
        }
        return redirect()->route('shop.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProductPendent(Request $request, $id)
    {
        $return = Product::updateProduct($request, $id);

        if ($return) {
            return redirect()->route('shop.showEditProduct', $id)->withInput()->with([
                "error" => "Producto actualizado!"
            ]);
        } else {
            return redirect()->route('shop.showEditProduct', $id)->with([
                "message" => "ERROR!"
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProduct(Request $request)
    {
        $response = [
            "status" => "",
            "msg" => "",
            "action" => ""
        ];
        $executed = false;
        try {
            $product = Product::findOrFail($request->query('id'));
            switch ($request->query('action')) {
                case "habilitar":
                    $product->isVisible = true;
                    $executed = true;
                    $response['action'] =  "able";
                    break;
                case "deshabilitar":
                    $product->isVisible = false;
                    $executed = true;
                    $response['action'] =  "dissable";
                    break;
                case "eliminar":
                    $product->isDeleted = true;
                    $executed = true;
                    $response['action'] =  "delete";
                    break;
                default:
                    break;
            }
            if ($executed) {
                $product->save();
                $response['status'] = $executed;
                $response['msg'] =  $product->name;
            }
        } catch (\Throwable $th) {
            $response['status'] = $executed;
            $response['msg'] = 'Error';
        }

        return response()->json($response);
    }


    public function updateOrderProduct(Request $request)
    {
        $response = [
            "status" => "",
            "action" => "",
            "msg" => "",
            'actualProduct' => "",
            'ProductAnterior' =>"",
            'ProductPosterior' =>""
        ];
        $ActualShop = Shop::where('user_id',Auth::user()->id)->first();

        $ShopProducts = Product::where('shop_id','=', $ActualShop->id)
        ->orderBy('order', 'asc')
        ->get();

        $Nproducts = count($ShopProducts) -1;
        $isFinal = false;
        
        for ($i=0; $i < count($ShopProducts) ; $i++) { 
           
            if($ShopProducts[$i]->id == $request->query('id')){
                $Actualproduct = $ShopProducts[$i];
                if($i != 0){
                    $previousProduct = $ShopProducts[$i -1];            
                }
                if($i != $Nproducts){
                    $laterProduct = $ShopProducts[$i +1];
                }
            }  
        }

        $executed = false;
        try {
            switch ($request->query('action')) {
                case "up":
                    $Actualproduct->decrement('order');
                    $Actualproduct->save();
                    $previousProduct->increment('order');
                    $previousProduct->save();
                    $executed = true;
                    $response['action'] =  "ordarChange Up";
                    $response['actualProduct'] = $Actualproduct->name;
                    $response['ProductPosterior'] = $previousProduct->name; 
                    break;
                case "down":
                    $Actualproduct->increment('order');
                    $Actualproduct->save();
                    $laterProduct->decrement('order');
                    $laterProduct->save();
                    $executed = true;
                    $response['action'] =  "ordarChange down";
                    $response['actualProduct'] = $Actualproduct->name;
                    $response['ProductAnterior'] = $previousProduct->name; 
                    break;
                default:
                    break;
            }
            if ($executed) {
                $product->save();
                $response['status'] = $executed;
                $response['msg'] =  "Hecho";
            }
        } catch (\Throwable $th) {
            $response['status'] = $executed;
            $response['msg'] = 'Error';
        }

        return response()->json($response);
    }

    public function showUpdateProduct($id)
    {
        $userId = Auth::id();
        $productsShop = Product::where('id', $id)->first()->shop_id;
        $userProductShop = Shop::where("id", $productsShop)->where("user_id", $userId)->first();

        if ($userProductShop == null) {
            return redirect()->route('shop.show', [Shop::where("user_id", $userId)->first()->name])->withInput()->with([
                "error" => "No tienes acceso a este producto"
            ]);
        }

        $categoriesId = CategoryProduct::where('product_id', $id)->pluck("category_id")->toArray();

        $categoriesName = [];
        foreach ($categoriesId as $key => $value) {
            array_push($categoriesName, Category::where("id", $value)->first()->name);
        }

        return view('shop.editProductForm', ['product' => Product::all()->where('id', '=', $id)->first(), 'productCategories' => $categoriesName], ['categories' => Category::all()->where('parent_id', '=', null)]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function saveImage($request)
    {

        if ($request->shopName != null) {
            $file = $request->file('profilePhoto');
            $extension = $file->getClientOriginalExtension();

            $img = 'profileImg' . Auth::user()->id . '.' .  $extension;
            $file->storeAs('public/img/shopProfile', $img);
            Log::info("Guardado imagen de perfil de tienda en Storage:" . $img);
        }
        if ($request->profileImg != null) {
            $file = $request->file('profileImg');
            $extension = $file->getClientOriginalExtension();

            $img = 'profileImg' . Auth::user()->id . '.' .  $extension;
            $file->storeAs('public/img/shopProfile', $img);
            Log::info("Guardado imagen de perfil de tienda en Storage:" . $img);
        }
        return $img;
    }

    public function saveBannerImage($request)
    {

        if ($request->shopBanner != null) {
            $file = $request->file('shopBanner');

            $extension = $file->getClientOriginalExtension();
            $img = 'profileBanner' . Auth::user()->id . '.' .  $extension;
            $file->storeAs('public/img/shopProfileBanner', $img);
            return $img;

            Log::info("Cambiado imagen de banner de tienda:" . $img);

        }
        return redirect()->route('error.genericError');
    }

    public function deleteOldShopImage($shop, $request)
    {

        if ($request->profileImg != null) {
            $image = Image::where('name', $shop->name)->first();

            $disc = Storage::disk('img');
            $disc->delete('shopProfile/' . $image->url);

            $shop->logo_id = null;
            $shop->save();
            $image->delete();

            Log::info("Eliminado imagen de perfil de tienda Storage:" . $image);

        }
    }

    public function deleteOldShopBanner($shop, $request)
    {

        if ($request->shopBanner != null) {
            $image = Image::where('name', $shop->nif)->first();

            $disc = Storage::disk('img');
            $disc->delete('shopProfileBanner/' . $image->url);

            $shop->banner_id = null;
            $shop->save();
            $image->delete();
            Log::info("Eliminado imagen de perfil de tienda Storage:" . $image);
        }
    }
}

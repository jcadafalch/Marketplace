<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
  use HasFactory;
  protected $fillable = [
    'name',
    'description',
    'price',
    'url'
  ];

  public function categories()
  {
    return $this->belongsToMany(Category::class)->withTimeStamps();
  }

  /**
   * Funció per cerca per nom i ordenació
   */
  public static function searchByName($request)
  {
    $fieldSearch = $request['search'];
    $order = $request['order'];
    $order = empty($request['order']) ? 'ASC' : $request['order'];

    return $productsFilter = Product::with('categories')->where('name', 'LIKE', '%' . $fieldSearch . '%')
      ->orderBy('name', $order)
      ->paginate(env('PAGINATE', 10));
  }

  /**
   * Funció obtenir informació del producte per l'id 
   */
  public static function getInfoFromId($id)
  {
    $products = array();
    $idArray = explode('.', $id);
    foreach ($idArray as $char) {
      if ($char != "") {
        array_push($products, Product::all()->where("id", $char)->first());
      }
      //array_push($products, Product::all()->where("id", $value)->first());
    }
    return $products;
  }

  /**
   * Funció per buscar per nom, categoria i subCategoria  
   */
  public static function searchByAll($request)
  {
    $fieldSearch = $request['search'];
    $category = $request['category'];
    $order = $request['order'];
    $order = empty($request['order']) ? 'ASC' : $request['order'];

    $subcategoriesName = Category::getSubCategories($category)->pluck('name')->toArray();

    $searchName = explode(' ', $fieldSearch);
    $fieldCamps = array_merge($searchName, $subcategoriesName);


    return self::getAllSearchedProducts($searchName, $category, $fieldCamps, $order);
  }

  /**
   * Funció per buscar per nom introduit a la cerca i amb ordenació 
   */
  public static function getAllSearchedProducts($searchName, $category, $fieldCamps, $order)
  {
    $result = new Collection();
    for ($i = 0; $i < count($fieldCamps); $i++) {
      $p = DB::table('products')
        ->join('category_product', 'products.id', '=', 'category_product.id')
        ->where('category_product.category_id', 'LIKE', '%' . $category . '%')
        ->where('products.name', 'LIKE', '%' . $fieldCamps[$i] . '%')->paginate(env('PAGINATE', 10));

      if ($result == $p || $i == 0) {
        $result = $p;
        continue;
      }
      // Ens quedem només amb els id no repetits
      $diferenIdProducts = array_diff($p->pluck('id')->toArray(), $result->pluck('id')->toArray());

      // Busquem els productes per l'id i els guardem amb una collection
      for ($j = 0; $j < count($diferenIdProducts); $j++) {
        $result->add(
          DB::table('products')
            ->where('products.id', '=', $diferenIdProducts[0])->first()
        );
      }
    }
    $resultOrder = $order == 'ASC' ?  $result->sortBy('name') : $result->sortByDesc('name');

    // Instanciem  un objecte Paginator, amb els paràmetres de la collection
    return new LengthAwarePaginator($resultOrder, $result->total(), $result->perPage());
  }

  public static function landingPageFilter(){
    $categoriLevel2Name = env('LANDING_PAGE_CATEGORI_LEVEL_2_NAME');
    $orderBy = env('LANDING_PAGE_ORDER_BY', 'ASC');
    
   return DB::table('products')
   ->select('products.id','products.created_at', 'products.updated_at','products.name', 'products.description','products.price','products.url','products.selled_at','products.shop_id')
        ->join('category_product', 'products.id', '=', 'category_product.id')
        ->join('categories', 'category_product.id', '=', 'categories.id')
        ->where('categories.name', 'LIKE', $categoriLevel2Name)
        ->orderBy('products.name', $orderBy)->paginate(env('PAGINATE', 10));
  }
}

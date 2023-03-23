<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
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

  
  public static function searchByName($request)
  {
    $fieldSearch = $request['search'];
    $order = $request['order'];
    $order = empty($request['order']) ? 'ASC' : $request['order'];

    return $productsFilter = Product::with('categories')->where('name', 'LIKE', '%' . $fieldSearch . '%')
      ->orderBy('name', $order)
      ->paginate(env('PAGINATE', 10));
  }
  public static function getInfoFromId($id)
  {
    $products = array();
    foreach ($id as $key => $value) {
      array_push($products, Product::all()->where("id", $value)->first());
    }
    return $products;
  }
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

  public static function getAllSearchedProducts($searchName, $category, $fieldCamps, $order){
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

      $diferenIdProducts = array_diff($p->pluck('id')->toArray(), $result->pluck('id')->toArray());

      for ($j = 0; $j < count($diferenIdProducts); $j++) {
        $result->add(
          DB::table('products')
            ->where('products.id', '=', $diferenIdProducts[0])->first()
        );
      }
    }  

    //dd(strtolower($order));
    //$result = $order == 'ASC' ?  $result->sortBy('name') : $result->sortByDesc('name');
    dd($result);
    return $result;
  }
}

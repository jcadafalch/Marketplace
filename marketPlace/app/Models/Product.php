<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
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

    public static function getInfoFromId($id)
    {   
        $products = array();
        foreach ($id as $key => $value) {
            array_push($products, Product::all()->where("id", $value)->first());
        }
        return $products;
    }
    public static function searchByName($request){
        $fieldSearch = $request['search'];
        $order = $request['order'];
        $order = empty($request['order']) ? 'ASC' : $request['order'];

        return $productsFilter = Product::with('categories')->where('name', 'LIKE' ,'%' . $fieldSearch . '%')
        ->orderBy('name', $order)
        ->paginate(env('PAGINATE', 10));
    }

    public static function searchByAll($request){
        $fieldSearch = $request['search'];
        $category = $request['category'];
        $order = $request['order'];
        $order = empty($request['order']) ? 'ASC' : $request['order'];

        $subCategories = Category::select('name')
            ->where('parent_id', 1)->get();
        
        $subcategoriesName = $subCategories->pluck('name')->toArray(); 
        //dd($subcategoriesName);

       $searchName = explode(' ',$fieldSearch);
       $fieldCamps = array_merge($searchName,$subcategoriesName);

       
       //dd($fieldCamps);
       
        //dd($result);
        $result = DB::table('products')
        ->join('category_product', 'products.id', '=', 'category_product.id')
        ->where('category_product.id','LIKE' ,'%' . $category . '%')
        ->where('products.name', 'LIKE' ,'%' . $fieldCamps[0] . '%')->paginate(env('PAGINATE', 10));
        //dd($result);
        for ($i=1; $i < count($fieldCamps); $i++) { 
          //dd($fieldCamps[$i]);  
        $p = DB::table('products')
          ->join('category_product', 'products.id', '=', 'category_product.id')
          ->where('category_product.category_id','LIKE' ,'%' . $category . '%')
          ->where('products.name', 'LIKE' ,'%' . $fieldCamps[$i] . '%')->get();
          //$diferentProducts = $p->diff($result);
        
          if($result==$p){
            Log::debug("continue");
            continue;
          }

        $diferenIdProducts = array_diff($p->pluck('id')->toArray(),$result->pluck('id')->toArray());
        //dd($diferenIdProducts);
        for ($j=0; $j < count($diferenIdProducts) ; $j++) { 
          $result->add(
          DB::table('products')
          ->where('products.id','=' , $diferenIdProducts[0])->first()
          ); 
          //dd($result);
        }
        }
        //dd($result);
        return $result;
        
        
        //dd($diferenIdProducts);
        //$diferentProducts = $p->diff(Category::whereIn('id', $result->pluck('id')->toArray()));
        



        /*return $productsFilter = 
        DB::table('products')
            ->join('category_product', 'products.id', '=', 'category_product.id')
            ->where('products.name', 'LIKE' ,'%' . $fieldSearch . '%')
            ->where('category_product.id','LIKE' ,'%' . $category . '%')
            ->orderBy('products.name', $order)
            ->paginate(env('PAGINATE', 10));*/
    }
}

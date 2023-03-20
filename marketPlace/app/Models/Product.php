<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
            array_push($products, Product::all()->where("id", $value));
        }
        return $products;
    }
    public static function searchByName($request){
        $fieldSearch = $request['search'];
        $order = $request['order'];
        $order = empty($request['order']) ? 'ASC' : $request['order'];

        return $productsFilter = Product::with('categories')->where('name', 'LIKE' ,'%' . $fieldSearch . '%')
        ->orderBy('name', $order)
        ->paginate(env('PAGINATE'));
    }

    public static function searchByAll($request){
        $fieldSearch = $request['search'];
        $category = $request['category'];
        $order = $request['order'];
        $order = empty($request['order']) ? 'ASC' : $request['order'];
        return $productsFilter = 
        DB::table('products')
            ->join('category_product', 'products.id', '=', 'category_product.id')
            ->where('products.name', 'LIKE' ,'%' . $fieldSearch . '%')
            ->where('category_product.id','LIKE' ,'%' . $category . '%')
            ->orderBy('products.name', $order)
            ->paginate(env('PAGINATE'));
    }
}

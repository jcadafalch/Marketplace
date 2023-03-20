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

    public function categories() {
        return $this->belongsToMany(Category::class)->withTimeStamps();
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
        return $productsFilter = 
        DB::table('products')
            ->join('category_product', 'products.id', '=', 'category_product.id')
            ->where('products.name', 'LIKE' ,'%' . $fieldSearch . '%')
            ->where('category_product.id','LIKE' ,'%' . $category . '%')
            ->orderBy('products.name', $order)
            ->paginate(env('PAGINATE', 10));
    }
}

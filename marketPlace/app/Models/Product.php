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
        return $productsFilter = Product::with('categories')->where('name', 'LIKE' ,'%' . $fieldSearch . '%') 
        ->get();
    }

    public static function searchByAll($request){
        $fieldSearch = $request['search'];
        $category = $request['category'];
        return $productsFilter = 
        DB::table('products')
            ->join('category_product', 'id', '=', 'category_product.id')
            ->join('categories', 'categories.id', '=', 'category_product.id')
            ->where('name', 'LIKE' ,'%' . $fieldSearch . '%')
            ->where('c.name','LIKE' ,'%' . $category . '%')
            ->select('name','price','url','categories.name');  
    }
    
}

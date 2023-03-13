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
        //dd($fieldSearch);
        return $productsFilter = Product::with('categories')->where('name', 'LIKE' ,'%' . $fieldSearch . '%')
        ->orderBy('name', 'ASC')
        ->paginate(5);
    }

    public static function searchByAll($request){
        $fieldSearch = $request['search'];
        $category = $request['category'];
        return $productsFilter = 
        DB::table('products')
            ->join('category_product', 'products.id', '=', 'category_product.id')
            ->where('products.name', 'LIKE' ,'%' . $fieldSearch . '%')
            ->where('category_product.id','LIKE' ,'%' . $category . '%')
            ->orderBy('products.name', 'ASC')
            ->paginate(5);
    }
    
}

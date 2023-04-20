<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shop extends Model
{
    use HasFactory;

    public function products(){
        return $this->hasMany(Product::class)->withTimeStamps();
    }

    //select * from products inner join shops where shop_id = shops.id;

    public static function getShopNameByProductId($selectedId){

        $result = DB::table('shops')
        ->select('shops.shop_name', 'shops.id')
        ->join('products', 'products.shop_id', '=', 'shops.id')
        ->where('products.id', '=', $selectedId)
        ->get();

        return $result;
    }
}

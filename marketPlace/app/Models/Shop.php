<?php

namespace App\Models;

use App\Models\User;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shop extends Model
{
    use HasFactory;

    public function products(){
        return $this->hasMany(Product::class)->withTimeStamps();
    }
    
    public function logo(){
        return $this->hasMany(Image::class)->withTimeStamps();
    }

    public function banner(){
        return $this->hasMany(Image::class)->withTimeStamps();
    }

    public static function getShopNameByProductId($selectedId){

        $result = DB::table('shops')
        ->select('shops.shop_name', 'shops.id')
        ->join('products', 'products.shop_id', '=', 'shops.id')
        ->where('products.id', '=', $selectedId)
        ->get();

        return $result;
    }
}

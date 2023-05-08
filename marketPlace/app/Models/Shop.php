<?php

namespace App\Models;

use App\Models\User;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shop extends Model
{
    use HasFactory;

    public function products(){
        return $this->hasMany(Product::class)->withTimeStamps();
    }

    public function getShopProducts(){

        return Product::where('shop_id', $this->id)->where('isVisible', '=', 1)
        ->where('isDeleted','=',0)
        ->whereNull('selled_at')
        ->orderBy('order', 'asc')
        ->paginate(env('PAGINATE', 10));
    }
    
    public function logo(){
        return $this->hasMany(Image::class)->withTimeStamps();
    }

    public function banner(){
        return $this->hasMany(Image::class)->withTimeStamps();
    }

    public function getLogo(){
        return Image::where('id', $this->logo_id)->first();
    }

    public function getBanner(){
        return Image::where('id', $this->banner_id)->first();
    }

    public function getOwner(){
        return User::where('id', $this->user_id)->first();
    }

    public static function getShopNameByProductId($selectedId){

        $result = DB::table('shops')
        ->select('shops.name', 'shops.id')
        ->join('products', 'products.shop_id', '=', 'shops.id')
        ->where('products.id', '=', $selectedId)
        ->get();

        return $result;
    }
}

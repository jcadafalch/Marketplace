<?php

namespace App\Models;

use App\Models\Shop;
use App\Models\ProductOderLine;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderLine extends Model
{
    use HasFactory;

    protected $fillable = [
        'OrderId',
        'ProductId',
        'Price',
    ];

    public function orders(){
        return $this->belongsToOne(Order::class)->withTimeStamps();
    }

    public function products(){
        return $this->hasMany(ProductOderLine::class)->withTimeStamps();
    }

    public function shop(){
        return $this->hasOne(Shop::class)->withTimeStamps();
    }

    public static function getOrderFromId($id){
        return OrderLine::all()->where("id", $id)->first();
    }

    public static function getOrderlineFromOrderId($id){
        return OrderLine::all()->where("order_id", $id);
    }
}

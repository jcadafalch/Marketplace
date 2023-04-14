<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public static function getOrderFromId($id){
        return OrderLine::all()->where("id", $id)->first();
    }

    public static function getOrderlineFromOrderId($id){
        return OrderLine::all()->where("order_id", $id);
    }
}

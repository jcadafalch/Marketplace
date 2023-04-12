<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'UserId',
        'InProcess',
    ];

    public static function getOrderFromOrderId($id){
        return Order::all()->where("in_process", false)->first();
    }
}

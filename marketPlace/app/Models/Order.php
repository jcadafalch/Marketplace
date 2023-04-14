<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'UserId',
        'InProcess',
    ];

    public static function getOrderFromOrderId($id)
    {
        return Order::all()->where("in_process", false)->first();
    }

    public static function getIdsFromUserId($id)
    {
        $orderId = Order::all()->where("user_id", $id);
        return OrderLine::getOrderlineFromOrderId($orderId)->pluck('product_id');
    }

    public static function addIds($ids, $userId)
    {
        $userOrder = Order::all()->where("user_id", $userId)->first();
        if ($userOrder != null) {
            $idArray = explode(".", $ids);
            foreach ($idArray as $char) {
                $productPrice = Product::where("id", $char)->pluck("price");
                $orderLine = new OrderLine($userOrder->id, $char, $productPrice);
                $orderLine->save();
            }
        } else {
            $order = new Order($userId, true);
            $order->save();
            $idArray = explode(".", $ids);
            foreach ($idArray as $char) {
                $productPrice = Product::where("id", $char)->pluck("price");
                $orderLine = new OrderLine($order->id, $char, $productPrice);
                $orderLine->save();
            }
        }
    }
}

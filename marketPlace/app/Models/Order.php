<?php

namespace App\Models;

use App\Models\OrderLine;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'in_process',
    ];

    public static function getOrderFromOrderId($id)
    {
        return Order::all()->where("in_process", false)->first();
    }

    public static function getIdsFromUserId($id)
    {
        $orderId = Order::all()->where("user_id", $id)->first();
        if ($orderId != null) {
            return OrderLine::getOrderlineFromOrderId($orderId->id)->pluck('product_id');
        } else {
            return null;
        }
    }

    public static function checkForShoppingCart($userId)
    {
        $orderIds = Order::getIdsFromUserId($userId);
        if ($orderIds != []) {
            unset($_COOKIE["shoppingCartProductsId"]);
            $cookieValue = null;
            foreach ($orderIds as $key => $value) {
                Log::alert($value);
                $cookieValue = $cookieValue . $value . ".";
            }
            setcookie("shoppingCartProductsId", "$cookieValue", ["Path" => "/", "SameSite" => "Lax"]);
        }
    }

    public static function addIds($ids, $userId)
    {
        $userOrder = Order::all()->where("user_id", $userId)->first();
        if ($userOrder != null) {
            $idArray = explode(".", $ids);
            //Log::alert($ids);
            foreach ($idArray as $key => $char) {
                if ($char != "") {
                    if (OrderLine::all()->where("product_id", $char)->where("order_id", $userOrder->id)->first() == null) {
                        $productPrice = Product::where("id", $char)->pluck("price")->first();
                        $orderLine = new OrderLine();
                        $orderLine->order_id = $userOrder->id;
                        $orderLine->product_id = $char;
                        $orderLine->price = $productPrice;
                        $orderLine->save();
                    }
                }
            }
        } else {
            $order = new Order();
            $order->user_id = $userId;
            $order->in_process = 0;
            $order->save();
            $idArray = explode(".", $ids);
            foreach ($idArray as $char) {
                if ($char != "") {
                    if (OrderLine::all()->where("product_id", $char)->where("order_id", $order->id)->first() == null) {
                        $productPrice = Product::where("id", $char)->pluck("price")->first();
                        $orderLine = new OrderLine();
                        $orderLine->order_id = $order->id;
                        $orderLine->product_id = $char;
                        $orderLine->price = $productPrice;
                        $orderLine->save();
                    }
                }
            }
        }
    }

    public static function delIds($id)
    {
        $userOrder = Order::all()->where("user_id", Auth::id())->first();
        if ($userOrder != null) {
            $deleteOrderLine = OrderLine::all()->where("product_id", $id)->where("order_id", $userOrder->id)->first();
            $deleteOrderLine->delete();
        }
    }
}

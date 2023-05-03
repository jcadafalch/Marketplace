<?php

namespace App\Models;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderLine;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'in_process',
    ];

    public function user(){
        return $this->belongsTo(User::class)->withTimeStamps();
    }
    
    public function lines(){
        return $this-> hasMany(OrderLine::class)->withTimeStamps();
    }
   

    public static function getOrderFromOrderId($id)
    {
        return Order::all()->where("in_process", false)->first();
    }

    public static function getIdsFromUserId($id)
    {
        $orderId = Order::all()->where("user_id", $id)->first();
        return OrderLine::getOrderlineFromOrderId($orderId->id)->pluck('product_id');
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

    /**
     * This function adds product IDs to a user's order or creates a new order if the user does not
     * have an existing order in process.
     * 
     * @param ids The parameter "ids" is a string containing a list of product IDs separated by dots
     * (".") that need to be added to the user's order.
     * @param userId The ID of the user for whom the order is being created or updated.
     */
    public static function addIds($ids, $userId)
    {
        $userOrder = Order::all()->where("user_id", $userId)->where('in_process', 1)->first();

        if ($userOrder != null) {
            $idArray = explode(".", $ids);
            foreach ($idArray as $key => $char) {
                if ($char != "") {
                    
                    $product = Product::where("id", $char)->first();
                    if ($product != null) {
                        OrderLine::addProduct($product, $userOrder->id);
                    }

                }
            }
        } else {
            $order = new Order();
            $order->user_id = $userId;
            $order->in_process = 1;
            $order->save();
            Log::debug('Se ha creado un nuevo Order: ', ['Order' => $order]);

            $idArray = explode(".", $ids);
            foreach ($idArray as $char) {
                if ($char != "") {

                    $product = Product::where("id", $char)->first();
                    if ($product != null) {
                        OrderLine::addProduct($product, $order->id);
                    }
                }
            }
        }
    }
}

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

    /**
     * Esta función añade IDs de productos al pedido de un usuario o crea un nuevo pedido si el usuario no tiene un pedido en curso.
     * 
     * @param ids El parámetro "ids" es una cadena que contiene una lista de ID de productos separados por puntos (".") que deben añadirse al pedido del usuario.
     * @param userId El ID del usuario para el que se está creando o actualizando la orden.
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
            Log::info('Se ha creado un nuevo Order: ', ['Order' => $order]);

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

    public static function delIds($id)
    {
        $userOrder = Order::where("user_id", Auth::user()->id)->where('in_process', 1)->first();

       Log::debug("UserOrder = " . $userOrder);
        if ($userOrder != null) {

            Log::debug("Se ha encontrado la order de donde vamos a eliminar un producto. :orderId", ['orderId' => $userOrder->id]);

            $product = Product::where('id', '=', $id)->first();

            if($product != null){
                Log::debug("Se ha encontrado el producto que vamos a eliminar. :product", ['product' => $product]);
                OrderLine::deleteProduct($product, $userOrder->id);
            }
        }
    }

    /**
     * Esta función recupera los productos asociados a un pedido dado.
     * 
     * @param orderId El parámetro orderId es un número entero que representa el ID de un pedido. La
     * función `getOrderProducts` recupera los productos asociados con el pedido especificado por
     * .
     * 
     * @return los productos asociados con el pedido identificado por el parámetro . Si no se
     * encuentra el pedido, devuelve nulo.
     */
    public static function getOrderProducts($orderId)
    {
        $order = Order::find($orderId);
        if($order == null){
            return null;
        }

        return OrderLine::getOrderLineProducts($orderId);
    }

    public static function closeOrder($orderId)
    {
        $order = Order::find($orderId);
        if($order == null){
            return null;
        }

        // TODO: marcar order com acabada
    }
}

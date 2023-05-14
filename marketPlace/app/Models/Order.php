<?php

namespace App\Models;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderLine;
use App\Models\ProductOderLine;
use Illuminate\Support\Facades\DB;
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

    public function user()
    {
        return $this->belongsTo(User::class)->withTimeStamps();
    }

    public function lines()
    {
        return $this->hasMany(OrderLine::class)->withTimeStamps();
    }


    public static function getOrderFromOrderId($id)
    {
        return Order::all()->where("in_process", false)->first();
    }

    public static function getIdsFromUserId($id)
    {
        $orderId = Order::all()->where("user_id", $id)->first();
        if ($orderId != null) {
            return OrderLine::getOrderlineFromOrderId($orderId->id)->pluck('id');
        } else {
            return null;
        }
    }

    public static function checkForShoppingCart($userId)
    {
        $orderIds = Order::getIdsFromUserId($userId);
        if ($orderIds != []) {
            $productsId = [];
            foreach ($orderIds as $key => $value) {
                array_push($productsId, ProductOderLine::all()->where("orderLine_id", $value)->first()->product_id);
            }

            if ($productsId != []) {
                unset($_COOKIE["shoppingCartProductsId"]);
                $cookieValue = null;
                foreach ($productsId as $key => $value) {
                    $cookieValue = $cookieValue . $value . ".";
                }
                setcookie("shoppingCartProductsId", "$cookieValue", ["Path" => "/", "SameSite" => "Lax"]);
            }
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

            if ($product != null) {
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
        if ($order == null) {
            return null;
        }

        return OrderLine::getOrderLineProducts($orderId);
    }

    /**
     * Esta función cierra un pedido actualizando su estado, actualizando el estado de sus líneas de
     * pedido y actualizando la visibilidad y la fecha de venta de los productos asociados con el
     * pedido.
     * 
     * @param orderId El parámetro  es un número entero que representa el ID de la orden que
     * debe cerrarse.
     * 
     * @return string Si todo va bien, devuelve "true". Si hay un error, devuelve un
     * mensaje de error.
     */
    public static function closeOrder($orderId)
    {
        // Comenzamos la transacción
        DB::beginTransaction();

        $order = Order::find($orderId);
        if ($order == null) {
            Log::error("No se ha encontrado la order con id $orderId");
            DB::rollBack();
            return "No se ha encontrado el pedido";
        }

        $order->in_process = 0;
        $order->closed_at = now();
        $order->save();

        $orderLines = OrderLine::where('order_id', '=', $order->id)->get();

        if($orderLines == null){
            Log::error("No se han encontrado las lineas de la order con id $orderId");
            DB::rollBack();
            return "No se han encontrado las lineas lineas del pedido";
        }

        OrderLine::query()->where('order_id', '=', $order->id)->update(['pendingToPay' => 1]);

        $orderLineIds = $orderLines->pluck('id');

        $productIds = ProductOderLine::whereIn('orderLine_id', $orderLineIds)->pluck('product_id');

        if($productIds == null){
            Log::error("No se han encontrado los productos de la order con id $orderId");
            DB::rollBack();
            return "No se han encontrado los productos de estre pedido";
        }

        $numProductsUpdated = Product::whereIn('id', $productIds)->update([
            'isVisible' => 0,
            'selled_at' => now()
        ]);

        if($numProductsUpdated === 0){
            Log::error("No se han podido actualizar los productos de la order con id $orderId");
            DB::rollBack();
            return "No se han encontrado los productos relacionados con este pedido";
        }

        // Confirmamos la transacción
        DB::commit();

        Log::info("La order $orderId se ha realizo correctamente.");

        // Eliminamos la cookie para indicar que el carrito esta vacio
        setcookie('shoppingCartProductsId', '', time() - 3600, '/', '', false, true);


        return "true";
    }
}

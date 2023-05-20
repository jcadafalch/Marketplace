<?php

namespace App\Models;

use App\Models\Shop;
use App\Models\OrderLine;
use App\Models\ProductOderLine;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Order;

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

    /**
     * Esta función añade un producto a un pedido creando una nueva línea de pedido o añadiéndolo a una ya existente.
     * 
     * @param product El producto que debe añadirse a la línea de pedido.
     * @param orderId ID del pedido al que se añade el producto.
     */
    public static function addProduct($product, $orderId){
        $orderLine = OrderLine::where('order_id', $orderId)->where('shop_id', $product->shop_id)->first();

        if($orderLine != null){
            ProductOderLine::addProduct($product, $orderLine->id);
        }else{
            $newOrderLine = new OrderLine();
            $newOrderLine->order_id = $orderId;
            $newOrderLine->shop_id = $product->shop_id;
            $newOrderLine->save();
            Log::info("Se ha creado una nueva OrderLine", ['OrderLine' => $newOrderLine]);

            ProductOderLine::addProduct($product, $newOrderLine->id);
        }
    }

    public static function deleteProduct($product, $orderId){

        $orderLine = OrderLine::where('order_id', $orderId)->where('shop_id', $product->shop_id)->first();

        Log::debug("OrderLine de orderLineId :orderId, orderLine :orderLine", ['orderId' => $orderId, 'orderLine' => $orderLine]);
        if($orderLine != null){
            Log::debug("Se ha encontrado la orderLine de donde vamos a eliminar un producto");
            ProductOderLine::DeleteProduct($product, $orderLine->id);
        }
    }

    public static function getOrderLineProducts($orderId){
        $orderLines = OrderLine::where('order_id', '=', $orderId)->get();
    
        Log::debug('OrderLines = ', ['orderLines' => $orderLines]);

        if($orderLines == null)
        {
            return null;
        }

        $orderLineProducts = collect();

        foreach ($orderLines as $orderLine) {
            $products = ProductOderLine::getProductOfOrderLine($orderLine->id);

            Log::debug('OrderLinesProducts = ', ['products' => $products]);

            if($products != null){
                $orderLineProducts = $orderLineProducts->merge($products);
            }
        }

        if($orderLineProducts->isEmpty()){
            Log::debug("OrderLineProduct is emtpy");
            return null;
        }

        return $orderLineProducts;
    }
}

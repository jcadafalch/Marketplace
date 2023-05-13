<?php

namespace App\Models;

use App\Models\Product;
use App\Models\OrderLine;
use App\Models\ProductOderLine;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductOderLine extends Model
{
    use HasFactory;

    public function orderLine(){
        return $this->belongsTo(OrderLine::class)->withTimeStamps();
    }

    public function product(){
        return $this->hasOne(Product::class)->withTimeStamps();
    }

    /**
     * Esta función añade un nuevo producto a una línea de pedido existente si dicho producto no existe en esa línea de pedido.
     * 
     * @param product El objeto producto que debe añadirse a la línea de pedido.
     * @param orderLineId ID de la línea de pedido a la que se añade el producto.
     */
    public static function AddProduct($product, $orderLineId){
        $productOrderLine = ProductOderLine::where("orderLine_id", $orderLineId)->where("product_id", $product->id)->first();

        if($productOrderLine == null){
            $newProductOrderLine = new ProductOderLine();
            $newProductOrderLine->orderLine_id = $orderLineId;
            $newProductOrderLine->product_id = $product->id;
            $newProductOrderLine->price = $product->price;
            $newProductOrderLine->save();

            Log::info("Se ha creado un nuevo productOrderLine: ", ['ProductOrderLine' => $newProductOrderLine]);
        }
    }

    public static function DeleteProduct($product, $orderLineId){
        Log::alert("llega");
        $productOrderLine = ProductOderLine::where("orderLine_id", $orderLineId)->where("product_id", $product->id)->first();

        Log::debug("ProductOrderLine de productOrderLineId :productOrderLineId, product order line :productOrderLine", ['productOrderLineId' => $orderLineId, 'productOrderLine' => $productOrderLine]);
        if($productOrderLine != null){
            $productOrderLine->delete();
            Log::info("Se ha eliminado el producto :productName (:productId) con productOrderLine id: :productOrderLineId, de la orderLine con id :orderLineId", 
            ['productName' => $product->name, 'productId' => $product->id, 'productOrderLineId' => $productOrderLine->id, 'orderLineId' => $orderLineId]);

            $orderLineProducts = ProductOderLine::all()->where("orderLine_id", $orderLineId);

            // Comrpobamos si la OrderLine tiene mas productos
            if($orderLineProducts->isEmpty() ){
                $orderLine = OrderLine::find($orderLineId);

                // Si no tiene más productos, eliminamos la orderLine
                if($orderLine != null){
                    Log::info("Se ha eliminado la orderLine con id :orderLineId ya que no tenia productos asignados", ['orderLineId' => $orderLine->id]);
                    $orderLine->delete();
                }
            }
        }
    }

    public static function getProductOfOrderLine($orderLineId)
    {
        $productOrderLine = ProductOderLine::where('orderLine_id', '=', $orderLineId)->get();

        Log::debug("productOrderLine: ", ['productOrderLine' => $productOrderLine]);
        
        if($productOrderLine == null){
            return null;
        }

        $productsIds = $productOrderLine->pluck('product_id');
        $productsIdsArray = $productsIds->toArray();

        $products = Product::whereIn('id', $productsIdsArray)->get();

        Log::debug('ProductOrderLine -> products = ', ['products' => $products]);

        return $products;

    }

    public static function setProductOfOrderLineAsSelled($orderLinesId)
    {
        $productOrderLine = ProductOderLine::whereIn('orderLine_id', '=', $orderLinesId)->get();

        if($productOrderLine == null)
        {
            return null;
        }

        $productsIds = $productOrderLine->pluck('product_id');
        $productsIdsArray = $productsIds->toArray();

        Product::whereIn('id', $productsIdsArray)->update([
            'isVisible' => 0,
            'selled_at' => time(),
        ]);

        return true;
            
    }
}

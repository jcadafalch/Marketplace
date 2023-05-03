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
        return $this->hasOne(Psroduct::class)->withTimeStamps();
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
}

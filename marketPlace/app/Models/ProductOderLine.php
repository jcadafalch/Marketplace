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
     * This function adds a new product to an existing order line if the product doesn't exist in those order line.
     * 
     * @param product The product object that needs to be added to the order line.
     * @param orderLineId The ID of the order line to which the product is being added.
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

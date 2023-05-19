<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryProduct extends Model
{
    use HasFactory;

    protected $table = 'category_product';

    protected $fillable = [
        'category_id',
        'product_id'
    ];

    public static function addCategoryToProduct($categoryName, $productId)
    {
        foreach ($categoryName as $key => $value) {

            $category_id = Category::where("name", $value)->first()->id;

            $categoryProduct = new CategoryProduct();
            $categoryProduct->category_id = $category_id;
            $categoryProduct->product_id = $productId;

            $categoryProduct->save();
        }
    }

    public static function updateCategoryProduct($request, $productId)
    {
        $currentCategoryProductsId = self::where("product_id", $productId)->pluck("category_id")->toArray();

        $currentCategoryNames = Category::whereIn("id", $currentCategoryProductsId)
            ->pluck("name")
            ->toArray();

        foreach ($request as $key => $value) {
            if (!in_array($value, $currentCategoryNames)) {
                $newCategoryProduct = new CategoryProduct();
                $newCategoryProduct->category_id = intval(Category::where("name", $value)->first()->id);
                $newCategoryProduct->product_id = $productId;
                $newCategoryProduct->save();
            }
        }

        foreach ($currentCategoryNames as $key => $value) {
            if (!in_array($value, $request)) {
                $delete = self::where("category_id", Category::where("name", $value)->first()->id);
                $delete->delete();
            }
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'url'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTimeStamps();
    }

    public static function getInfoFromId($id)
    {
        
        $products = array();
        foreach ($id as $key => $value) {
            array_push($products, Product::all()->where("id", $value));
        }
        return $products;
    }
}

<?php

namespace App\Models;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductImage extends Model
{
  use HasFactory;

  public function product(){
      return $this->belongsToMany(Product::class)->withTimeStamps();
    }

  public function image(){
      return $this->belongsTo(Image::class)->withTimeStamps();
  }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    public static function createImageModel($imageName, $imageUrl){
        
        $image = new Image();
        $image->name = $imageName;
        $image->url = $imageUrl;
        $image->save();

        return $image;
    }
}

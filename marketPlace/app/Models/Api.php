<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Api extends Model
{
    use HasFactory;
    
    private  $ApiUrl = "http://127.0.0.1:8000/api/";

    private $endpointCreateImage = "createImage";
    private $endpointDeleteImage = "deleteImage";
    private $endpointPushImage = "pushImage";
    private $endpointDeleteAllImageProduct = "deleteImageByProductName";
    private $endpointDeleteAllImageApi = "deleteAllImages";

    public static function createImage(){
    
    $url = $this->ApiUrl . $this->endpointCreateImage;
        
    }

    public static function deleteImage(){
    
    $url = $this->ApiUrl . $this->endpointDeleteImage;



    }

    public static function pushImage(){

    $url = $this->ApiUrl . $this->endpointPushImage;

    }

    public static function deleteAllImagesProduct(){
     
    $url = $this->ApiUrl . $this->endpointDeleteAllImageProduct;



    }

    public static function deleteAllImages(){

    $url = $this->ApiUrl . $this->endpointDeleteAllImageApi;

    


    }
}

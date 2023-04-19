<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    private  $response = [
        "status" => "",
        "msg" => ""
    ];

    public function getImage(Request $request){

        if($request->id == 1){
            $this->response["msg"] = "Cojo una imagen";
            $this->response["status"] = 200;
        }else{
            $this->response["msg"] = "Imagen no encontrada";
            $this->response["status"] = 404 . " Not Found";
        }
      
        return response()->json($this->response);
    }

    public function getAllImage(Request $request){
        
        $this->response["msg"] = "Cojo todas las imagenes";
        $this->response["status"] = 200;
        return response()->json($this->response);
    }

    public function createImage(Request $request){
        
        $this->response["msg"] = "Creo una imagen";
        $this->response["status"] = 200;
        return response()->json($this->response);
        /* V1 
        header("Content-Type: image/png");
        $im = @imagecreate(110, 20)
        or die("Cannot Initialize new GD image stream");
        $background_color = imagecolorallocate($im, 0, 0, 0);
        $text_color = imagecolorallocate($im, 233, 14, 91);
        imagestring($im, 1, 5, 5,  "A Simple Text String", $text_color);
        imagepng($im);
        return $im;
        imagedestroy($im);*/
        /* V2
        // Create the size of image or blank image
        $image = imagecreate(500, 300);
  
        // Set the vertices of polygon
        $values = array(
            50,  50,  // Point 1 (x, y)
            50, 250,  // Point 2 (x, y)
            250, 50,  // Point 3 (x, y)
            250,  250 // Point 3 (x, y)
        );
        // Set the background color of image
        $background_color = imagecolorallocate($image,  0, 153, 0);
     
        // Fill background with above selected color
        imagefill($image, 0, 0, $background_color);
   
        // Allocate a color for the polygon
        $image_color = imagecolorallocate($image, 255, 255, 255);
     
        // Draw the polygon
        imagepolygon($image, $values, 4, $image_color);
     
        // Output the picture to the browser
        header('Content-type: image/png');
        $filaName = "prueba";
        imagepng($image);*/
    }

    public function deleteImage(Request $request){
        if($request->id == 1){
            $this->response["msg"] = "Imagen Borrada";
            $this->response["status"] = 200; 
        }else{
            $this->response["msg"] = "Imagen no encontrada";
            $this->response["status"] = 404 . " Not Found";
        }
      
        return response()->json($this->response);
    }

    public function deleteImageByProductId(Request $request){
        
        if($request->id == 1){
            $this->response["msg"] = "Borro todas las imagenes por un id de producto";
            $this->response["status"] = 200; 
        }else{
            $this->response["msg"] = "Producto no encontrada";
            $this->response["status"] = 404 . " Not Found";
        }
       
        return response()->json($this->response);
    }

    public function pushImage(Request $request){
        $this->response["msg"] = "Subo una imagen";
        $this->response["status"] = 200; 

        return response()->json($this->response);
    }
}

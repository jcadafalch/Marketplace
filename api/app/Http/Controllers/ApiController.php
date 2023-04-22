<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
    private  $response = [
        "status" => "",
        "msg" => "",
        "filename" => ""
    ];

    private $urlImage = "http://127.0.0.1:8000/storage/img/";
    public function getImage(Request $request){
    Log::error("posar log ");
       try {
            $file = Storage::disk('img')->get($request->name);
            self::generateResponse("Cojo una imagen",200, $file);
       } catch (\Throwable $th) {
            self::generateResponse("Imagen no encontrada", 404 . " Not Found", $request->name);
       }
        return response()->json($this->response);
    }

    public function getAllImage(Request $request){
        Log::error("posar log ");
        try {
            $allFiles =  Storage::disk('img')->allFiles();
            self::generateResponse("Return all Files", 200, $allFiles);
        } catch (\Throwable $th) {
            self::generateResponse("failed to obtain all images", 500, "Contact technical service");
        }
        return response()->json($this->response);
    }

    public function createImage(Request $request){
        Log::error("posar log ");
        try {
            $fileName =  $request->ContextName;
            $image = imagecreate(500, 300);
            // Set the background color of image
            $background_color = self::generateColors($image);
        
            // Fill background with above selected color
            imagefill($image, 0, 0, $background_color);
            
            self::createPolygon($image);
            self::generateText($image, $fileName);
        
            $photoName = self::saveImageToStorage($image);
            imagedestroy($image);
            self::generateResponse("Image create successful", 200, $photoName);

        } catch (Throwable $th) {
            self::generateResponse("Faild to create image", 500, $request->name);
        }

       return response()->json($this->response);
    }

    public function deleteImage(Request $request){
        Log::error("posar log ");
        try{
          
            Storage::disk('img')->delete($request->name);
            self::generateResponse( "Imagen Borrada", 200, $request->name);
        }catch (Throwable $th) {
            self::generateResponse("Imagen no encontrada", 404 . " Not Found", $request->name);
        }
      
        return response()->json($this->response);
    }

    public function deleteImageByProductName(Request $request){
        Log::error($request->all());

        // recibir todas $request->all();
        try {
            self::generateResponse("Borro todas las imagenes por un id de producto", 200, $request);
            Storage::disk('img')->delete($request->name);

        } catch (\Throwable $th) {
            self::generateResponse("Producto no encontrada", 404 . " Not Found", $request);
        }
           
        return response()->json($this->response);
    }

    public function pushImage(Request $request){

        self::generateResponse("Subo una imagen", 200, "");
        return response()->json($this->response);
    }


    /**
     * This PHP function generates a random RGB color and returns it as a background color for an
     * image.
     * 
     * @param image The  parameter is a reference to an image resource created using a function
     * like imagecreatetruecolor() or imagecreatefromjpeg(). This function generates a random RGB color
     * and returns it as a background color for the image.
     * 
     * @return a background color for an image, which is created using the `imagecolorallocate()`
     * function in PHP. The background color is generated randomly using three integers between 0 and
     * 255, which represent the red, green, and blue color values.
     */
    public function generateColors($image){
          
          $color1 = random_int( 0, 255);
          $color2 = random_int( 0, 255);
          $color3 = random_int( 0, 255);

       return $background_color = imagecolorallocate($image, $color1, $color2, $color3);
    }

    
    public function generateText($image, $fileName){
        $font = 'arial.ttf';
        $black = imagecolorallocate($image, 0, 0, 0);
        imagettftext($image, 20, 0, 200, 170, $black, $font, $fileName);
    }


    public function createPolygon($image){
        $values = array(
            50,  50,  // Point 1 (x, y)
            50, 250,  // Point 2 (x, y)
            250, 50,  // Point 3 (x, y)
            250,  250 // Point 3 (x, y)
        );

        $image_color = imagecolorallocate($image, 255, 255, 255);
        imagepolygon($image, $values, 4, $image_color);   
    }

    public function saveImageToStorage($image){
        $RandomNum = uniqid();
        $path = "storage/img/" . $RandomNum . ".png";
        imagepng($image,$path);
        return "http://127.0.0.1:8000/storage/img/" .  $RandomNum  . ".png";
    }

    public function generateResponse($mensaje, $status, $filename){
        $this->response["msg"] = $mensaje;
        $this->response["status"] = $status;
        $this->response["filename"] = $filename;
    }           
}

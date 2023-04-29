<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ApiController extends Controller
{
    private  $response = [
        "status" => "",
        "msg" => "",
        "filename" => ""
    ];

    private $urlImage = "storage/img/";

    public function getImage(Request $request){
    Log::error("agafar un imatge");
    
       try {
            //$file = Storage::disk('img')->get($request->name);
            //$file = $file != null ? $file : "Imagen no encontrada"; 

            $allFiles =  Storage::disk('img')->allFiles();
            if(count($allFiles) > 0){
                for ($i=0; $i < count($allFiles); $i++) { 
                    if($allFiles[$i] == $request->name ){
                     self::generateResponse("Cojo una imagen",200, $allFiles[$i]);
                     break;
                    }else{
                     self::generateResponse("Imagen no encontrada", 404 . " Not Found", $request->name);
                    }
                 }

            }else{
                self::generateResponse("No hay imagenes en la api", 500 . " Not Found", "Por favor genera alguna");
            }
       } catch (\Throwable $th) {
            self::generateResponse("Imagen no encontrada", 404 . " Not Found", $request->name);
       }
        return response()->json($this->response);
    }

    public function getAllImage(Request $request){
        Log::error("Agafar totes les imatges");
        try {
            $allFiles =  Storage::disk('img')->allFiles();

            if(count($allFiles) > 0){
                self::generateResponse("Return all Files", 200, $allFiles);
            }else{
                self::generateResponse("No hay imagenes en la api", 404 . " Not Found", "Por favor genera alguna");
            }          
        } catch (\Throwable $th) {
            self::generateResponse("failed to obtain all images", 500, "Contact technical service");
        }
        return response()->json($this->response);
    }

    public function createImage(Request $request){
        Log::error("Imagen creada");
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
        Log::error("imagen borrada" . $request->name);
        try{      

            Storage::disk('img')->delete($request->name);
            //Log::error(Storage::disk('img')->exists($request->name));
            self::generateResponse( "Imagen Borrada", 200, $request->name);
        }catch (Throwable $th) {
            self::generateResponse("Imagen no encontrada", 404 . " Not Found", $request->name);
        }
      
        return response()->json($this->response);
    }

    public function deleteImageByProductName(Request $request){
        Log::error("Imagenes de un producto borradas");
        try {
            $allImages = $request->all();

            for ($i=0; $i < count($allImages); $i++) { 
                Log::error("imagen eliminada:" . $allImages[$i]);
                Storage::disk('img')->delete($allImages[$i]);
            }
            self::generateResponse("imagenes de un producto borradas", 200, $allImages);
        } catch (\Throwable $th) {
            self::generateResponse("Producto no encontrada", 404 . " Not Found", $allImages);
        }
           
        return response()->json($this->response);
    }

    public function deleteAllImages(){
        Log::error("Se han borrado todas las imagenes");
            try {
                $allFiles =  Storage::disk('img')->allFiles();
                for ($i=0; $i < count($allFiles) ; $i++) { 
                    Storage::disk('img')->delete($allFiles[$i]);  
                }
                self::generateResponse("Imagenes borradas correctamente", 200, "");
            } catch (\Throwable $th) {
                self::generateResponse("Fallo al borrar las imagenes", 500 , "");
            }

            return response()->json($this->response);
    }

    public function pushImage(Request $request){
        /*$request->validate([
            'image' => 'required|image|mimes:png,jpg,gif,svg|max:2048',
        ]);*/
        $urlServer = "http://" . $_SERVER['HTTP_HOST'] . "/";
        try {
            Log::error("Imagen subida");
            
            $RandomNameImage = uniqid() . "." . $request["imagen"]->extension();        
            $path = $this->urlImage . $RandomNameImage;
            Storage::disk('img')->put($RandomNameImage ,$request["imagen"]->get());
            Log::error("Imatge pujada al servidor at:");
            self::generateResponse("Subo una imagen", 200,  $urlServer .  $path);
        } catch (\Throwable $th) {
            self::generateResponse("Fallo al subir la imagen", 200, "Suba otra vez la imagen");
        }
      
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
        $urlServer = "http://" . $_SERVER['HTTP_HOST'] . "/";
        $RandomNameImage = uniqid() . ".png";
        $path = $this->urlImage . $RandomNameImage;
       
        imagepng($image,$path);
        
        return $urlServer . $this->urlImage .  $RandomNameImage;
    }

    public function generateResponse($mensaje, $status, $filename){
        $this->response["msg"] = $mensaje;
        $this->response["status"] = $status;
        $this->response["filename"] = $filename;
    }           
}

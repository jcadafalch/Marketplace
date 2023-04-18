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

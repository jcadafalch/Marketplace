<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Api extends Model
{
    use HasFactory;

    public  $ApiUrl = "http://127.0.0.1:8000/api/";

    private $endpointCreateImage = "createImage";
    private $endpointDeleteImage = "deleteImage";
    private $endpointPushImage = "pushImage";
    private $endpointDeleteAllImageProduct = "deleteImageByProductName";
    private $endpointDeleteAllImageApi = "deleteAllImages";

    // Funciona
    public function createImage($ImageName)
    {
       
        $url = $this->ApiUrl . $this->endpointCreateImage;

        $response = Http::withToken(env('API_TOKEN'))
        ->get($url, ['ContextName' => $ImageName]);


        if ($response->ok()) {

            return $response['filename'];
        } else {
            return $response->json();;
        }
    }

     // Funciona
    public function deleteImage($ImageName)
    {

        $url = $this->ApiUrl . $this->endpointDeleteImage;
        $response = Http::withToken(env('API_TOKEN'))
            ->delete($url, ['name' => $ImageName]);

        if ($response->ok()) {

            return $response->json();
        } else {
            return $response->json();;
        }
    }

    public function pushImage($imageContent)
    {

        $url = $this->ApiUrl . $this->endpointPushImage;

        $response = Http::withToken(env('API_TOKEN'))
            ->withHeaders([
                'Content-Type' => 'image/png',
            ])
            ->attach('imagen', $imageContent, 'image')
            ->post($url);


        if ($response->ok()) {

            return $response->json();
        } else {
            return $response->json();;
        }
    }

    // Funciona
    public function deleteAllImagesProduct($productsID)
    {
        $url = $this->ApiUrl . $this->endpointDeleteAllImageProduct;

        $products =[
            0 => "645a7c4de3bd8.png",
            1 => "645a7c4ed6328.png",
            2 => "645a7c8780996.png",
            3 => "645a78d4cb2fc.png"
        ];



        $response = Http::withToken(env('API_TOKEN'))
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->withBody(json_encode($products), 'application/json')
            ->delete($url);

        if ($response->ok()) {
            return $response->json();
        } else {
            return $response->json();
        }
    }

     // Funciona
    public function deleteAllImages()
    {

        $url = $this->ApiUrl . $this->endpointDeleteAllImageApi;

        $response = Http::withToken(env('API_TOKEN'))->delete($url);

        if ($response->ok()) {
           return $response->json();

        } else {
            return $response->json();
        }
        }
}

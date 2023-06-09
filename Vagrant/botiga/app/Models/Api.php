<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Api extends Model
{
    use HasFactory;

    private $endpointCreateImage = "createImage";
    private $endpointDeleteImage = "deleteImage";
    private $endpointPushImage = "pushImage";
    private $endpointDeleteAllImageProduct = "deleteImageByProductName";
    private $endpointDeleteAllImageApi = "deleteAllImages";

   
    public function createImage($ImageName)
    {
       
        $url = env('API_URL') . $this->endpointCreateImage;

        $response = Http::withoutVerifying()
        ->withToken(env('API_TOKEN'))
        ->get($url, ['ContextName' => $ImageName]);


        if ($response->ok()) {

            return $response['filename'];
        } else {
            return $response->json();;
        }
    }


    public function deleteImage($ImageName)
    {

        $url = env('API_URL') . $this->endpointDeleteImage;

        $response = Http::withoutVerifying()
        ->withToken(env('API_TOKEN'))
            ->delete($url, ['name' => $ImageName]);

        if ($response->ok()) {

            return $response->json();
        } else {
            return $response->json();;
        }
    }

    public function pushImage($imageContent)
    {

        $url = env('API_URL') . $this->endpointPushImage;

        $file = $imageContent;
        
        $extension = $file->getClientOriginalExtension();
      
        $img = 'temporarlImage' . Auth::user()->id . '.' .  $extension;
       
        $file->storeAs('public/img/', $img);

        $photo_path = 'storage/img/'. $img;
    
        $response = Http::withoutVerifying()
        ->withToken(env('API_TOKEN'))->attach('imagen', file_get_contents($photo_path), basename($photo_path))->post($url);
        Storage::disk('img')->delete($img);
        $urlPhoto = $response->json();
        
        return $response['filename'];
    }

    public function deleteAllImagesProduct($productsID)
    {
        $url = env('API_URL') . $this->endpointDeleteAllImageProduct;


        $response = Http::withoutVerifying()
        ->withToken(env('API_TOKEN'))
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->withBody(json_encode($productsID), 'application/json')
            ->delete($url);

        if ($response->ok()) {
            return $response->json();
        } else {
            return $response->json();
        }
    }

    public function deleteAllImages()
    {

        $url = env('API_URL') . $this->endpointDeleteAllImageApi;

        $response = Http::withoutVerifying()
        ->withToken(env('API_TOKEN'))->delete($url);

        if ($response->ok()) {
           return $response->json();

        } else {
            return $response->json();
        }
        }
}

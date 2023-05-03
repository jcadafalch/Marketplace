<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop>
 */
class ShopFactory extends Factory
{
  
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {   
        $allUsersId = User::count();
        $userId = rand(1, $allUsersId - 1);

        $allImageId = Image::count();
        $imageId = rand(1, $allImageId);

        $num = uniqid();
        $url = fake()->imageUrl(640, 480, 'animals', true);
        $contents = file_get_contents($url);
        $name = "imgN" . $num .".jpg";
        Storage::disk('img')->put($name, $contents);
        $id = rand(1, 300);
        
        return [
            'ownerName'=>fake()->unique()->name($gender = 'female'),
            'name'=>fake()->unique()->company(),
            'nif'=>fake()->unique()->postcode(),
            'user_id'=> $userId,
            'logo_id'=> $imageId,
        ];
    }
}

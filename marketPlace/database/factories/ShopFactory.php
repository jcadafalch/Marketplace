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

        
        return [
            'ownerName'=>fake()->unique()->name($gender = 'female'),
            'name'=>fake()->unique()->company(),
            'nif'=>fake()->unique()->postcode(),
            'user_id'=> $userId,
            'logo_id'=> $imageId,
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\User;
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
        $userId = rand(1, $allUsersId);
        
        return [
            'name'=>fake()->unique()->name($gender = 'female'),
            'shop_name'=>fake()->unique()->company(),
            'nif'=>fake()->unique()->postcode(),
            'user_id'=> $userId,
        ];
    }
}

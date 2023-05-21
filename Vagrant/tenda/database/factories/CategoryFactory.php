<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=>fake()->unique()->word(),
        ];
    }
    
    public function level2(): Factory
    {
        return $this->state(function (array $attributes) {
            $numCategores = Category::count();
            $paraentId = rand(1, $numCategores);

            return [
                'name' => fake()->unique()->word(),
                'parent_id'=> $paraentId,
            ];
   

        });
    }
}

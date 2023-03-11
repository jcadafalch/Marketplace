<?php

namespace Database\Factories;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $num = uniqid();
        $url = "https://api.lorem.space/image/movie?w=150&h=220";
        $contents = file_get_contents($url);
        $name = "imgN" . $num .".jpg";
        Storage::disk('img')->put($name, $contents);
        return [
            'name'=>fake()->unique()->word(),
            'description'=>fake()->unique()->paragraph(1,true),
            'price'=>fake()->randomFloat(2,0,999),
            'url'=>  $name,
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Api;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $api = New Api(); 
        
        return [
            'name'=> fake()->unique()->city(),
            'url'=>  $api->createImage(fake()->unique()->name()),
        ];
    }
}

<?php

namespace Database\Factories;

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
        $num = uniqid();
        $url = fake()->imageUrl(640, 480, 'animals', true);
        $contents = file_get_contents($url);
        $name = "imgN" . $num .".jpg";
        Storage::disk('img')->put($name, $contents);

        return [
            'name'=> fake()->unique()->city(),
            'url'=>  $name,
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Shop;
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
        $url = fake()->imageUrl(640, 480, 'animals', true);
        $contents = file_get_contents($url);
        $name = "imgN" . $num .".jpg";
        Storage::disk('img')->put($name, $contents);

        $allShopId = Shop::count();
        $shopId = rand(2, $allShopId);
        return [
            'name'=>fake()->unique()->name(),
            'description'=>fake()->unique()->realText(60,1),
            'price'=>fake()->randomFloat(2,0,999),
            'url'=> $name,
            'shop_id'=> $shopId,
        ];
    }
}

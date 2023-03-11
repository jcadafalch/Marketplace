<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void

    { 
    // Variables de control 
    $numProducts = 20;
    $numCategories = 20;
    
    
    self::generateProducts($numProducts);
    $this->command->info('Taula productes inicialitzada amb èxit');   
    self::generateCategories($numCategories);
    $this->command->info('Taula categories inicialitzada amb èxit');
    self::attachProductCategories();
    $this->command->info('Taula del mitg inicialitzada amb èxit');
    }

    /**
     * Funcio per generar Productes
     */
    private static function generateProducts($numProducts){
        $allProducts = Product::all();
       
        foreach ($allProducts as $p) {
            Storage::disk('img')->delete($p->url);
        }

        DB::table('products')->delete();
        Product::factory($numProducts)->create();
    }

    /**
     * Funcio per generaer Categories
     */
    private static function generateCategories($numCategories){
        DB::table('categories')->delete();
        
        $Categoris = [
            1 => [
                'name' => 'Moda',
            ],
            2 => [
                'name' => 'Accesoris',
            ],
            3 => [
                'name' => 'Fornitures',
            ],
            4 => [
                'name' => 'Toys',
            ],
            5 => [
                'name' => 'Art',
            ],
        ];

        Category::factory($numCategories)->create();

        // Proves per inserta categories a mà
        /*foreach ($Categoris as $c) {
            $category = new Category();
            $category->name = $c['name'];
            $category->save();
        }*/
    }

    /**
     * Funcio per fer atach amb producte categoria
     */
    private static function attachProductCategories(){
        DB::table('category_product')->delete();

        $allProducts = Category::all();
        $numCategores = Category::count();

        foreach ($allProducts as $p) {
            $randomCategory = rand(1, $numCategores);
            $p->products()->attach(Category::find($randomCategory));
        }
    }
}

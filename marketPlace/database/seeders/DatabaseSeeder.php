<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    public function run(): void
    { 
    // Productes a generar    
    $numProducts = 20;
    // Categories a generar
    $numCategories = 20;
    
    
    self::generateProducts($numProducts);
    $this->command->info('Taula productes inicialitzada amb èxit');   
    self::generateCategories($numCategories);
    $this->command->info('Taula categories inicialitzada amb èxit');
    self::attachProductCategories();
    $this->command->info('Taula del mitg inicialitzada amb èxit');
    }

    private static function generateProducts($numProducts){
        // Eliminem les dades de la taula 
        DB::table('products')->delete();

         // Creem 5 productes aleatoris 
         Product::factory($numProducts)->create();
    }

    private static function generateCategories($numCategories){
        // Eliminem les dades de la taula 
        DB::table('categories')->delete();
        
        // Array de categories
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
            4 =>[
                'name' => 'Toys',
            ],
            5 =>[
                'name' => 'Art',
            ],
        ];
        
        // Creem 5 categories aleatoris
        Category::factory($numCategories)->create();
        
        // Proves per inserta categories a mà
        /*foreach ($Categoris as $c) {
            $category = new Category();
            $category->name = $c['name'];
            $category->save();
        }*/
    }

    private static function attachProductCategories(){
        // Eliminem les dades de la taula 
        DB::table('category_product')->delete();
        
        // Agafem tots el productes que hem creat
        $allProducts = Category::all();
        $numCategores = Category::count();
        
        foreach ($allProducts as $p) {
        $randomCategory = rand(1, $numCategores);
        // Fem la unio
         $p->products()->attach(Category::find($randomCategory));
        }
    }
}

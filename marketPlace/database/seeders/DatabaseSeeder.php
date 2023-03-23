<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    { 
    if ($this->command->confirm('Vols reiniciar la bdd?', true)) {
        self::clearImages();
        $this->command->call('migrate:Rollback');
        $this->command->call('migrate');
    }
    if ($this->command->confirm('Vols recrear un entorn per proves unitaries', false)) {
        $numProducts = $this->command->ask('Quantes productes vols generar?');
        $numCategories = $this->command->ask('Quants categories vols generar?');
        
        self::generateProducts($numProducts);
        $this->command->info('Taula productes inicialitzada amb èxit');   
        self::generateCategoriesEntornDeProves($numCategories);
        $this->command->info('Taula categories inicialitzada amb èxit');
        self::attachProductCategories();
        $this->command->info('Taula del mitg inicialitzada amb èxit');
    }
    if ($this->command->confirm('Vols recrear el Fakers?', true)) {
        $productCategories = $this->command->ask('Quantes categories ha de tenir un producte?');
        $numProducts = $this->command->ask('Quantes productes vols generar?');
        $numCategories = $this->command->ask('Quants categories vols generar?');;
        
        self::generateProducts($numProducts);
        $this->command->info('Taula productes inicialitzada amb èxit');   
        self::generateCategories($numCategories);
        $this->command->info('Taula categories inicialitzada amb èxit');
        self::attachProductCategories( $productCategories);
        $this->command->info('Taula del mitg inicialitzada amb èxit');
    }
   
    
    }

    /**
     * Funcio per generar Productes
     */
    private static function generateProducts($numProducts){
        Product::factory($numProducts)->create();
    }
    
    private static function clearImages(){   
        $allProducts = Product::all();

        foreach ($allProducts as $p) {
            Storage::disk('img')->delete($p->url);
        }
    }
    
    /**
    * Funcio per generaer Categories
    */
    private static function generateCategoriesEntornDeProves($numCategories){
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
    // Proves per inserta categories a mà
        foreach ($Categoris as $c) {
            $category = new Category();
            $category->name = $c['name'];
            $category->save();
        }
    }
    private static function attachProductCategoriesEntornDeProves(){
        DB::table('category_product')->delete();

        $allProducts = Category::all();
        $numCategores = Category::count();

        foreach ($allProducts as $p) {
            $p->products()->attach(Category::find($p->id));
        }
    }



    /**
     * Funcio per generaer Categories
     */
    private static function generateCategories($numCategories){
        DB::table('categories')->delete();
        Category::factory($numCategories)->create();
    }

    /**
     * Funcio per fer atach amb producte categoria
     */
    private static function attachProductCategories($productCategories){
        DB::table('category_product')->delete();

        $allProducts = Product::all();
        $numCategores = Category::count();


        
       foreach ($allProducts as $p) {
        $array = [];
            for ($i=0; $i < $productCategories ; $i++) { 
             $randomCategory = rand(1, $numCategores);
             array_push($array,$randomCategory);            
            }  
            for ($e=0; $e < sizeof($array); $e++) { 
                $p->categories()->attach($array[$e]);
            } 
        }
    }
}

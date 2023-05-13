<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Api;
use App\Models\Shop;
use App\Models\User;
use App\Models\Image;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;

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

        $numUsers = $this->command->ask('Quant usuaris vols crear?');
        self::createUsers($numUsers);
        $numImages = $this->command->ask('Quantes imatges vols generar');
        $numShops = $this->command->ask('Quantes tendes vols crear??');
        $productCategories = $this->command->ask('Quantes categories ha de tenir un producte?');
        $numProductImages = $this->command->ask('Quantes imatges ha de tenir un producte?');
        $numProducts = $this->command->ask('Quants productes vols generar?');
        $numCategories = $this->command->ask('Quants categories vols generar?');
        $numCategories2nivell = $this->command->ask('Quants categories de segon nivell vols generar?');
        $numSubCategories = $this->command->ask('Quants subcategories ha de tenir una cetegoria?');
        
        
        self::createImages($numImages);
        $this->command->info($numImages . " Imatges creades."); 
        self::createUsersTest();
        $this->command->info('Usuaris de test creats'); 
        self::createShops($numShops);
        $this->command->info($numShops . ' de tendes creades.');   
        self::generateProducts($numProducts);
        $this->command->info('Taula productes inicialitzada amb èxit');
        self::attachImageProduct($numProductImages);
        $this->command->info($numProductImages . " Producte amb imatges enllaçat.");    
        self::generateCategories($numCategories, $numSubCategories);
        $this->command->info('Taula categories inicialitzada amb èxit');
        self::categoriesSegonNivell($numCategories2nivell);
        $this->command->info('Categories de level 2 inicialitzades amb èxit'); 
        self::attachProductCategories($productCategories);
        $this->command->info('Taula del mitg inicialitzada amb èxit');
    }
    
    
    }



    private static function createUsersTest(){
        User::factory()->create([
            'name' => "comprador",
            'path' => "storage/app/public/img/imgN640cc8af60f70.jpg",
            'email' => "comprador@test.com",
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'remember_token' => Str::random(10),
        ]);

        User::factory()->create([
            "id" => 999,
            'name' => "venedor",
            'path' => "storage/app/public/img/imgN640cc8af60f70.jpg",
            'email' => "venedor@test.com",
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'remember_token' => Str::random(10),
        ]);

        $allImageId = Image::count();
        $imageId = rand(1, $allImageId);

        Shop::factory()->create([
            'ownerName'=>'venedor',
            'name'=>fake()->unique()->company(),
            'nif'=>fake()->unique()->postcode(),
            'user_id'=> 999,
            'logo_id'=> $imageId,
        ]);


    }

    /**
    * Funcio per generar Usuaris
    */
    private static function createUsers($numUsers){
        User::factory()->create([
            'name' => "User Test",
            'path' => "storage/app/public/img/imgN640cc8af60f70.jpg",
            'email' => "usertest@test.com",
            'email_verified_at' => now(),
            'password' => Hash::make('1234'),
            'remember_token' => Str::random(10),
        ]);
        User::factory($numUsers)->create();
    }


    private static function createImages($numImages){
        Image::factory($numImages)->create();
    }
    
    /**
    * Funcio per generar Tendes
    */
    private static function createShops($numShops){
        Shop::factory($numShops)->create();
    }
    
    /**
     * Funcio per generar Productes
     */
    private static function generateProducts($numProducts){
        Product::factory($numProducts)->create();
    }
    
    private static function clearImages(){   
        $api = new Api();
        $api->deleteAllImages();
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

    /**
     * Funcio per unificar Productes amb Categories
     */
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
    private static function generateCategories($numCategories, $numSubCategories){
        DB::table('categories')->delete();
        Category::factory($numCategories)->create();
        $allCategories = Category::all();
        $numCategores = Category::count();
        $paraentId = rand(1, $numCategores);
    }
    
    /**
     * Funcio per crear categories de nivell 2
     */
    public function categoriesSegonNivell($numCategories2nivell){
        Category::factory($numCategories2nivell)->level2()->create();
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

    private static function attachImageProduct($numProductImages){

        DB::table('product_images')->delete();

        $allProducts = Product::all();
        $allImages = Image::all();
        
        foreach ($allProducts as $p) {
            $allImages = $allImages->shuffle();
            for ($i=0; $i < $numProductImages; $i++) { 
            ProductImage::factory()->create([
                    'isMain' => $i == 0,
                    'product_id' => $p->id,
                    'image_id' => $allImages[$i]->id
            ]);
            //$p->images()->attach($allImages[$i]->id); 
           }
        }


    }
}


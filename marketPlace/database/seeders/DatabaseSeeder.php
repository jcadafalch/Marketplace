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
        $numProducts = $this->command->ask('Quantes productes vols generar per cada tenda?', 20);
        $numCategories = $this->command->ask('Quants categories vols generar?', 10);
        
        self::generateProductsForShop($numProducts);
        $this->command->info('Taula productes inicialitzada amb èxit');   
        self::generateCategoriesEntornDeProves($numCategories);
        $this->command->info('Taula categories inicialitzada amb èxit');
        self::attachProductCategories();
        $this->command->info('Taula del mitg inicialitzada amb èxit');
    }
    if ($this->command->confirm('Vols recrear el Fakers?', true)) {

        $numUsers = $this->command->ask('Quant usuaris vols crear?', 5);
        self::createUsers($numUsers);
        $numImages = $this->command->ask('Quantes imatges vols generar', 100);
        $numShops = $this->command->ask('Quantes tendes vols crear?', 5);
        $productCategories = $this->command->ask('Quantes categories ha de tenir un producte?', 5);
        $numProductImages = $this->command->ask('Quantes imatges ha de tenir un producte?', 5);
        $numProducts = $this->command->ask('Quants productes vols per cada tenda generar?', 50);
        $numCategories = $this->command->ask('Quants categories vols generar?', 50);
        $numCategories2nivell = $this->command->ask('Quants categories de segon nivell vols generar?', 25);
        $numSubCategories = $this->command->ask('Quants subcategories ha de tenir una cetegoria?', 4);
        
        
        self::createImages($numImages);
        $this->command->info($numImages . " Imatges creades."); 
        self::createUsersTest();
        $this->command->info('Usuaris de test creats'); 
        self::createShops($numShops);
        $this->command->info($numShops . ' de tendes creades.');   
        self::generateProductsForShop($numProducts);
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
            "id" => 998,
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


        Shop::factory()->create([
            'ownerName'=>'venedor',
            'name'=> 'venedor',
            'nif'=>fake()->unique()->postcode(),
            'user_id'=> 999,
            'logo_id'=> null,
        ]);


    }

    /**
    * Funcio per generar Usuaris
    */
    private static function createUsers($numUsers){
        User::factory($numUsers)->create();
    }


    private static function createImages($numImages){
        Image::factory($numImages)->create();
    }
    
    /**
    * Funcio per generar Tendes
    */
    private static function createShops($numShops){
        $total =  intval($numShops);
        $idUser = 0;
        $numUser = User::count() -2;
        for ($i=0; $i < $total; $i++) {
            $idUser ++; 
            Log::debug($idUser);
              
            if($idUser <= $numUser){
                $shop =  Shop::factory()->create();
                $shop->user_id = $idUser; 
                $shop->save(); 
            }else{
                $shop =  Shop::factory()->create();
                $shop->user_id = 1; 
                $shop->save();   
            }
        }
    }

    /**
     * Funcio per generar Productes
     */
    private static function generateProductsForShop($numProducts){

        $shops =  Shop::all();
       
        foreach ($shops as  $shop) {
            $order = 0;
            for ($i=0; $i < $numProducts ; $i++) { 
              $order ++;
              $product =  Product::factory()->create();
              $product->shop_id =  $shop->id;
              $product->order = $order;
              $product->save();
            }
        }
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


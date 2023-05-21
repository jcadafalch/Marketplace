<?php

namespace Tests\Feature;


use Tests\TestCase;
use App\Models\Shop;
use App\Models\User;
use App\Models\Image;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class HomeTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
   
    public function testGetAllCategories(){
        $this->createDummyAllProduct();
        $request = [
            'search' => '',
            'order' => ''                   
        ];
        $actual = Product::searchByName($request);

        $this->assertSameSize([1,2,3,4,5], $actual);
    }
   
    public function testGetOneCategory(){
        $this->createDummyAllProduct();
        $p = new Product();
        $p->id = '1';
        $p->name = 'voluptas';
        $p->price = 29.01;
        $p->url = 'http://127.0.0.1:8000/storage/img/imgN6411ef20a3f31.jpg';
    
        $expected = $p->name;
       
        $request = [
            'search' => '',
            'category' => 2,
            'order' => '' ,
        ];
        $search = Product::searchByAll($request);
        $actual = $search;
      
        $this->assertEquals($expected, $actual[0]->name);
    }
      
    public function testGetAllCategoriesWithFilterByName(){
        $this->createDummyAllProduct();
        $request = [
            'search' => 'dolores',
            'order' => '' 
        ];
        $actual = Product::searchByName($request);
        
        $p = new Product();
        $p->id = 5;
        $p->name = "dolores";
        $p->price = 739.06;
        $p->url = 'http://127.0.0.1:8000/storage/img/imgN6411ef220da04.jpg';
        $expected = $p->name;

        $this->assertEquals($expected, $actual[0]->name);
    }
    
    public function testGetOneCategoryWithFilterByName(){
        $this->createDummyAllProduct();
        $request = [
            'search' => 'laboriosam',
            'category' => 3,
            'order' => '' 
        ];

        $actual = Product::searchByAll($request);
        $p = new Product();
        $p->id = 3;
        $p->name = 'laboriosam';
        $p->price = 139.13;
        $p->url = 'http://127.0.0.1:8000/storage/img/imgN6411ef225c065.jpg';
        $expected = $p->name;
        
        $this->assertEquals($expected, $actual[0]->name);
    }

    public function testGetNotFoundProductByNameNotExist(){
        $this->createDummyAllProduct();

        
        $response = $this->call('GET', '/searchProduct', ['search' => '12312312414','category' =>3,]);
        $response->assertSeeText('productoNoEncontrado');
    }

    public function testGetNotFoundProductByCategoryNotExist(){
        $this->createDummyAllProduct();


        $response =  $this->call('GET', '/searchProduct', ['search' => '','category' => 13123132]);
        $response->assertSeeText('productoNoEncontrado');
    }

    public function testGetProductByNameWithAccent(){
        $this->createDummyAllProduct();
        

        $response =  $this->call('GET', '/searchProduct', ['category' => 'allCategories','search' => 'quàé', 'order' => 'DESC']);
        $response->assertSeeText('quàé');
    }

    public function testGetAllProductOrderByAsc(){
        $this->createDummyAllProduct();

        $request = [
            'search' => '',
            'category' => '',
            'order' => 'ASC' 
        ];

        $actual = Product::searchByAll($request);
        $p = new Product();
        $p->id = 5;
        $p->name = 'dolores';
        $p->price = 739.06;
        $p->url = 'http://127.0.0.1:8000/storage/img/imgN6411ef225c065.jpg';
        $expected = $p->name;
       
        $this->assertEquals($expected, $actual[4]->name);
    }

    public function testGetAllProductOrderByDesc(){
        $this->createDummyAllProduct();

        $request = [
            'search' => '',
            'category' => '',
            'order' => 'DESC' 
        ];

        $actual = Product::searchByAll($request);
        $p = new Product();
        $p->id = 5;
        $p->name = 'voluptas';
        $p->price = 739.06;
        $p->url = 'http://127.0.0.1:8000/storage/img/imgN6411ef225c065.jpg';
        $expected = $p->name;
       
        $this->assertEquals($expected, $actual[1]->name);
    }

    private function createDummyAllProduct() {

        $Products =  [
            1 => [
                'name' => 'quàé',
                'id' => '1',
                'price' => 222,
                'description' => 'Quod cumque earum ut quia ex incidunt possimus.',
                'isMain' => true
            ],
            2 => [
                'name' => 'voluptas',
                'id' => '2',
                'price' => 696,
                'description' => 'Enim officiis illo vero ea consequatur veniam et dolorem. Asperiores ea reiciendis dolor a reiciendis.',
            ],
            3 => [
                'name' => 'laboriosam',
                'id' => '3',
                'price' => 139,
                'description' => 'Est neque esse error omnis et minima expedita.',
            ],
            4 => [
                'name' => 'placeat',
                'id' => '4',
                'price' => 983,
                'description' => 'Iusto id et qui autem veritatis. Molestiae non aut et qui ea eius porro.',
            ],
            5 => [
                'name' => 'dolores',
                'id' => '5',
                'price' => 739,
                'description' => 'Nisi asperiores veritatis qui quos sunt assumenda voluptatum.',
            ],
        ];
        $Categoris = [
            1 => [
                'name' => 'Moda',
                'id' => '1',
            ],
            2 => [
                'name' => 'Accesoris',
                'id' => '2',
            ],
            3 => [
                'name' => 'Fornitures', 
                'id' => '3',
            ],
            4 => [
                'name' => 'Toys',
                'id' => '4',
            ],
            5 => [
                'name' => 'Art',
                'id' => '5',
            ],
        ];

        $user = new User();
        $user->name = "test";
        $user->path = "storage/app/public/img/imgN640cc8af60f70.jpg";
        $user->email = "Recio@test.com";
        $user->email_verified_at = now();
        $user->password = "Hol@1234";
        $user->remember_token = "gKriN6GNfW";
        $user->save();

        $image = Image::createImageObject('Marisco Fresco', 'MarketPlace.com');

        $shop =  Shop::createShopObject('Antonio', 'Mariscos Recio', '45773999B', $user->id, $image->id);

       
    

        foreach ($Products as $c) {
            $num = uniqid();
            $name = "imgN" . $num .".jpg";
            $p = new Product();
            $p->id = $c['id'];
            $p->name = $c['name'];
            $p->price = $c['price'];
            $p->order = 1;
            $p->shop_id = $shop->id;
            $p->description = $c['description'];
            $p->save();

            $productImage = new ProductImage();
            $productImage->isMain = true;
            $productImage->image_id = $image->id;
            $productImage->product_id = $p->id;
            $productImage->save();
        }

        foreach ($Categoris as $c) {
            $category = new Category();
            $category->name = $c['name'];
            $category->id = $c['id'];
            $category->save();
        }


        $allProducts = Category::all();

        foreach ($allProducts as $p) {
            $p->products()->attach(Category::find($p->id));
        }
    }
}

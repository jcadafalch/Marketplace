<?php

namespace Tests\Feature;


use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class HomeTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
   
    public function test_get_all_categories(){
        $this->createDummyAllProduct();
        $request = ['search' => ''];
        $actual = Product::searchByName($request);

        $this->assertSameSize([1,2,3,4,5], $actual);
    }
   
    public function test_get_one_category(){
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
        ];
        $search = Product::searchByAll($request);
        $actual = $search;
      
        $this->assertEquals($expected, $actual[0]->name);
    }
      
    public function test_get_all_categories_with_filter_by_name(){
        $this->createDummyAllProduct();
        $request = [
            'search' => 'dolores',
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
    
    public function test_get_one_category_with_filter_by_name(){
        $this->createDummyAllProduct();
        $request = [
            'search' => 'laboriosam',
            'category' => 3,
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

    public function test_get_not_found_product_by_name_not_exist(){
        $this->createDummyAllProduct();

        $request = [
            'search' => '12312312414',
            'category' => 3,
        ];
        
        $response = $this->call('GET', '/searchProduct', ['search' => '12312312414','category' =>3,]);
        $response->assertSeeText('404 Not found!');
    }

    public function test_get_not_found_product_by_category_not_exist(){
        $this->createDummyAllProduct();

        $request = [
            'search' => '',
            'category' =>13123132,
        ];
        ['search' => '','category' =>13123132,];

        $response =  $response = $this->call('GET', '/searchProduct', ['search' => '','category' =>13123132,]);
        $response->assertSeeText('404 Not found!');
    }

    private function createDummyAllProduct() {

        $Products =  [
            1 => [
                'name' => 'quàe',
                'id' => '1',
                'price' => 222.74,
                'url' => 'imgN64120e0448e76.jpg',
                'description' => 'Quod cumque earum ut quia ex incidunt possimus.',
            ],
            2 => [
                'name' => 'voluptas',
                'id' => '2',
                'price' => 696.58,
                'url' => '',
                'description' => 'Enim officiis illo vero ea consequatur veniam et dolorem. Asperiores ea reiciendis dolor a reiciendis.',
            ],
            3 => [
                'name' => 'laboriosam',
                'id' => '3',
                'price' => 139.13,
                'url' => '',
                'description' => 'Est neque esse error omnis et minima expedita.',
            ],
            4 => [
                'name' => 'placeat',
                'id' => '4',
                'price' => 983.44,
                'url' => '',
                'description' => 'Iusto id et qui autem veritatis. Molestiae non aut et qui ea eius porro.',
            ],
            5 => [
                'name' => 'dolores',
                'id' => '5',
                'price' => 739.06,
                'url' => '',
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
       

        foreach ($Products as $c) {
            $num = uniqid();
            $name = "imgN" . $num .".jpg";
            $p = new Product();
            $p->id = $c['id'];
            $p->name = $c['name'];
            $p->price = $c['price'];
            $p->url = $name;
            $p->description = $c['description'];
            $p->save();
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

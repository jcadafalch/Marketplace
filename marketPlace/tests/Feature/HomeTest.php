<?php

namespace Tests\Feature;


use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class HomeTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function test_get_all_categories(){
        $request = ['search' => ''];
        $actual = Product::searchByName($request);

        $this->assertSameSize([1,2,3,4,5], $actual);
    }
    
    public function test_get_one_category(){
       
        $request = [
            'search' => '',
            'category' => '1',
        ];
        $actual = Product::searchByAll($request);
        $p = new Product();
        $p->id = '1';
        $p->name = "facere";
        $p->price = 116.58;
        $p->url = 'http://127.0.0.1:8000/storage/img/imgN640da75953dde.jpg';
        $expected = $p->name;

        
        $this->assertEquals($expected, $actual[0]->name);
    }
     
    public function test_get_all_categories_with_filter_by_name(){
        
        $request = [
            'search' => 'doloremque',
        ];
        $actual = Product::searchByName($request);
        
        $p = new Product();
        $p->id = 2;
        $p->name = "doloremque";
        $p->price = 462.32;
        $p->url = 'http://127.0.0.1:8000/storage/img/imgN640da759b0950.jpg';
        $expected = $p->name;

        $this->assertEquals($expected, $actual[0]->name);
    }
    
    public function test_get_one_category_with_filter_by_name(){
        $request = [
            'search' => 'quis',
            'category' => '4',
        ];

        $actual = Product::searchByAll($request);
        $p = new Product();
        $p->id = 4;
        $p->name = 'quis';
        $p->price = 261.96;
        $p->url = 'http://127.0.0.1:8000/storage/img/imgN640da75a515c1.jpg';
        $expected = $p->name;
        
        $this->assertEquals($expected, $actual[0]->name);
    }
}

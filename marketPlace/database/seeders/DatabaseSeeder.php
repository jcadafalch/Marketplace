<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    // Array de categories
     public $Categoris = [
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
        ]
    ];
    public function run(): void
    {
     
    
        // Creem 5 productes aleatoris 
        Product::factory(5)->create();
          
        // Creem 5 categories aleatoris
        //$Category = \App\Models\Category::factory(5)->create();
        
        // Proves per inserta categories a mà
        foreach ($this->Categoris as $c) {
            $category = new Category();
            $category->name = $c['name'];
            $category->save();
        }

        
        // Agafem tots el productes que hem creat
        $allProducts = Category::all();
     
        foreach ($allProducts as $p) {
        // Fem la unio
        $p->products()->attach(Category::find($p->id));
        }
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}

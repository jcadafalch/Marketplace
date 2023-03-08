<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Creem 5 productes aleatoris 
        \App\Models\Product::factory(5)->create();
          
        // Creem 5 categories aleatoris
        $Category = \App\Models\Category::factory(5)->create();
        
        // Agafem tots el productes que hem creat
        $allProducts = \App\Models\Category::all();
     
        foreach ($allProducts as $p) {
        // Fem la unio
        $p->products()->attach(\App\Models\Category::find($p->id));
        }
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}

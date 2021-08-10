<?php

namespace Database\Seeders;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'category_name'        => 'Vegetables',

        ]);
        Category::create([
            'category_name'        => 'Fishes',

        ]);
        Category::create([
            'category_name'        => 'Fruits',

        ]);
    }
    
}

<?php

namespace Database\Seeders;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'category_id'        => 1,
            'product_name'       =>'Potatoes',
            'price'             =>'150'

        ]);
        Product::create([
            'category_id'        => 1,
            'product_name'       =>'Tomatoes',
            'price'             =>'250'


        ]);
        Product::create([
            'category_id'        => 1,
            'product_name'      =>'Brinjals',
            'price'             =>'200'


        ]);
        Product::create([
            'category_id'        => 1,
            'product_name'        =>'Drumstick',
            'price'             =>'250'


        ]);
        Product::create([
            'category_id'        => 1,
            'product_name'     =>'CauliFlower',
            'price'             =>'350'


        ]);
        Product::create([
            'category_id'        => 1,
            'product_name'       =>'Broccoli',
            'price'             =>'200'


        ]);
        Product::create([
            'category_id'        => 1,
            'product_name'       =>'Ladies Finger',
            'price'             =>'250'


        ]);
        Product::create([
            'category_id'        => 1,
            'product_name'       =>'Carrot',
            'price'             =>'250'


        ]);
        Product::create([
            'category_id'        => 1,
            'product_name'        =>'Beans',
            'price'             =>'100'


        ]);
       
        Product::create([
            'category_id'        => 2,
            'product_name'       =>'Shark',
            'price'              =>'650'


        ]);
    }
}

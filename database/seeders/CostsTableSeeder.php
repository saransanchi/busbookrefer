<?php

namespace Database\Seeders;
use App\Models\Cost;
use Illuminate\Database\Seeder;

class CostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cost::create([
            'truck_cost'=>3500,
            'handling_cost'=>1000,
            'shipping_cost'=>1000,
        ]);
    }
}

<?php

namespace Database\Seeders;
use App\Models\SuppliersDeliveryDetail;
use Illuminate\Database\Seeder;

class SuppliersDeliveryDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SuppliersDeliveryDetail::create([
            'product_id'    =>  '1',
            'supplier_id'   =>  '1',
            'delivery_date' =>  '2020-01-15',
            'quantity'      =>  '50', 
        ]);
        SuppliersDeliveryDetail::create([
            'product_id'    =>  '2',
            'supplier_id'   =>  '1',
            'delivery_date' =>  '2020-01-16',
            'quantity'      =>  '40', 
        ]);
    }
}

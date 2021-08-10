<?php

namespace Database\Seeders;
use App\Models\PaymentStatus;

use Illuminate\Database\Seeder;

class PaymentStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentStatus::create([
            'status'        => 'Paid',
            'slug'          =>'paid'

        ]);
        PaymentStatus::create([
            'status'        => 'Pending',
            'slug'          =>'pending'

        ]);
    }
}

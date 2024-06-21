<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentTypesCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'payment_type_code' => 'Cash', 'code' => '01'],
            ['id' => 2, 'payment_type_code' => 'CREDIT', 'code' => '02'],
            ['id' => 3, 'payment_type_code' => 'CASH/CREDIT', 'code' => '03'],
            ['id' => 4, 'payment_type_code' => 'BANK CHECK', 'code' => '04'],
            ['id' => 5, 'payment_type_code' => 'DEBIT & CREDIT CARD', 'code' => '05'],
            ['id' => 6, 'payment_type_code' => 'MOBILE MONEY', 'code' => '06'],
            ['id' => 7, 'payment_type_code' => 'OTHER', 'code' => '07'],
        ];

        // Insert data into payment_types_code table
        DB::table('payment_types_code')->insert($data);
    }
}
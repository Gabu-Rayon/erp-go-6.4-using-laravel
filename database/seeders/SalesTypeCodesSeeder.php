<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalesTypeCodesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'code' => 'C', 'saleTypeCode' => 'Copy'],
            ['id' => 2, 'code' => 'N', 'saleTypeCode' => 'Normal'],
            ['id' => 3, 'code' => 'P', 'saleTypeCode' => 'Proforma'],
            ['id' => 4, 'code' => 'T ', 'saleTypeCode' => 'Training'],
        ];

        // Insert data into sales_type_codes table
        DB::table('sales_type_codes')->insert($data);
    }
}
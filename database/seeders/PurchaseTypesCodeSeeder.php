<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurchaseTypesCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'purchase_type_code' => 'Copy', 'code' => 'C'],
            ['id' => 2, 'purchase_type_code' => 'Normal', 'code' => 'N'],
            ['id' => 3, 'purchase_type_code' => 'Proforma', 'code' => 'P'],
            ['id' => 4, 'purchase_type_code' => 'Training', 'code' => 'T'],
        ];

        // Insert data into purchase_types_code table
        DB::table('purchase_types_code')->insert($data);
    }
}
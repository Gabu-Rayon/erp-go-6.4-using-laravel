<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurchaseStatusCodesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'purchase_status_code' => 'Wait for Approval', 'code' => '01'],
            ['id' => 2, 'purchase_status_code' => 'Approved', 'code' => '02'],
            ['id' => 3, 'purchase_status_code' => 'Cancel Requested', 'code' => '03'],
            ['id' => 4, 'purchase_status_code' => 'Canceled', 'code' => '04'],
            ['id' => 5, 'purchase_status_code' => 'Credit Note Generated', 'code' => '05'],
            ['id' => 6, 'purchase_status_code' => 'Transferred', 'code' => '06'],
        ];

        // Insert data into purchase_status_codes table
        DB::table('purchase_status_codes')->insert($data);
    }
}
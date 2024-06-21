<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoiceStatusCodesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'code' => '01', 'invoiceStatusCode' => 'Wait for Approval'],
            ['id' => 2, 'code' => '02', 'invoiceStatusCode' => 'Approved'],
            ['id' => 3, 'code' => '03', 'invoiceStatusCode' => 'Cancel Requested'],
            ['id' => 4, 'code' => '04', 'invoiceStatusCode' => 'Canceled'],
            ['id' => 5, 'code' => '05', 'invoiceStatusCode' => 'Credit Note Generated'],
            ['id' => 6, 'code' => '06', 'invoiceStatusCode' => 'Transferred'],
        ];

        // Insert data into invoice_status_codes table
        DB::table('invoice_status_codes')->insert($data);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ImportItemStatusCodesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        $data = [
            ['id' => 1, 'code' => 'Unsent', 'KRA_Code' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'code' => 'Waiting', 'KRA_Code' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'code' => 'Approved', 'KRA_Code' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 4, 'code' => 'Cancelled', 'KRA_Code' => 4, 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('import_item_status_codes')->insert($data);
    }
}
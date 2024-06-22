<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockReleaseTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stock_release_types')->insert([
            [
                'id' => 1,
                'code' => '01',
                'type' => 'Incoming-Import',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'code' => '02',
                'type' => 'Incoming-Purchase',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'code' => '03',
                'type' => 'Incoming-Stock Movement',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'code' => '04',
                'type' => 'Incoming-Processing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'code' => '05',
                'type' => 'Incoming-Adjustment',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'code' => '06',
                'type' => 'Outgoing-Sale',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'code' => '07',
                'type' => 'Outgoing-Return',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'code' => '08',
                'type' => 'Outgoing-Processing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 9,
                'code' => '09',
                'type' => 'Outgoing-Discarding',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 10,
                'code' => '10',
                'type' => 'Outgoing-Adjustment',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('item_type')->insert([
            [
                'id' => 1,
                'item_type_code' => 1,
                'item_type_name' => 'Raw material',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'item_type_code' => 2,
                'item_type_name' => 'Finished Product',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'item_type_code' => 3,
                'item_type_name' => 'Service',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
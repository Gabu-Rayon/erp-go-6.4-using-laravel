<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductServiceUnitsSeeder extends Seeder
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
            ['id' => 1, 'code' => '4B', 'name' => 'Pair', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'code' => 'Av', 'name' => 'Cap', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'code' => 'BA', 'name' => 'Barrel', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 4, 'code' => 'BE', 'name' => 'Bundle', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 5, 'code' => 'BG', 'name' => 'Bag', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 6, 'code' => 'BL', 'name' => 'Block', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 7, 'code' => 'BLL', 'name' => 'Barrel petroleum(158.978dm3)', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 8, 'code' => 'BX', 'name' => 'Box', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 9, 'code' => 'CA', 'name' => 'Can', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 10, 'code' => 'CEL', 'name' => 'Cell', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 11, 'code' => 'CA', 'name' => 'Centimetre', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 12, 'code' => 'CE', 'name' => 'Cell', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 13, 'code' => 'CMT', 'name' => 'Centimetre', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 14, 'code' => 'CR', 'name' => 'Carat', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 15, 'code' => 'DR', 'name' => 'Drum', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 16, 'code' => 'DZ', 'name' => 'Dozen', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 17, 'code' => 'GLL', 'name' => 'Gallon', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 18, 'code' => 'GRM', 'name' => 'Gram', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 19, 'code' => 'GRO', 'name' => 'Gross', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 20, 'code' => 'KG', 'name' => 'Kilogramme', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 21, 'code' => 'KTM', 'name' => 'Kilometre', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 22, 'code' => 'KWT', 'name' => 'Kilowatt', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 23, 'code' => 'L', 'name' => 'Litre', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 24, 'code' => 'LBR', 'name' => 'Pound', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 25, 'code' => 'LK', 'name' => 'Link', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 26, 'code' => 'LTR', 'name' => 'Litre', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 27, 'code' => 'M', 'name' => 'Metre', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 28, 'code' => 'M2', 'name' => 'Square metre', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 29, 'code' => 'M3', 'name' => 'Cubic metre', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 30, 'code' => 'MGM', 'name' => 'Milligram', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 31, 'code' => 'MTR', 'name' => 'Metre', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 32, 'code' => 'MWT', 'name' => 'Megawatt hour (1000KW.H)', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 33, 'code' => 'NO', 'name' => 'Number', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 34, 'code' => 'NX', 'name' => 'Part per thousand', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 35, 'code' => 'PA', 'name' => 'Packet', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 36, 'code' => 'PG', 'name' => 'Plate', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 37, 'code' => 'PR', 'name' => 'Plate', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 38, 'code' => 'RL', 'name' => 'Reel', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 39, 'code' => 'RO', 'name' => 'Roll', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 40, 'code' => 'SET', 'name' => 'Set', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 41, 'code' => 'ST', 'name' => 'Sheet', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 42, 'code' => 'TNE', 'name' => 'Tonne (metric ton)', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 43, 'code' => 'TU', 'name' => 'Tube', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 44, 'code' => 'U', 'name' => 'Pieces/Item (number)', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 45, 'code' => 'YRD', 'name' => 'Yard', 'description' => NULL, 'mapping' => NULL, 'remark' => NULL, 'created_by' => NULL, 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('product_service_units')->insert($data);
    }
}
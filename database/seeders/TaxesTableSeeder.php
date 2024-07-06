<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaxesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('taxes')->insert([
            [
                'id' => 1,
                'name' => 'A',
                'rate' => '0',
                'cdCls' => '04',
                'cd' => 'A-Exempt',
                'cdNm' => 'A-Exempt',
                'cdDesc' => 'A-EX',
                'useYn' => 'Y',
                'srtOrd' => 1,
                'useDfnCd1' => NULL,
                'useDfnCd2' => NULL,
                'useDfnCd3' => NULL,
                'created_by' => NULL,
                'created_at' => '2024-06-15 06:04:51',
                'updated_at' => '2024-06-15 06:04:51',
            ],
            [
                'id' => 2,
                'name' => 'B',
                'rate' => '16',
                'cdCls' => '04',
                'cd' => 'B-VAT 16%',
                'cdNm' => 'B-VAT 16%',
                'cdDesc' => 'B-16%',
                'useYn' => 'Y',
                'srtOrd' => 2,
                'useDfnCd1' => NULL,
                'useDfnCd2' => NULL,
                'useDfnCd3' => NULL,
                'created_by' => NULL,
                'created_at' => '2024-06-15 06:04:51',
                'updated_at' => '2024-06-15 06:04:51',
            ],
            [
                'id' => 3,
                'name' => 'C',
                'rate' => '0',
                'cdCls' => '04',
                'cd' => 'C-Zero Rated',
                'cdNm' => 'C-Zero Rated',
                'cdDesc' => 'TAX C',
                'useYn' => 'Y',
                'srtOrd' => 3,
                'useDfnCd1' => NULL,
                'useDfnCd2' => NULL,
                'useDfnCd3' => NULL,
                'created_by' => NULL,
                'created_at' => '2024-06-15 06:04:51',
                'updated_at' => '2024-06-15 06:04:51',
            ],
            [
                'id' => 4,
                'name' => 'E',
                'rate' => '8',
                'cdCls' => '04',
                'cd' => 'E-VAT 8%',
                'cdNm' => 'E-VAT 8%',
                'cdDesc' => 'E-8%',
                'useYn' => 'Y',
                'srtOrd' => 4,
                'useDfnCd1' => NULL,
                'useDfnCd2' => NULL,
                'useDfnCd3' => NULL,
                'created_by' => NULL,
                'created_at' => '2024-06-15 06:04:51',
                'updated_at' => '2024-06-15 06:04:51',
            ],
            [
                'id' => 5,
                'name' => 'D',
                'rate' => '0',
                'cdCls' => '04',
                'cd' => 'D-Non VAT',
                'cdNm' => 'D-Non VAT',
                'cdDesc' => 'TAX D',
                'useYn' => 'Y',
                'srtOrd' => 5,
                'useDfnCd1' => NULL,
                'useDfnCd2' => NULL,
                'useDfnCd3' => NULL,
                'created_by' => NULL,
                'created_at' => '2024-06-15 06:04:51',
                'updated_at' => '2024-06-15 06:04:51',
            ],
        ]);
    }
}

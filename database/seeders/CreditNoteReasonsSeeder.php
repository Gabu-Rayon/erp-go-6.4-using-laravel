<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreditNoteReasonsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'code' => '01', 'reason' => 'Missing Quantity'],
            ['id' => 2, 'code' => '02', 'reason' => 'Missing data'],
            ['id' => 3, 'code' => '03', 'reason' => 'Damaged'],
            ['id' => 4, 'code' => '04', 'reason' => 'Wasted'],
            ['id' => 5, 'code' => '05', 'reason' => 'Raw Material Shortage'],
            ['id' => 6, 'code' => '06', 'reason' => 'Refund'],
        ];

        // Insert data into credit_note_reasons table
        DB::table('credit_note_reasons')->insert($data);
    }
}
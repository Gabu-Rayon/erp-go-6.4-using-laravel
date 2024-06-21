<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductServicesPackagingUnitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $units = [
            ['code' => 'AM', 'name' => 'Ampoule'],
            ['code' => 'BA', 'name' => 'Barrel'],
            ['code' => 'BC', 'name' => 'Bottlecrate'],
            ['code' => 'BE', 'name' => 'Bundle'],
            ['code' => 'BF', 'name' => 'Ballon, non-protected'],
            ['code' => 'BG', 'name' => 'Bag'],
            ['code' => 'BJ', 'name' => 'Bucket'],
            ['code' => 'BL', 'name' => 'Bale'],
            ['code' => 'BQ', 'name' => 'Bottle, protected cylindrical'],
            ['code' => 'BR', 'name' => 'Bar'],
            ['code' => 'BV', 'name' => 'Bottle, bulbous'],
            ['code' => 'BZ', 'name' => 'Bag'],
            ['code' => 'CA', 'name' => 'Can'],
            ['code' => 'CH', 'name' => 'Chest'],
            ['code' => 'CJ', 'name' => 'Coffin'],
            ['code' => 'CL', 'name' => 'Coil'],
            ['code' => 'CR', 'name' => 'Wooden Bx, wooden Case'],
            ['code' => 'CS', 'name' => 'Cassette'],
            ['code' => 'CT', 'name' => 'Carton'],
            ['code' => 'CTN', 'name' => 'Container'],
            ['code' => 'CY', 'name' => 'Cylinder'],
            ['code' => 'DR', 'name' => 'Drum'],
            ['code' => 'GT', 'name' => 'Extra Countable Item'],
            ['code' => 'HH', 'name' => 'Hand Baggage'],
            ['code' => 'IZ', 'name' => 'Ingots'],
            ['code' => 'JR', 'name' => 'Jar'],
            ['code' => 'JU', 'name' => 'Jug'],
            ['code' => 'JY', 'name' => 'Jerry Can Cylindrical'],
            ['code' => 'KZ', 'name' => 'Canester'],
            ['code' => 'LZ', 'name' => 'Logs, in bundle/bunch/truss'],
            ['code' => 'NT', 'name' => 'Net'],
            ['code' => 'OU', 'name' => 'Non-Exterior Packaging unit'],
            ['code' => 'PO', 'name' => 'Poddon'],
            ['code' => 'PG', 'name' => 'Plate'],
            ['code' => 'PI', 'name' => 'Pipe'],
            ['code' => 'PO', 'name' => 'Pilot'],
            ['code' => 'PU', 'name' => 'Tray Pack'],
            ['code' => 'RL', 'name' => 'Reel'],
            ['code' => 'RO', 'name' => 'Roll'],
            ['code' => 'RZ', 'name' => 'Rods in bundle/bunch/truss'],
            ['code' => 'SK', 'name' => 'Skeleton case'],
            ['code' => 'TY', 'name' => 'Tank, cylindrical'],
            ['code' => 'VG', 'name' => 'Bulk, gas (at 1031 mbar 15 0c)'],
            ['code' => 'VL', 'name' => 'Bulk, Liquid (at normal temperature/pressure)'],
            ['code' => 'VO', 'name' => 'Bulk, solid, large particles (nodules)'],
            ['code' => 'VQ', 'name' => 'Bulk gas (liquefied at abnormal temperature/pressure)'],
            ['code' => 'VR', 'name' => 'Bulk, solid, granular particles (grains)'],
            ['code' => 'VT', 'name' => 'Extra Bulk Item'],
            ['code' => 'VY', 'name' => 'Bulk, fine particles (powder)'],
            ['code' => 'ML', 'name' => 'Mills' ,'description' => 'Cigarrette Mills'],
            ['code' => 'TN', 'name' => 'TAN','description' => '1TAN REFER TO 20BAGS'],
        ];

        foreach ($units as $unit) {
            DB::table('product_services_packaging_units')->insert([
                'code' => $unit['code'],
                'name' => $unit['name'],
                'description' => null,
                'mapping' => null,
                'remark' => null,
                'created_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'status' => 'active',
            ]);
        }
    }
}
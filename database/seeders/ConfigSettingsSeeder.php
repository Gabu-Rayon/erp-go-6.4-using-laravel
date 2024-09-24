<?php

namespace Database\Seeders;

use App\Models\ConfigSettings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ConfigSettings::create([
            'local_storage' => 'off',
            'stock_update' => 'off',
            'customer_mapping_by_tin' => 'off',
            'item_mapping_by_code' => 'off',
            'api_type' => 'VSCU',
            'api_url' => 'vscu',
        ]);
    }
}

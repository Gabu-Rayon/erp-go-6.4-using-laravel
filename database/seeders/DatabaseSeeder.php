<?php

namespace Database\Seeders;

use App\Models\Utility;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Request;

class DatabaseSeeder extends Seeder
{
        /**
         * Seed the application's database.
         *
         * @return void
         */
        public function run()
        {
                // $this->call(NotificationSeeder::class);
                Artisan::call('module:migrate LandingPage');
                Artisan::call('module:seed LandingPage');

                // $this->call(PlansTableSeeder::class);
                // $this->call(UsersTableSeeder::class);
                // $this->call(AiTemplateSeeder::class);
                // $this->call(ProductServicesPackagingUnitsSeeder::class);
                // $this->call(ProductServiceUnitsSeeder::class);
                // $this->call(ImportItemStatusCodesSeeder::class);
                // $this->call(InvoiceStatusCodesSeeder::class);
                // $this->call(PaymentTypesCodeSeeder::class);
                // $this->call(PurchaseStatusCodesSeeder::class);

                // $this->call(PurchaseTypesCodeSeeder::class);
                // $this->call(SalesTypeCodesSeeder::class);
                // $this->call(CreditNoteReasonsSeeder::class);
                // $this->call(ItemTypeSeeder::class);
                // $this->call(StockReleaseTypesSeeder::class);
                // $this->call(ConfigSettingsSeeder::class);
        }
}
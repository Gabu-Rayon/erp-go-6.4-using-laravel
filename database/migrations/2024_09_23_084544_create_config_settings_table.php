<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('config_settings', function (Blueprint $table) {
            $table->id();
            $table->enum('local_storage', ['on', 'off'])->default('off');
            $table->enum('stock_update', ['on', 'off'])->default('off');
            $table->enum('customer_mapping_by_tin', ['on', 'off'])->default('off');
            $table->enum('item_mapping_by_code', ['on', 'off'])->default('off');
            $table->enum('api_type', ['OSCU', 'VSCU'])->default('OSCU');
            $table->string('api_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('config_settings');
    }
};

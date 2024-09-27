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
        Schema::create('stock_master_save_requests', function (Blueprint $table) {
            $table->id();
            $table->string('itemCd');
            $table->integer('rsdQty');
            $table->string('regrId');
            $table->string('regrNm');
            $table->string('modrNm');
            $table->string('modrId');
            $table->string('tin');
            $table->string('bhfId');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_master_save_requests');
    }
};

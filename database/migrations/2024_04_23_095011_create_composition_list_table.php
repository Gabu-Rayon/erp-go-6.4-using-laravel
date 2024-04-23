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
        Schema::create('composition_list', function (Blueprint $table) {
            $table->id();
            $table->string('main_item_code');
            $table->string('composition_item_code');
            $table->integer('composition_item_quantity');
            $table->foreign('main_item_code')->references('itemCd')->on('item_list');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('composition_list');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('branch_transfer_products', function (Blueprint $table) {
            $table->id();
            $table->string('itemCode');
            $table->integer('quantity');
            $table->integer('pkgQuantity');
            $table->unsignedBigInteger('branch_transfer_id');
            $table->timestamps();

            // Add foreign key constraint
            $table->foreign('branch_transfer_id')->references('id')->on('branch_transfer')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_transfer_products');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('branch_transfer', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('from_branch');
            $table->unsignedBigInteger('to_branch');
            $table->unsignedBigInteger('product_id');
            $table->timestamps();

            // Add foreign key constraints if you have `branches` and `products` tables
            // $table->foreign('from_branch')->references('id')->on('branches');
            // $table->foreign('to_branch')->references('id')->on('branches');
            // $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_transfer');
    }
};

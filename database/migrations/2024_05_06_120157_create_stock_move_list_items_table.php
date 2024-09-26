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
        Schema::create('stock_move_list_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stockMoveListID');
            $table->integer('itemSeq')->nullable();
            $table->string('itemCd')->nullable();
            $table->string('itemNm')->nullable();
            $table->string('bcd')->nullable();
            $table->string('pkgUnitCd')->nullable();
            $table->integer('pkg')->nullable();
            $table->string('qtyUnitCd')->nullable();
            $table->integer('qty')->nullable();
            $table->date('itemExprDt')->nullable();
            $table->decimal('prc', 10, 2)->nullable();
            $table->decimal('splyAmt', 10, 2)->nullable();
            $table->decimal('totDcAmt', 10, 2)->nullable();
            $table->decimal('taxblAmt', 10, 2)->nullable();
            $table->string('taxTyCd')->nullable();
            $table->decimal('taxAmt', 10, 2)->nullable();
            $table->decimal('totAmt', 10, 2)->nullable();
            $table->timestamps();

            // Define foreign key constraint
            $table->foreign('stockMoveListID')->references('id')->on('stock_move_lists')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_move_list_items');
    }
};
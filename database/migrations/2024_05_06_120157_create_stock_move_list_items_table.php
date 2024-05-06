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
            $table->integer('itemSeq');
            $table->string('itemCd');
            $table->string('itemClsCd');
            $table->string('itemNm');
            $table->string('bcd');
            $table->string('pkgUnitCd');
            $table->integer('pkg');
            $table->string('qtyUnitCd');
            $table->integer('qty');
            $table->date('itemExprDt')->nullable();
            $table->decimal('prc', 10, 2);
            $table->decimal('splyAmt', 10, 2);
            $table->decimal('totDcAmt', 10, 2);
            $table->decimal('taxblAmt', 10, 2);
            $table->string('taxTyCd');
            $table->decimal('taxAmt', 10, 2);
            $table->decimal('totAmt', 10, 2);
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

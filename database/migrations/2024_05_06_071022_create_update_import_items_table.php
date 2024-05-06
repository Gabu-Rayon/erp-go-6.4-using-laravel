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
        Schema::create('update_import_items', function (Blueprint $table) {
            $table->id();
            $table->string('srNo');
            $table->string('taskCode');
            $table->string('declarationDate');
            $table->string('itemSeq');
            $table->string('hsCode');
            $table->string('itemClassificationCode');
            $table->string('itemCode');
            // Foreign keys
            $table->foreign('srNo')->references('srNo')->on('imported_items')->onDelete('cascade');
            $table->foreign('taskCode')->references('taskCode')->on('imported_items')->onDelete('cascade');
            $table->foreign('declarationDate')->references('declarationDate')->on('imported_items')->onDelete('cascade');
            $table->foreign('itemSeq')->references('itemSeq')->on('imported_items')->onDelete('cascade');
            $table->foreign('hsCode')->references('hsCode')->on('imported_items')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('update_import_items');
    }
};

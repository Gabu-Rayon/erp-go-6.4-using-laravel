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
        Schema::create('code_list_details', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('codeName');
            $table->text('codeDescription')->nullable();
            $table->string('useYearno');
            $table->integer('srtOrder');
            $table->string('userDefineCode1')->nullable();
            $table->string('userDefineCode2')->nullable();
            $table->string('userDefineCode3')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('codeClass')->references('codeClass')->on('code_lists')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('code_list_details');
    }
};
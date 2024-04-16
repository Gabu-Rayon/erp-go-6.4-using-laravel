<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations. for  code lists
     */
    public function up(): void
       {
        Schema::create('code_lists_classes', function (Blueprint $table) {
            $table->id();
            $table->string('codedClass');
            $table->string('codeClassName');
            $table->text('codeClassDescription')->nullable();
            $table->string('useYearno');
            $table->string('userDefineName1')->nullable();
            $table->string('userDefineName2')->nullable();
            $table->string('userDefineName3')->nullable();
            $table->timestamps();
        });
    
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('code_lists_classes');
    }
};
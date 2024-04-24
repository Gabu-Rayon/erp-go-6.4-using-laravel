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
        Schema::create('code', function (Blueprint $table) {
            $table->id();
            $table->string('cdCls');
            $table->string('cdClsNm');
            $table->string('cdClsDesc');
            $table->string('useYn');
            $table->string('userDfnNm1');
            $table->string('userDfnNm2');
            $table->string('userDfnNm3');
            $table->index('cdCls');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('code');
    }
};

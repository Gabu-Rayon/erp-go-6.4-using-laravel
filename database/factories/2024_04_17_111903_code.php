<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('code', function (Blueprint $table) {
            $table->id();
            $table->string('cdCls', 10)->unique();
            $table->string('cdClsNm', 100);
            $table->string('cdClsDesc', 100)->nullable();
            $table->char('useYn', 1)->default('Y');
            $table->string('userDfnNm1', 100)->nullable();
            $table->string('userDfnNm2', 100)->nullable();
            $table->string('userDfnNm3', 100)->nullable();
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
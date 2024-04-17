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
        Schema::create('api_initialization', function (Blueprint $table) {
            $table->id();
            $table->string('tin', 11)->nullable();
            $table->string('bhfId', 2)->nullable();
            $table->string('dvcSrlNo', 100)->nullable();
            $table->string('taxprNm', 60)->nullable();
            $table->string('bsnsActv', 100)->nullable();
            $table->string('bhfNm', 60)->nullable();
            $table->string('bhfOpenDt', 80)->nullable();
            $table->string('prvncNm', 100)->nullable();
            $table->string('dstrtNm', 100)->nullable();
            $table->string('sctrNm', 100)->nullable();
            $table->string('locDesc', 100)->nullable();
            $table->string('hqYn', 1)->nullable();
            $table->string('mgrNm', 60)->nullable();
            $table->string('mgrTelNo', 20)->nullable();
            $table->string('mgrEmail', 50)->nullable();
            $table->string('dvcId')->nullable();
            $table->string('sdcId')->nullable();
            $table->string('mrcNo')->nullable();
            $table->string('cmcKey')->nullable();
            $table->string('resultCd', 10)->nullable();
            $table->string('resultMsg')->nullable();
            $table->string('resultDt', 14)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_initialization');
    }
};

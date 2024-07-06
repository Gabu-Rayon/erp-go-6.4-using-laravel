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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('tin');
            $table->string('bhfId')->unique();
            $table->string('bhfNm');
            $table->string('bhfSttsCd');
            $table->string('prvncNm');
            $table->string('dstrtNm');
            $table->string('sctrNm');
            $table->string('locDesc')->nullable();
            $table->string('mgrNm');
            $table->string('mgrTelNo');
            $table->string('mgrEmail');
            $table->char('hqYn', 1)->default('Y');
            $table->unsignedBigInteger('created_by');

            $table->foreign('created_by')->references('id')->on('users');
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branches');
    }
};
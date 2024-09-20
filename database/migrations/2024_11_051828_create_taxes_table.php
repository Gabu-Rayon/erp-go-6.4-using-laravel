<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('rate');
            $table->string('cdCls');
            $table->string('cd');
            $table->string('cdNm');
            $table->string('cdDesc');
            $table->char('useYn', 1);
            $table->integer('srtOrd');
            $table->string('useDfnCd1')->nullable();
            $table->string('useDfnCd2')->nullable();
            $table->string('useDfnCd3')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
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
        Schema::dropIfExists('taxes');
    }
}

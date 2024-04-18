<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_list', function (Blueprint $table) {
            $table->id();
            $table->string('tin');
            $table->string('itemCd');
            $table->string('itemClsCd');
            $table->string('itemTyCd');
            $table->string('itemNm');
            $table->string('itemStdNm')->nullable();
            $table->string('orgnNatCd');
            $table->string('pkgUnitCd');
            $table->string('qtyUnitCd');
            $table->string('taxTyCd');
            $table->string('btchNo')->nullable();
            $table->string('regBhfId');
            $table->string('bcd')->nullable();
            $table->double('dftPrc');
            $table->double('grpPrcL1');
            $table->double('grpPrcL2');
            $table->double('grpPrcL3');
            $table->double('grpPrcL4');
            $table->double('grpPrcL5');
            $table->string('addInfo')->nullable();
            $table->integer('sftyQty');
            $table->string('isrcAplcbYn');
            $table->string('rraModYn');
            $table->string('useYn');
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
        Schema::dropIfExists('item_list');
    }
};
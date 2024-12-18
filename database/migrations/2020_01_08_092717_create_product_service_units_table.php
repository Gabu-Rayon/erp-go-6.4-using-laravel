<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductServiceUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_service_units', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 10)->nullable();
            $table->string('name', 100)->nullable();
            $table->string('description', 255)->nullable();
            $table->string('mapping', 255)->nullable();
            $table->string('remark', 255)->nullable();
            $table->integer('created_by')->default('0');
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
        Schema::dropIfExists('product_service_units');
    }
}

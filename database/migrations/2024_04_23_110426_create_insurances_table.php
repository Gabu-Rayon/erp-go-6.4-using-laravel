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
        Schema::create('insurances', function (Blueprint $table) {
            $table->id();
            $table->string('insuranceCode');
            $table->string('insuranceName');
            $table->decimal('premiumRate', 8, 2);
            $table->boolean('isUsed')->default(true);
            $table->boolean('isKRASync');
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
        Schema::dropIfExists('insurances');
    }
};
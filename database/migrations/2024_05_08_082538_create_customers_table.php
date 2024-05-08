<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customerNo', 9);
            $table->string('customerTin', 11);
            $table->string('customerName', 60);
            $table->string('address')->nullable();
            $table->string('telNo')->nullable();
            $table->string('email')->nullable();
            $table->string('faxNo')->nullable();
            $table->boolean('isUsed');
            $table->string('remark')->nullable();
            $table->string('customerMapping')->nullable();
            $table->boolean('customerIsActive')->default(true);
            $table->string('customerBillingName')->nullable();
            $table->string('customerBillingAddress')->nullable();
            $table->string('customerBillingMobileNo')->nullable();
            $table->string('customerBillingCountry')->nullable();
            $table->string('customerBillingState')->nullable();
            $table->string('customerBillingCity')->nullable();
            $table->string('customerBillingZip')->nullable();
            $table->string('customerShippingName')->nullable();
            $table->string('customerShippingAddress')->nullable();
            $table->string('customerShippingMobileNo')->nullable();
            $table->string('customerShippingCountry')->nullable();
            $table->string('customerShippingState')->nullable();
            $table->string('customerShippingCity')->nullable();
            $table->string('customerShippingZip')->nullable();
            $table->string('password')->nullable();
            $table->string('avatar')->nullable();
            $table->string('created_by')->nullable();
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
        Schema::dropIfExists('customers');
    }
}

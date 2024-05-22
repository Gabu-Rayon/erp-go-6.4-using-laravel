<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_users', function (Blueprint $table) {
            $table->id();
            $table->string('branchUserId')->unique();
            $table->string('branchUserName');
            $table->string('password');
            $table->string('address')->nullable();
            $table->string('contactNo')->nullable();
            $table->string('authenticationCode')->nullable();
            $table->text('remark')->nullable();
            $table->boolean('isUsed')->default(true);
            $table->unsignedBigInteger('created_by');
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
        Schema::dropIfExists('branch_users');
    }
}
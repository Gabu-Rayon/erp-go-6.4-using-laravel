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
        Schema::create('branch_users', function (Blueprint $table) {
            $table->id();
            $table->string('branchUserId', 20);
            $table->string('branchUserName', 60);
            $table->integer('branch_id');
            $table->string('password', 100);
            $table->string('address', 200)->nullable();
            $table->string('contactNo', 20)->nullable();
            $table->string('authenticationCode', 100)->nullable();
            $table->string('remark', 2000)->nullable();
            $table->boolean('isUsed')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
            $table->boolean('isKRASync')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_users');
    }
};

<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompositionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('composition_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('mainItemCode_id')->nullable();
            $table->string('compoItemCode')->nullable();
            $table->bigInteger('compoItemQty')->nullable();
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
        Schema::dropIfExists('composition_items');
    }
}
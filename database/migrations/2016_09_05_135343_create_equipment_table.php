<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('inventory_number', 100)->unique();
            $table->string('name', 100);
            $table->text('content')->nullable();
            $table->integer('equipment_type_id')->unsigned();
            $table->timestamps();
            $table->engine = 'InnoDB';
            $table->foreign('equipment_type_id')->references('id')->on('equipment_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipments');
    }
}

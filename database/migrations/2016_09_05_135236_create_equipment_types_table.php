<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipmentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment_types', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name');
            $table->boolean('folder')->default(false);
            $table->integer('parent_id')->unsigned()->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
            $table->foreign('parent_id')->references('id')->on('equipment_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipment_types');
    }
}

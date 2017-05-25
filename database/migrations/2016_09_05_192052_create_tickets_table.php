<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->text('text');
            $table->tinyInteger('status')->unsigned()->default(0);
            $table->integer('work_type_id')->unsigned();
            $table->integer('user_equipment_id')->unsigned();
            $table->integer('ticket_id')->unsigned()->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
            $table->foreign('work_type_id')->references('id')->on('work_types')->onDelete('cascade');
            $table->foreign('user_equipment_id')->references('id')->on('user_equipments')->onDelete('cascade');
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}

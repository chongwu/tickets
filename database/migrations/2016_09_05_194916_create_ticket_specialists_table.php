<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketSpecialistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_specialists', function (Blueprint $table) {
            $table->integer('specialist_id')->unsigned();
            $table->integer('ticket_id')->unsigned();
            $table->date('date_to');
            $table->engine = 'InnoDB';
            $table->foreign('specialist_id')->references('user_id')->on('specialists')->onDelete('cascade');
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
        Schema::dropIfExists('ticket_specialists');
    }
}

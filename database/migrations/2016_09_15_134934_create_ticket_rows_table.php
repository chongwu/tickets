<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketRowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_rows', function (Blueprint $table) {
            $table->increments('id');
            $table->text('text');
            $table->integer('ticket_id')->unsigned();
            $table->tinyInteger('type')->unsigned()->default(1);
            $table->timestamps();
            $table->engine = 'InnoDB';
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
        });

        Schema::table('tickets', function (Blueprint $table){
            $table->boolean('track')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_rows');
        Schema::table('tickets', function (Blueprint $table){
            $table->dropColumn('track');
        });
    }
}

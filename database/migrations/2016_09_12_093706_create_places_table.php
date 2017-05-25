<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->increments('id');
            $table->string('place')->unique();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::table('user_equipments', function (Blueprint $table){
            $table->dropColumn('place');
            $table->integer('place_id')->unsigned();
            $table->foreign('place_id')->references('id')->on('places')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('places');
        Schema::table('user_equipments', function (Blueprint $table){
            $table->dropForeign('user_equipments_place_id_foreign');
        });
    }
}

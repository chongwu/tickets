<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeManyManyRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_equipments', function (Blueprint $table){
            $table->dropForeign('user_equipments_place_id_foreign');
            $table->dropForeign('user_equipments_equipment_id_foreign');
            $table->dropForeign('user_equipments_user_id_foreign');
        });
        Schema::table('tickets', function (Blueprint $table){
            $table->dropForeign('tickets_user_equipment_id_foreign');
            $table->dropColumn('user_equipment_id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
        });
        Schema::dropIfExists('user_equipments');
        Schema::create('equipment_user', function (Blueprint $table){
            $table->integer('equipment_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->date('from')->nullable();
            $table->date('to')->nullable();
            $table->engine = 'InnoDB';
            $table->foreign('equipment_id')->references('id')->on('equipments')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('equipment_place', function (Blueprint $table){
            $table->integer('equipment_id')->unsigned();
            $table->integer('place_id')->unsigned();
            $table->date('from')->nullable();
            $table->date('to')->nullable();
            $table->engine = 'InnoDB';
            $table->foreign('equipment_id')->references('id')->on('equipments')->onDelete('cascade');
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
        Schema::dropIfExists('equipment_user');
        Schema::dropIfExists('equipment_place');
    }
}

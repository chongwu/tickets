<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkByGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_by_groups', function (Blueprint $table) {
            $table->integer('work_type_id')->unsigned();
            $table->integer('specialist_group_id')->unsigned();
            $table->engine = 'InnoDB';
            $table->foreign('work_type_id')->references('id')->on('work_types')->onDelete('cascade');
            $table->foreign('specialist_group_id')->references('id')->on('specialist_groups')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_by_groups');
    }
}

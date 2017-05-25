<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CahngeTicketSpecialistRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('ticket_specialists', 'ticket_user');
        Schema::table('ticket_user', function (Blueprint $table) {
            $table->dropForeign('ticket_specialists_specialist_id_foreign');
            $table->renameColumn('specialist_id', 'user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ticket_user', function (Blueprint $table) {
            $table->dropForeign('ticket_user_user_id_foreign');
            $table->renameColumn('user_id', 'specialist_id');
            $table->foreign('specialist_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::rename('ticket_user', 'ticket_specialists');
    }
}

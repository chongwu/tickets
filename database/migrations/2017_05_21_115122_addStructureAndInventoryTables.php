<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStructureAndInventoryTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
        	$table->increments('id');
        	$table->string('name');
        	$table->char('inn', 12)->unique()->nullable();
        	$table->timestamps();
        	$table->engine = 'InnoDB';
        });
        Schema::create('departments', function (Blueprint $table) {
        	$table->increments('id');
        	$table->string('name');
        	$table->integer('organization_id')->unsigned();
            $table->timestamps();
            $table->engine = 'InnoDB';
        	$table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
        });
        Schema::create('positions', function(Blueprint $table) {
        	$table->increments('id');
        	$table->string('name');
	        $table->timestamps();
	        $table->engine = 'InnoDB';
        });
        Schema::create('department_position', function(Blueprint $table) {
        	$table->integer('department_id')->unsigned();
        	$table->integer('position_id')->unsigned();
        	$table->primary(['department_id', 'position_id']);
        	$table->index(['department_id', 'position_id']);
        	$table->tinyInteger('quantity')->default(1);
        	$table->engine = 'InnoDB';
        	$table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
        	$table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');
        });
	    Schema::create('buildings', function (Blueprint $table) {
		    $table->increments('id');
		    $table->string('name');
		    $table->text('address')->nullable();
		    $table->timestamps();
		    $table->engine = 'InnoDB';
	    });
        Schema::create('cabinets', function (Blueprint $table) {
        	$table->increments('id');
        	$table->string('number', '5');
        	$table->integer('building_id')->unsigned();
        	$table->engine = 'InnoDB';
        	$table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
	        $table->timestamps();
        });
        Schema::create('manufacturers', function (Blueprint $table) {
        	$table->increments('id');
        	$table->string('name')->unique();
	        $table->timestamps();
	        $table->engine = 'InnoDB';
        });
        Schema::table('equipment_types', function (Blueprint $table) {
        	$table->dropForeign('equipment_types_parent_id_foreign');
        	$table->dropColumn(['folder', 'parent_id']);
        });
        Schema::table('equipments', function (Blueprint $table) {
        	$table->string('inventory_number', '25')->change();
        	$table->integer('manufacturer_id')->unsigned();
        	$table->foreign('manufacturer_id')->references('id')->on('manufacturers')->onDelete('cascade');
        });
        Schema::create('spare_part_types', function (Blueprint $table) {
        	$table->increments('id');
        	$table->string('name')->unique();
        	$table->timestamps();
        	$table->engine = 'InnoDB';
        });
        Schema::create('spare_parts', function (Blueprint $table) {
        	$table->increments('id');
        	$table->string('serial_number', 100)->unique();
        	$table->string('name');
        	$table->integer('spare_part_type_id')->unsigned();
        	$table->integer('manufacturer_id')->unsigned();
        	$table->engine = 'InnoDB';
        	$table->foreign('spare_part_type_id')->references('id')->on('spare_part_types')->onDelete('cascade');
        	$table->foreign('manufacturer_id')->references('id')->on('manufacturers')->onDelete('cascade');
        });
        Schema::create('equipment_spare_part', function (Blueprint $table) {
        	$table->integer('equipment_id')->unsigned();
        	$table->integer('spare_part_id')->unsigned();
        	$table->primary(['equipment_id', 'spare_part_id']);
        	$table->index(['equipment_id', 'spare_part_id']);
        	$table->timestamp('install_date');
        	$table->engine = 'InnoDB';
        	$table->foreign('equipment_id')->references('id')->on('equipments')->onDelete('cascade');
        	$table->foreign('spare_part_id')->references('id')->on('spare_parts')->onDelete('cascade');
        });
        Schema::table('tickets', function (Blueprint $table){
        	$table->dropForeign('tickets_ticket_id_foreign');
        	$table->dropColumn('ticket_id');
        });
        Schema::create('employees', function (Blueprint $table) {
        	$table->increments('personnel_number');
        	$table->string('last_name', 125);
        	$table->string('first_name', 125);
        	$table->string('patronymic', 125);
        	$table->timestamps();
        	$table->engine = 'InnoDB';
        });
        Schema::table('users', function (Blueprint $table) {
        	$table->integer('employee_id')->unsigned()->nullable();
        	$table->foreign('employee_id')->references('personnel_number')->on('employees')->onDelete('cascade');
        });

        Schema::create('position_employee_cabinet_equipment', function (Blueprint $table) {
        	$table->integer('position_id')->unsigned();
	        $table->integer('employee_id')->unsigned();
	        $table->integer('cabinet_id')->unsigned()->nullable();
        	$table->integer('equipment_id')->unsigned()->nullable();
        	$table->boolean('io')->nullable();
        	$table->primary(['position_id', 'employee_id', 'cabinet_id', 'equipment_id'], 'pk_pecq');
        	$table->index(['position_id', 'employee_id', 'cabinet_id', 'equipment_id'], 'ix_pecq');
        	$table->engine = 'InnoDB';
        	$table->foreign('position_id', 'pecq_position_id_foreign')->references('id')->on('positions')->onDelete('cascade');
        	$table->foreign('employee_id', 'pecq_employee_id_foreign')->references('personnel_number')->on('employees')->onDelete('cascade');
        	$table->foreign('cabinet_id', 'pecq_cabinet_id_foreign')->references('id')->on('cabinets')->onDelete('cascade');
        	$table->foreign('equipment_id', 'pecq_equipment_id_foreign')->references('id')->on('equipments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    	Schema::dropIfExists('position_employee_cabinet_equipment');
    	Schema::table('users', function (Blueprint $table) {
    		$table->dropForeign('users_employee_id_foreign');
    		$table->dropColumn('employee_id');
	    });
	    Schema::dropIfExists('employees');
    	Schema::table('tickets', function (Blueprint $table) {
		    $table->integer('ticket_id')->unsigned()->nullable();
		    $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
	    });
    	Schema::dropIfExists('equipment_spare_part');
    	Schema::dropIfExists('spare_parts');
    	Schema::dropIfExists('spare_part_types');
	    Schema::table('equipments', function (Blueprint $table) {
		    $table->string('inventory_number', '100')->change();
		    $table->dropForeign('equipments_manufacturer_id_foreign');
		    $table->dropColumn('manufacturer_id');
	    });
    	Schema::table('equipment_types', function (Blueprint $table){
		    $table->boolean('folder')->default(false);
		    $table->integer('parent_id')->unsigned()->nullable();
		    $table->foreign('parent_id')->references('id')->on('equipment_types')->onDelete('cascade');
	    });
	    Schema::dropIfExists('manufacturers');
	    Schema::dropIfExists('cabinets');
	    Schema::dropIfExists('buildings');
	    Schema::dropIfExists('department_position');
	    Schema::dropIfExists('positions');
	    Schema::dropIfExists('departments');
        Schema::dropIfExists('organizations');
    }
}

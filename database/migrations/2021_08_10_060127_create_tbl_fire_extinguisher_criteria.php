<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblFireExtinguisherCriteria extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_fire_extinguisher_criteria', function (Blueprint $table) {
            $table->bigIncrements('fe_criteria_id');
            $table->string('control_number');
            $table->string('classification');
            $table->string('location');
            $table->string('lever');
            $table->string('hose_and_nozzle');
            $table->string('cyl_tank');
            $table->string('press_gauge');
            $table->string('capacity');                        
            $table->string('remarks');
            $table->unsignedBigInteger('checksheet_id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('last_updated_by');       
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_fire_extinguisher_criteria');
    }
}

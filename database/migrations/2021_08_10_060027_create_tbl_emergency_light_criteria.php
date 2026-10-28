<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblEmergencyLightCriteria extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_emergency_light_criteria', function (Blueprint $table) {
            $table->bigIncrements('el_criteria_id');
            $table->string('control_number');
            $table->string('location');
            $table->string('lights-l');
            $table->string('lights-r');
            $table->string('battery');
            $table->string('draining_of_rechargeable_battery');
            $table->string('inspection_card');                        
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
        Schema::dropIfExists('tbl_emergency_light_criteria');
    }
}

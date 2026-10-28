<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblFireHoseCriteria extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_fire_hose_criteria', function (Blueprint $table) {
            $table->bigIncrements('fh_criteria_id');
            $table->string('control_number');
            $table->string('location');
            $table->string('cabinet');
            $table->string('hose');
            $table->string('nozzle');
            $table->string('pipeline');
            $table->string('valve');                        
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
        Schema::dropIfExists('tbl_fire_hose_criteria');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblExitLightCriteria extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_exit_light_criteria', function (Blueprint $table) {
            $table->bigIncrements('extl_criteria_id');
            $table->string('location');
            $table->string('light_status');
            $table->string('battery_status');                  
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
        Schema::dropIfExists('tbl_exit_light_criteria');
    }
}

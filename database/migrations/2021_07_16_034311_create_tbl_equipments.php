<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblEquipments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_equipments', function (Blueprint $table) {
            $table->bigIncrements('equipment_id');
            $table->string('equipment_model');
            $table->unsignedBigInteger('device_id');
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
        Schema::dropIfExists('tbl_equipments');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateControlNoLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('control_no_locations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('general_area_id')->comment = 'Device ID';
            $table->string('control_no')->nullable();
            $table->string('location')->nullable();
            $table->unsignedTinyInteger('status')->default(1)->comment = '1-Active,2-Inactive';
            $table->unsignedTinyInteger('logdel')->default(0)->comment = '0-Show,1-Hide';
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
        Schema::dropIfExists('control_no_locations');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('device_id')->comment = 'Device ID';
            $table->string('checklist')->nullable();
            $table->string('requirement')->nullable();
            $table->unsignedTinyInteger('status')->default(1)->comment = '1-Active,2-Inactive';
            $table->unsignedTinyInteger('logdel')->default(0)->comment = '0-Show,1-Hide';
            $table->timestamps();

            // $table->foreign('device_id')->references('id')->on('device');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('check_lists');
    }
}

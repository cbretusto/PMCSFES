<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblChecksheets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_checksheets', function (Blueprint $table) {
            $table->bigIncrements('cheksheet_id');
            $table->string('checksheet_name');
            $table->string('date_inspected');
            $table->bigInteger('log_del')->default(0);
            $table->unsignedBigInteger('equipment_id');
            $table->unsignedTinyInteger('status')->default(2)->comment = '0-For Approval, 1-Approved, 2-Disapproved';
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('last_updated_by');
            $table->unsignedBigInteger('checked_by');
            $table->unsignedBigInteger('noted_by_supervisor');
            $table->unsignedBigInteger('noted_by_manager');
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
        Schema::dropIfExists('tbl_checksheets');
    }
}

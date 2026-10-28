<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblCriteria extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_criteria', function (Blueprint $table) {
            $table->bigIncrements('criteria_id');
            $table->string('checklist');
            $table->string('requirement');
            $table->string('status_good');
            $table->string('status_no_good');
            $table->string('remarks');
            $table->bigInteger('log_del')->default(0);
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
        Schema::dropIfExists('tbl_criteria');
    }
}

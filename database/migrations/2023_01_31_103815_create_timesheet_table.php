<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimesheetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timesheet', function (Blueprint $table) {
            $table->increments('TS_id');
            $table->varchar('User_login');
            $table->date('Date');
            $table->varchar('Customer_name');
            $table->varchar('CRQ_id');
            $table->varchar('Category');
            $table->varchar('Project');
            $table->varchar('Activity');
            $table->varchar('Normal_usagetime');
            $table->varchar('Start_ot');
            $table->varchar('End_ot');
            $table->varchar('OT');
            $table->varchar('Total');
            $table->varchar('Expense');
            $table->varchar('Expense2');
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
        Schema::dropIfExists('timesheet');
    }
}

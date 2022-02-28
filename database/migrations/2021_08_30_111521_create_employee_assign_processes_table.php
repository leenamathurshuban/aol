<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeAssignProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_assign_processes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('employees_id');
            $table->foreign('employees_id')->references('id')->on('employees')->onDelete('cascade');
           $table->unsignedBigInteger('assign_processes_id');
            $table->foreign('assign_processes_id')->references('id')->on('assign_processes')->onDelete('cascade');
            
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
        Schema::dropIfExists('employee_assign_processes');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeePayFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_pay_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emp_req_id');
            $table->foreign('emp_req_id')->references('id')->on('employee_pays')->onDelete('cascade');
            $table->string('emp_req_file_type')->nullable();
            $table->string('emp_req_file_path')->nullable();
            $table->text('emp_req_file_description')->nullable();
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
        Schema::dropIfExists('employee_pay_files');
    }
}

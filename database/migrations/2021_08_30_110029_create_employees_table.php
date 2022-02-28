<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('original_password');
            $table->string('mobile_code')->nullable();
            $table->string('mobile')->nullable();
            $table->string('phone')->nullable();
            $table->integer('status')->default('1')->comment('1 for active 2 for deactivate');
            $table->string('image')->nullable();
            $table->text('employee_code')->nullable();
            $table->text('tag')->nullable();
            $table->string('bank_account_type')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('ifsc')->nullable();
            $table->string('pan')->nullable();
            //$table->string('approver_manager')->nullable();
            $table->string('specified_person')->nullable();

            $table->text('address')->nullable();
            $table->string('location')->nullable();
            $table->string('zip')->nullable();
            $table->unsignedBigInteger('state_id');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->text('state_ary')->nullable();
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->text('city_ary')->nullable();
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->text('role_ary')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('user_ary')->nullable();
            $table->integer('approver_manager')->default('0');

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
        Schema::dropIfExists('employees');
    }
}

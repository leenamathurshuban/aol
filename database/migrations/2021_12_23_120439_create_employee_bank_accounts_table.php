<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeBankAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employees_id');
            $table->foreign('employees_id')->references('id')->on('employees')->onDelete('cascade');
            $table->string('bank_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('branch_address')->nullable();
            $table->string('branch_code')->nullable();
            $table->string('bank_account_holder')->nullable();
            $table->string('ifsc')->nullable();
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
        Schema::dropIfExists('employee_bank_accounts');
    }
}

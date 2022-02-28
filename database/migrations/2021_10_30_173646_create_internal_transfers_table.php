<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternalTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internal_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->nullable();
            $table->string('nature_of_request')->nullable();
            
            $table->integer('apex_id')->default(0);
            $table->text('apex_ary')->nullable();

            $table->integer('state_bank_id')->default(0);
            $table->text('state_bank_ary')->nullable();

            $table->string('bank_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('branch_address')->nullable();
            $table->string('branch_code')->nullable();
            $table->string('bank_account_holder')->nullable();
            $table->string('ifsc')->nullable();

            $table->string('project_name')->nullable();
            $table->string('reason')->nullable();
            $table->string('project_id')->nullable();
            $table->string('cost_center')->nullable();

            $table->integer('transfer_from')->default(0);
            $table->text('transfer_from_ary')->nullable();

            $table->integer('transfer_to')->default(0);
            $table->text('transfer_to_ary')->nullable();

            $table->integer('amount')->default('0');

            // requested employee
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->text('employee_ary')->nullable();
            $table->date('employee_date')->nullable();

            // account office
            $table->integer('account_dept_id')->default('0');
            $table->text('account_dept_ary')->nullable();
            $table->text('account_dept_comment')->nullable();
            $table->date('accountant_date')->nullable();

            // trust ofc
            $table->integer('trust_ofc_id')->default('0');
            $table->text('trust_ofc_ary')->nullable();
            $table->text('trust_ofc_comment')->nullable();
            $table->date('trust_date')->nullable();

            // payment ofc
            $table->integer('payment_ofc_id')->default('0');
            $table->text('payment_ofc_ary')->nullable();
            $table->text('payment_ofc_comment')->nullable();
            $table->date('payment_date')->nullable();

            $table->text('description')->nullable();
            $table->integer('status')->default('1');

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
        Schema::dropIfExists('internal_transfers');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeePaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_pays', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->nullable();
            $table->string('pay_for')->nullable();

            // pay for employee
            $table->unsignedBigInteger('pay_for_employee_id');
            $table->foreign('pay_for_employee_id')->references('id')->on('employees');
            $table->text('pay_for_employee_ary')->nullable();

            $table->string('address')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('ifsc')->nullable();
            $table->string('pan')->nullable();
            $table->string('specified_person')->nullable();

            $table->unsignedBigInteger('nature_of_claim_id');
            $table->foreign('nature_of_claim_id')->references('id')->on('claim_types');
            $table->text('nature_of_claim_ary')->nullable();

            $table->unsignedBigInteger('apexe_id');
            $table->foreign('apexe_id')->references('id')->on('apexes');
            $table->text('apexe_ary')->nullable();

            $table->integer('amount_requested')->default('0');
            $table->integer('amount_approved')->default('0');

            $table->text('description')->nullable();

            $table->integer('tds')->default('0');
            $table->integer('tds_amount')->default('0');
            $table->integer('tds_month')->default('0');

            $table->string('project_id')->nullable();
            $table->string('cost_center')->nullable();
            // requested employee
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->text('employee_ary')->nullable();
            // manager
            $table->integer('manager_id')->default('0');
            $table->text('manager_ary')->nullable();
            $table->text('manager_comment')->nullable();
            // account office
            $table->integer('account_dept_id')->default('0');
            $table->text('account_dept_ary')->nullable();
            $table->text('account_dept_comment')->nullable();
            // trust ofc
            $table->integer('trust_ofc_id')->default('0');
            $table->text('trust_ofc_ary')->nullable();
            $table->text('trust_ofc_comment')->nullable();
            // payment ofc
            $table->integer('payment_ofc_id')->default('0');
            $table->text('payment_ofc_ary')->nullable();
            $table->text('payment_ofc_comment')->nullable();
            // tds ofc
            $table->integer('tds_ofc_id')->default('0');
            $table->text('tds_ofc_ary')->nullable();
            $table->text('tds_ofc_comment')->nullable();

            $table->integer('status')->default('1');

            $table->text('item_detail')->nullable();


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
        Schema::dropIfExists('employee_pays');
    }
}

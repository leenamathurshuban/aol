<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBulkUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bulk_uploads', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->nullable();
            
            $table->integer('category')->default('0');
            $table->text('specify_detail')->nullable();

            $table->integer('bank_formate')->default('0');
            $table->integer('payment_type')->default('0');
            $table->text('payment_type_comment')->nullable();

            $table->string('specified_person')->nullable();
            $table->text('description')->nullable();

            // requested employee
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->text('employee_ary')->nullable();
            $table->date('employee_date')->nullable();
            // manager
            $table->integer('manager_id')->default('0');
            $table->text('manager_ary')->nullable();
            $table->text('manager_comment')->nullable();
            $table->date('manager_date')->nullable();
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
            
            $table->integer('status')->default('1');

            $table->text('item_detail')->nullable();
            $table->timestamps();

            $table->string('bulk_attachment_type')->nullable();
            $table->string('bulk_attachment_path')->nullable();
            $table->text('bulk_attachment_description')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bulk_uploads');
    }
}

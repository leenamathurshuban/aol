<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithoutPoInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('without_po_invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id');
            $table->foreign('vendor_id')->references('id')->on('vendors');
            $table->text('vendor_ary')->nullable();
            $table->integer('invoice_status')->default('1');
            $table->string('invoice_number')->nullable();
            $table->date('invoice_date')->nullable();

            $table->double('amount',10,2)->default('0');
            $table->double('tax',10,2)->default('0');
            $table->double('tax_amount',10,2)->default('0');


            $table->double('invoice_amount',10,2)->default('0');
            $table->string('po_file_type')->nullable();
            $table->string('invoice_file_path')->nullable();
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->text('employee_ary')->nullable();
            $table->integer('approver_manager')->default('0');
            $table->text('manager_ary')->nullable();
            $table->string('manager_comment')->nullable();
            $table->integer('approver_financer')->default('0');
            $table->text('financer_ary')->nullable();
            $table->string('financer_comment')->nullable();
            $table->integer('approver_trust')->default('0');
            $table->text('approver_ary')->nullable();
            $table->string('trust_comment')->nullable();
            $table->string('invoice_approval_date')->nullable();
            $table->text('form_by_account')->nullable();

            $table->string('advance_payment_mode')->nullable();
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
        Schema::dropIfExists('without_po_invoices');
    }
}

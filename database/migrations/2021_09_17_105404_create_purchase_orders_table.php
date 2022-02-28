<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->nullable();
            $table->string('temp_order_id')->nullable();
            $table->unsignedBigInteger('vendor_id');
            $table->foreign('vendor_id')->references('id')->on('vendors');
            $table->text('vendor_ary')->nullable();
            $table->date('po_start_date')->nullable();
            $table->date('po_end_date')->nullable();
            $table->integer('payment_method')->nullable();
            $table->string('nature_of_service')->nullable();
            
            $table->text('item_detail')->nullable();
            $table->double('total',10,2)->default('0');
            $table->double('discount',10,2)->default('0');
            $table->double('net_payable',10,2)->default('0');
            $table->string('advance_tds')->nullable();
            $table->text('service_detail')->nullable();
            $table->integer('status')->default('1')->comment('1 for active 2 for deactivate');
            $table->integer('user_id')->default('0');
            $table->text('user_ary')->nullable();
            $table->integer('account_status')->default('1');
            $table->integer('level2_user_id')->default('0');
            $table->text('level2_user_ary')->nullable();
            $table->text('account_status_level2_comment')->nullable();
            $table->integer('approved_user_id')->default('0');
            $table->text('approved_user_ary')->nullable();
            $table->text('account_status_level3_comment')->nullable();
            $table->text('po_description')->nullable();
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
        Schema::dropIfExists('purchase_orders');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentToInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            
            // payment ofc
            $table->integer('payment_ofc_id')->default('0');
            $table->text('payment_ofc_ary')->nullable();
            $table->text('payment_ofc_comment')->nullable();
            $table->date('payment_date')->nullable();
            // tds ofc
            $table->integer('tds_ofc_id')->default('0');
            $table->text('tds_ofc_ary')->nullable();
            $table->text('tds_ofc_comment')->nullable();
            $table->date('tds_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('payment_ofc_id');
            $table->dropColumn('payment_ofc_ary');
            $table->dropColumn('payment_ofc_comment');
            $table->dropColumn('payment_date');
            $table->dropColumn('tds_ofc_id');
            $table->dropColumn('tds_ofc_ary');
            $table->dropColumn('tds_ofc_comment');
            $table->dropColumn('tds_date');
        });
    }
}

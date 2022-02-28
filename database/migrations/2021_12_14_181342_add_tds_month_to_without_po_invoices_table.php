<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTdsMonthToWithoutPoInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('without_po_invoices', function (Blueprint $table) {
            $table->integer('tds')->default('0');
            $table->integer('tds_amount')->default('0');
            $table->integer('tds_month')->default('0');
            $table->integer('tds_payable')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('without_po_invoices', function (Blueprint $table) {
            $table->dropColumn('tds');
            $table->dropColumn('tds_amount');
            $table->dropColumn('tds_month');
            $table->dropColumn('tds_payable');
        });
    }
}

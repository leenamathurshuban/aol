<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentDateToWithoutPoInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('without_po_invoices', function (Blueprint $table) {
            $table->string('date_of_payment')->nullable();
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
            $table->dropColumn('date_of_payment');
        });
    }
}

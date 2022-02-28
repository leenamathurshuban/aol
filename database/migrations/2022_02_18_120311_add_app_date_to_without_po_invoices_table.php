<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAppDateToWithoutPoInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('without_po_invoices', function (Blueprint $table) {
            $table->date('manager_date')->nullable();
            $table->date('financer_date')->nullable();
            $table->date('account_date')->nullable();
            $table->date('trust_date')->nullable();
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
            $table->dropColumn('manager_date');
            $table->dropColumn('financer_date');
            $table->dropColumn('account_date');
            $table->dropColumn('trust_date');
        });
    }
}

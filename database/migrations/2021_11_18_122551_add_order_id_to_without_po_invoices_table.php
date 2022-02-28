<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderIdToWithoutPoInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('without_po_invoices', function (Blueprint $table) {
            $table->string('order_id')->nullable();
            $table->string('specified_person')->nullable()->comment('Yes or No');
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
            $table->dropColumn('order_id');
            $table->dropColumn('specified_person');
        });
    }
}

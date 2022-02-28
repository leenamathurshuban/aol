<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderIdToInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('order_id')->nullable();
            $table->string('specified_person')->nullable()->comment('Yes or No');
            $table->double('tds',10,2)->default('0');
            $table->double('tds_amount',10,2)->default('0');
            $table->double('tds_payable',10,2)->default('0');
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
            $table->dropColumn('order_id');
            $table->dropColumn('specified_person');
            $table->dropColumn('tds');
            $table->dropColumn('tds_amount');
            $table->dropColumn('tds_payable');
        });
    }
}

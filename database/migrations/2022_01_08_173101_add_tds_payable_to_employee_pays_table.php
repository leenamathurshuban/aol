<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTdsPayableToEmployeePaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_pays', function (Blueprint $table) {
            //tds_payable
            $table->integer('tds_payable')->default(0);
            $table->string('tds_month')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_pays', function (Blueprint $table) {
            $table->dropColumn('tds_payable');
            $table->integer('tds_month')->change();
        });
    }
}

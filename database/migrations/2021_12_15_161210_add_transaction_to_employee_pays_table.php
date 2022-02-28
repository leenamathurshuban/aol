<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransactionToEmployeePaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_pays', function (Blueprint $table) {
            $table->string('transaction_id')->nullable();
            $table->string('transaction_date')->nullable();
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
            $table->dropColumn('transaction_id');
            $table->dropColumn('transaction_date');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnRequiredTdsToEmployeePaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_pays', function (Blueprint $table) {
            $table->string('required_tds')->nullable()->comment('Yes or No');
            $table->string('sub_category')->nullable();
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
            $table->dropColumn('required_tds');
            $table->dropColumn('sub_category');
        });
    }
}

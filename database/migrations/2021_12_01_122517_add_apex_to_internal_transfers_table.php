<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApexToInternalTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('internal_transfers', function (Blueprint $table) {
            $table->integer('apexe_id')->default('0');
            $table->text('apexe_ary')->nullable();
            $table->text('form_by_account')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('internal_transfers', function (Blueprint $table) {
            $table->dropColumn('apexe_id');
            $table->dropColumn('apexe_ary');
            $table->dropColumn('form_by_account');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTdsToBulkUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bulk_uploads', function (Blueprint $table) {
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
        Schema::table('bulk_uploads', function (Blueprint $table) {
            $table->dropColumn('tds_ofc_id');
            $table->dropColumn('tds_ofc_ary');
            $table->dropColumn('tds_ofc_comment');
            $table->dropColumn('tds_date');
        });
    }
}

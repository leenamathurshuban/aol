<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderIdToBulkCsvUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bulk_csv_uploads', function (Blueprint $table) {
            $table->string('order_id')->nullable();
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
        Schema::table('bulk_csv_uploads', function (Blueprint $table) {
            $table->dropColumn('order_id');
            $table->dropColumn('transaction_id');
            $table->dropColumn('transaction_date');
        });
    }
}

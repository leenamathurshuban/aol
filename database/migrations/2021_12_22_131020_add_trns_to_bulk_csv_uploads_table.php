<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTrnsToBulkCsvUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bulk_csv_uploads', function (Blueprint $table) {
            $table->string('transaction_type')->nullable();
            $table->string('debit_account_no')->nullable();
            $table->string('ifsc')->nullable();
            $table->string('beneficiary_account_no')->nullable();
            $table->string('beneficiary_name')->nullable();
            $table->integer('amount')->default(0);
            $table->text('remarks_for_client')->nullable();
            $table->text('remarks_for_beneficiary')->nullable();
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
            $table->dropColumn('transaction_type');
            $table->dropColumn('debit_account_no');
            $table->dropColumn('ifsc');
            $table->dropColumn('beneficiary_account_no');
            $table->dropColumn('beneficiary_name');
            $table->dropColumn('amount');
            $table->dropColumn('remarks_for_client');
            $table->dropColumn('remarks_for_beneficiary');
        });
    }
}

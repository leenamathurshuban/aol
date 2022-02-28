<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBulkCsvUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bulk_csv_uploads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bulk_upload_id');
            $table->foreign('bulk_upload_id')->references('id')->on('bulk_uploads')->onDelete('cascade');
            $table->text('bulk_upload_data')->nullable();
            $table->string('account_no')->nullable();
            $table->string('branch_code')->nullable();
            $table->string('amt_date')->nullable();
            $table->integer('dr_amount')->default(0);
            $table->integer('cr_amount')->default(0);
            $table->string('refrence')->nullable();
            $table->text('description')->nullable();
            $table->string('pay_id')->nullable();
            $table->text('output_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bulk_csv_uploads');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBulkUploadFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bulk_upload_files', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('bulk_upload_id');
            $table->foreign('bulk_upload_id')->references('id')->on('bulk_uploads')->onDelete('cascade');
            $table->string('bulk_upload_file_type')->nullable();
            $table->string('bulk_upload_file_path')->nullable();
            $table->text('bulk_upload_file_description')->nullable();
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
        Schema::dropIfExists('bulk_upload_files');
    }
}

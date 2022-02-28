<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternalTransferFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internal_transfer_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('internal_transfer_id');
            $table->foreign('internal_transfer_id')->references('id')->on('internal_transfers')->onDelete('cascade');
            $table->string('internal_transfer_file_type')->nullable();
            $table->string('internal_transfer_file_path')->nullable();
            $table->text('internal_transfer_file_description')->nullable();
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
        Schema::dropIfExists('internal_transfer_files');
    }
}

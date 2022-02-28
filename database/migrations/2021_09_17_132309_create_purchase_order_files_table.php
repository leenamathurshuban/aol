<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('po_id');
            $table->foreign('po_id')->references('id')->on('purchase_orders')->onDelete('cascade');
            $table->string('po_file_type')->nullable();
            $table->string('po_file_path')->nullable();
            $table->text('po_file_description')->nullable();
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
        Schema::dropIfExists('purchase_order_files');
    }
}

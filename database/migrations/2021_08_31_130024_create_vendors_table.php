<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('original_password');
            $table->string('mobile_code')->nullable();
            $table->string('mobile')->nullable();
            $table->string('phone')->nullable();
            $table->integer('status')->default('1')->comment('1 for active 2 for deactivate');
            $table->string('image')->nullable();
            $table->string('bank_account_type')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('ifsc')->nullable();
            $table->string('pan')->nullable();
            $table->string('specified_person')->nullable();

            $table->text('address')->nullable();
            $table->string('location')->nullable();
            $table->string('zip')->nullable();
            $table->unsignedBigInteger('state_id');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->text('state_ary')->nullable();
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->text('city_ary')->nullable();

            $table->integer('vendor_type')->default('1')->comment('1 for employee 2 for vendor form');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('employees')->onDelete('cascade');
            $table->text('user_ary')->nullable();

            $table->text('constitution')->nullable();
            $table->text('specify_if_other')->nullable();
            $table->string('gst')->nullable();
            $table->string('pan_file')->nullable();
            $table->string('cancel_cheque_file')->nullable();
            $table->integer('account_status')->default('1');
            $table->text('account_status_comment')->nullable();
            $table->integer('approved_user_id')->default('0');
            $table->text('approved_user_ary')->nullable();
            $table->text('vendor_code')->nullable();

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
        Schema::dropIfExists('vendors');
    }
}

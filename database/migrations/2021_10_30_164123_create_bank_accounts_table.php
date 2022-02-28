<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('branch_address')->nullable();
            $table->string('branch_code')->nullable();
            $table->string('bank_account_holder')->nullable();
            $table->string('ifsc')->nullable();
            $table->string('slug');
            $table->integer('status')->default('1')->comment('1 for active 2 for deactivate');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_accounts');
    }
}

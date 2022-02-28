<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
             $table->string('title');
            $table->string('email');
            $table->string('mobile')->nullable();
            $table->string('phone')->nullable();

            $table->string('dark_logo')->nullable();
            $table->string('light_logo')->nullable();
            $table->string('favicon_icon')->nullable();

            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('pin_code')->nullable();
            $table->string('country')->nullable();

            $table->text('social_link')->nullable();
            $table->text('download_link')->nullable();
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
        Schema::dropIfExists('settings');
    }
}

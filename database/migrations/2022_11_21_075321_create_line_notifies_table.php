<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('line_notifies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('token_register');
            $table->string('token_withdraw');
            $table->string('token_deposit');
            $table->string('token_withdraw_confirm');
            $table->string('token_promotion');
            $table->string('token_report');
            $table->string('token_otp_transfer');
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
        Schema::dropIfExists('line_notifies');
    }
};

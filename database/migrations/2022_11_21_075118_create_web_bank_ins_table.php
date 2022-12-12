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
        Schema::create('web_bank_ins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bank_name');
            $table->string('bank_number');
            $table->integer('gateway_id')->unsigned();
            $table->string('logo');
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->foreign('gateway_id')->references('id')->on('gateways');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('web_bank_ins');
    }
};

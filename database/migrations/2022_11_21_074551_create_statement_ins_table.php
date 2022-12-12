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
        Schema::create('statement_ins', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('date_time');
            $table->string('bank_name');
            $table->string('bank_number');
            $table->decimal('amount',8,2);
            $table->string('info');
            $table->integer('gateway_id')->unsigned();  
            $table->string('uid',50)->unique();
            $table->boolean('status')->default(1);
            $table->string('operator');
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
        Schema::dropIfExists('statement_ins');
    }
};

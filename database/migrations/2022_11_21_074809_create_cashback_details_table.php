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
        Schema::create('cashback_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();  
            $table->decimal('amount',10,2);
            $table->decimal('percent',5,2);
            $table->integer('cashback_id')->unsigned();  
            $table->decimal('cashback_sum',5,2);
            $table->boolean('status')->default(1);
            $table->integer('type_cashback_id')->unsigned();  
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('cashback_id')->references('id')->on('cashbacks');
            $table->foreign('type_cashback_id')->references('id')->on('type_cashbacks');
        });
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cashback_details');
    }
};

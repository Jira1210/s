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
        Schema::create('conditions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('promotion_id')->unsigned();  
            $table->integer('activity_id')->unsigned();  
            $table->boolean('status')->default(1);  
            $table->string('other');  
            $table->integer('user_id')->unsigned();
            $table->decimal('turn_before',10,2);
            $table->decimal('turn_now',10,2);
            $table->decimal('turn_con',10,2);
            $table->dateTime('turn_before_datetime');
            $table->string('info');
            $table->integer('wheel_id')->unsigned();
            $table->timestamps();

            $table->foreign('promotion_id')->references('id')->on('promotions');
            $table->foreign('activity_id')->references('id')->on('activities');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('wheel_id')->references('id')->on('wheels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conditions');
    }
};

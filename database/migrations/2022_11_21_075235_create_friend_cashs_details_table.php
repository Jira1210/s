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
        Schema::create('friend_cashs_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('getfriend_id')->unsigned();
            $table->integer('amount');
            $table->decimal('percent',10,2);
            $table->decimal('commission',10,2);
            $table->integer('friend_cash_id')->unsigned()->nullable();
            $table->boolean('status');
            $table->integer('type_friend_commission_id')->unsigned();
            $table->timestamps();

            $table->foreign('getfriend_id')->references('id')->on('getfriends');
            $table->foreign('friend_cash_id')->references('id')->on('friend_cashes');
            $table->foreign('type_friend_commission_id')->references('id')->on('type_friend_commissions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('friend_cashs_details');
    }
};

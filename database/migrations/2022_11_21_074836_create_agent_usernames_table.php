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
        Schema::create('agent_usernames', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username_agent');
            $table->string('password');
            $table->integer('agent_id')->unsigned();  
            $table->integer('user_id')->unsigned();  
            $table->timestamps();

            $table->foreign('agent_id')->references('id')->on('agents');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agent_usernames');
    }
};

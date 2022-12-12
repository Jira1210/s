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
        Schema::create('getfriends', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_child_id')->unsigned();  
            $table->integer('user_parent_id')->unsigned();  
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->foreign('user_child_id')->references('id')->on('users');
            $table->foreign('user_parent_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('getfriends');
    }
};

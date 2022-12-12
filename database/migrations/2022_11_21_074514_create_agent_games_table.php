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
        Schema::create('agent_games', function (Blueprint $table) {
            $table->increments('id');
            $table->string('game_name');
            $table->string('provider');
            $table->integer('agent_id')->unsigned();  
            $table->string('game_code');
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->foreign('agent_id')->references('id')->on('agents');
      
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agent_games');
    }
};

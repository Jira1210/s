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
        Schema::create('friend_cashes', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('date_start');
            $table->datetime('date_end');
            $table->boolean('status')->default(1);
            $table->decimal('amount',10,2);
            $table->datetime('date_topay');
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
        Schema::dropIfExists('friend_cashes');
    }
};

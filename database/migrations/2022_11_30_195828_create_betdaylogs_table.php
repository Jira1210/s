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
        Schema::create('betdaylogs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username',30)->nullable();
            $table->decimal('turnover', 9, 2)->nullable();
            $table->decimal('valid_amount', 8, 2)->nullable();
            $table->decimal('winloss', 8, 2)->nullable();
            $table->decimal('commission', 7, 2)->nullable();
            $table->decimal('total', 8, 2)->nullable();
            $table->dateTime('datetime')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('betdaylogs');
    }
};

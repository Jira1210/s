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
        Schema::create('betlogs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lastedID',20)->nullable();
            $table->string('username',15)->nullable();
            $table->string('ref',50)->nullable();
            $table->string('provider',8)->nullable();
            $table->string('type',8)->nullable();
            $table->decimal('turnover', 7, 2)->nullable();
            $table->decimal('valid_amount', 7, 2)->nullable();
            $table->decimal('winloss', 7, 2)->nullable();
            $table->decimal('commission', 5, 2)->nullable();
            $table->decimal('total', 7, 2)->nullable();
            $table->dateTime('bettime')->nullable();
            $table->dateTime('caltime')->nullable();
            $table->string('hash',40)->nullable()->unique();
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
        Schema::dropIfExists('betlogs');
    }
};

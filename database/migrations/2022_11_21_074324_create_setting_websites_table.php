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
        Schema::create('setting_websites', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('detail');
            $table->string('notify');
            $table->string('line');
            $table->decimal('auto_withdraw_max',10,2)->default(5000);
            $table->decimal('withdraw_min',10,2)->default(0);
            $table->decimal('withdraw_max',10,2)->default(10000);
            $table->integer('withdraw_count_max')->default(15);
            $table->decimal('withdraw_sum_max',10,2)->default(20000);
            $table->decimal('turnover_clear',10,2);
            $table->decimal('friend_default',10,2);
            $table->boolean('friend_status')->default(1);
            $table->decimal('cashback_default',10,2);
            $table->boolean('cashback_status')->default(1);
            $table->boolean('turnover_status')->default(1);
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('setting_websites');
    }
};

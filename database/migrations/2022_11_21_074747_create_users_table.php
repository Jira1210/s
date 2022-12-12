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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tel')->unique();
            $table->string('name');
            $table->string('password');
            $table->integer('dimond')->default(0);      
            $table->integer('bank_id')->unsigned();
            $table->string('bank_number')->unique();
            $table->string('line')->nullable();
            $table->decimal('cashback_wallet',10,2)->default(0);
            $table->decimal('user_wallet',10,2)->default(0);
            $table->integer('reference_id')->unsigned();    
            $table->boolean('status')->default(1);
            $table->integer('point')->default(0);
            $table->dateTime('last_login')->nullable();
            $table->string('friend_link')->unique()->nullable();
            $table->decimal('friend_wallet',10,2)->default(0);
            $table->integer('setting_level_id')->unsigned()->default(1);
            $table->integer('setting_id')->unsigned()->default(1);
            $table->decimal('deposit_sum',10,2)->default(0);
            $table->decimal('withdraw_sum',10,2)->default(0);
            $table->integer('admin_id')->unsigned()->nullable();  
            $table->timestamps();     
            
            $table->foreign('bank_id')->references('id')->on('banks');
            $table->foreign('reference_id')->references('id')->on('referencetbs');
            $table->foreign('setting_level_id')->references('id')->on('setting_levels');
            $table->foreign('setting_id')->references('id')->on('Setting_websites');
            $table->foreign('admin_id')->references('id')->on('admins');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};

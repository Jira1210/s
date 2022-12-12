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
        Schema::create('withdraws', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();  
            $table->string('bank_name');  
            $table->string('bank_number');  
            $table->string('user_name');
            $table->decimal('amount',10,2);
            $table->integer('admin_id')->unsigned();
            $table->string('type');  
            $table->boolean('status')->default(1);  
            $table->integer('gateway_id')->unsigned();
            $table->datetime('datetime');
            $table->string('info');
            $table->integer('condition_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('admin_id')->references('id')->on('admins');
            $table->foreign('gateway_id')->references('id')->on('gateways');
            $table->foreign('condition_id')->references('id')->on('conditions');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('withdraws');
    }
};

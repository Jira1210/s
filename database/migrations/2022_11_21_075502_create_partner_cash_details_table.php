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
        Schema::create('partner_cash_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('getpartner_id')->unsigned();
            $table->decimal('amount',10,2);
            $table->decimal('percent',5,2);
            $table->decimal('commission',10,2);
            $table->integer('partner_cash_id')->unsigned();
            $table->boolean('status');
            $table->integer('type_Partner_commisson_id')->unsigned();
            $table->timestamps();

            $table->foreign('partner_cash_id')->references('id')->on('partner_cashes');
            $table->foreign('type_Partner_commisson_id')->references('id')->on('type_partner_commissions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partner_cash_details');
    }
};

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
        Schema::create('transfer_cash__sadmins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bank_name',30);
            $table->string('bank_number',14);
            $table->decimal('amount', 8, 2);
            $table->boolean('status')->default(1);
            $table->string('info',200)->nullable();
            $table->integer('admin_id')->unsigned();
            $table->timestamps();

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
        Schema::dropIfExists('transfer_cash__sadmins');
    }
};

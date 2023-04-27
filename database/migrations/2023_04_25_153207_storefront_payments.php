<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StorefrontPayments extends Migration
{
    public function up()
    {
        Schema::create('storefront_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->enum('status', ['success', 'pending', 'failed']);
            $table->float('amount');
            $table->string('reference');
            $table->string('method')->nullable();
            $table->string('bank')->nullable();
            $table->string('currency')->nullable();
            $table->string('gateway_response')->nullable();

            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('storefront_payments');
    }
}

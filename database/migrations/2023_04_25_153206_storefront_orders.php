<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StorefrontOrders extends Migration
{
    public function up()
    {
        Schema::create('storefront_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->string('customer_street');
            $table->string('customer_city');
            $table->string('customer_state');
            $table->string('customer_country');
            $table->string('reference');
            $table->enum('status', ['order placed', 'processing', 'shipped', 'delivered', 'cancelled'])->default('order placed');

            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('storefront_orders');
    }
}

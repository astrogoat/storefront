<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StorefrontSales extends Migration
{
    public function up()
    {
        Schema::create('storefront_sales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');

            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('storefront_orders_storefront_products');
    }
}

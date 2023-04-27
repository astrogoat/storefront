<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StorefrontCollectionStorefrontProduct extends Migration
{
    public function up()
    {
        Schema::create('storefront_collection_storefront_product', function (Blueprint $table) {
            $table->integer('collection_id');
            $table->integer('product_id');
            $table->integer('order');
        });
    }

    public function down()
    {
        Schema::dropIfExists('storefront_collection_storefront_product');
    }
}

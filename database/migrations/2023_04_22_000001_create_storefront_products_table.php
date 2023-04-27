<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStorefrontProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storefront_products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('layout')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->boolean('indexable')->default(true);
            $table->json('meta')->nullable();
            $table->json('options')->nullable();
            $table->string('type')->nullable();
            $table->string('vendor')->nullable();

            $table->float('price')->nullable();
            $table->string('sku')->nullable();
            $table->json('sizes')->nullable();
            $table->json('colors')->nullable();
            $table->json('extra')->nullable();

            $table->unsignedInteger('footer_id')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();

            $table->foreign('footer_id')->references('id')->on('footers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('storefront_products');
    }
}

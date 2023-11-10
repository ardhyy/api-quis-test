<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartVariantProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_variant_products', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('cart_id');
            $table->integer('variant_products_id');
        });

        Schema::table('cart_variant_products', function (Blueprint $table) {
            $table->foreign('cart_id')
                ->references('id')
                ->on('cart')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('variant_products_id')
                ->references('id')
                ->on('products_variant')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_variant_products');
    }
}

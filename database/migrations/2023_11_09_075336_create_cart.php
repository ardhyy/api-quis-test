<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->integer('id', true);
            $table->char('sales_id', 55);
            $table->integer('products_id');
            $table->integer('price')->length(15);
            $table->integer('variants_id');
        });

        Schema::table('cart', function (Blueprint $table) {
            $table->foreign('sales_id')
                ->references('id')
                ->on('sales')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::table('cart', function (Blueprint $table) {
            $table->foreign('products_id')
                ->references('id')
                ->on('products')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::table('cart', function (Blueprint $table) {
            $table->foreign('variants_id')
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
        Schema::dropIfExists('cart');
    }
}

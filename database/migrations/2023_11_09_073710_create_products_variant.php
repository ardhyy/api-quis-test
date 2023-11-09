<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsVariant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_variant', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('products');
            $table->string('name', 155);
            $table->integer('additional_price')->length(15);
        });

        Schema::table('products_variant', function (Blueprint $table) {
            $table->foreign('products')
                ->references('id')
                ->on('products')
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
        Schema::dropIfExists('products_variant');
    }
}

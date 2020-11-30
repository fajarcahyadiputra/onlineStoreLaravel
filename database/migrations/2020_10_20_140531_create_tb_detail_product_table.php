<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbDetailProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_detail_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('inventory_id');
            $table->decimal('price');
            $table->string('sub_sku');
            $table->decimal('weight')->nullable();
            $table->decimal('height')->nullable();
            $table->decimal('width')->nullable();
            $table->decimal('length')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('tb_products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_detail_product');
    }
}

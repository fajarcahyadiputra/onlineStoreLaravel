<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbVariantProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_attribute_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('detail_product_id');
            $table->integer('attribute');
            $table->integer('attribute_value');
            $table->timestamps();

            $table->foreign('detail_product_id')->references('id')->on('tb_detail_product')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_attribute_product');
    }
}

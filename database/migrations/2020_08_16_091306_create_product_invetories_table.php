<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductInvetoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_product_invetories', function (Blueprint $table) {
            $table->bigIncrements('id');
             $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('attribute_values_id');
            $table->integer('qty');
            $table->timestamps();

              $table->foreign('product_id')->references('id')->on('tb_products')->onDelete('cascade');
             $table->foreign('attribute_values_id')->references('id')->on('tb_attribute_values')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_product_invetories');
    }
}

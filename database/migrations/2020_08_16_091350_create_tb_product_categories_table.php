<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_product_categories', function (Blueprint $table) {
           $table->bigIncrements('id');
           $table->unsignedBigInteger('product_id');
           $table->unsignedBigInteger('category_id');
           $table->timestamps();

           $table->foreign('product_id')->references('id')->on('tb_products')->onDelete('cascade');
           $table->foreign('category_id')->references('id')->on('tb_categories')->onDelete('cascade');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_product_categories');
    }
}

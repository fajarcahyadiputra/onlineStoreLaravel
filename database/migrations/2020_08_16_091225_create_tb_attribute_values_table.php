<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbAttributeValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_attribute_values', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('attribute_id');
            $table->text('text_value')->nullable();
            $table->integer('integer_value')->nullable();
            $table->dateTime('date_time_value')->nullable();
            $table->date('date_value')->nullable();
            $table->decimal('float_value')->nullable();
            $table->text('json_value')->nullable();
            $table->timestamps();

             $table->foreign('product_id')->references('id')->on('tb_products')->onDelete('cascade');
             $table->foreign('attribute_id')->references('id')->on('tb_attributes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_attribute_values');
    }
}

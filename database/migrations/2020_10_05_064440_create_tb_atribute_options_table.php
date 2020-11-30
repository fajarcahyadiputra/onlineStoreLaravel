<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbAtributeOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_attribute_options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('attribute_id');
            $table->string('name');
            $table->timestamps();

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
        Schema::dropIfExists('tb_attribute_options');
    }
}

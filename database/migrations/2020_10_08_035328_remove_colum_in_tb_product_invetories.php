<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumInTbProductInvetories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_product_invetories', function (Blueprint $table) {
            $table->dropForeign(['attribute_values_id']);
            $table->dropColumn('attribute_values_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_product_invetories', function (Blueprint $table) {
            $table->usignedBigInteger('attribute_values_id');
            $table->foreign('attribute_values_id')->references('id')->on('tb_attribute_values')->onDelete('cascade');
        });
    }
}

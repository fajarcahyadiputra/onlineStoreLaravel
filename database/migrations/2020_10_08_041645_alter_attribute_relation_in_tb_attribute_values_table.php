<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAttributeRelationInTbAttributeValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_attribute_values', function (Blueprint $table) {
            $table->dropForeign('tb_attribute_values_attribute_id_foreign');
            $table->foreign('attribute_id')->references('id')->on('tb_attributes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_attribute_values', function (Blueprint $table) {
            $table->dropForeign('tb_attribute_values_attribute_id_foreign');
            $table->foreign('attribute_id')->references('id')->on('tb_attributes')->onDelete('cascade');
        });
    }
}

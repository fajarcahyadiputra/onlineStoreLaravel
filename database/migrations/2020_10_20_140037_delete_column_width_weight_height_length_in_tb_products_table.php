<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteColumnWidthWeightHeightLengthInTbProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_products', function (Blueprint $table) {
            $table->dropColumn('weight');
            $table->dropColumn('width');
            $table->dropColumn('length');
            $table->dropColumn('height');
            $table->dropColumn('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_products', function (Blueprint $table) {
            $table->decimal('weight')->after('slug');
            $table->decimal('height')->after('weight');
            $table->decimal('width')->after('height');
            $table->decimal('length')->after('width');
            $table->decimal('price')->after('length');
        });
    }
}

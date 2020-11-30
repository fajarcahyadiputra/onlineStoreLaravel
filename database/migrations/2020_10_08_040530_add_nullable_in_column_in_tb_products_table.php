<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNullableInColumnInTbProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_products', function (Blueprint $table) {
            $table->decimal('price', 15,2)->nullable()->change();
            $table->decimal('weight', 15,2)->nullable()->change();
            $table->text('short_description')->nullable()->change();
            $table->text('description')->nullable()->change();
            $table->integer('status')->nullable()->change();
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
            $table->decimal('price', 15,2);
            $table->decimal('weight', 15,2);
            $table->text('short_description');
            $table->text('description');
            $table->integer('status');
        });
    }
}

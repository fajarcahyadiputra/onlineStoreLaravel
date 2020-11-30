<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnInTbAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_attributes', function (Blueprint $table) {
            $table->string('type')->after('name');
            $table->string('validation')->after('type')->nullable();
            $table->boolean('is_required')->default(false)->after('validation');
            $table->boolean('is_unique')->default(false)->after('is_required');
            $table->boolean('is_filterable')->default(false)->after('is_unique');
            $table->boolean('is_configurable')->default(false)->after('is_filterable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_attributes', function (Blueprint $table) {
            $table->dropColumn(['type','validation','is_required','is_unique','is_filterable','is_configurable']);
        });
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSpecificationPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_specification', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('product_id')->unsigned()->index();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->integer('specification_id')->unsigned()->index();
            $table->foreign('specification_id')->references('id')->on('specifications')->onDelete('cascade');
            $table->string('attribute');
            $table->string('value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_specification', function (Blueprint $table) {
            $table->dropForeign('product_specification_product_id_foreign');
            $table->dropForeign('product_specification_specification_id_foreign');
        });

        Schema::drop('product_specification');
    }
}

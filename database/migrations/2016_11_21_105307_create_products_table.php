<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->increments('id');
            $table->integer('category_id')->unsigned();
             $table->foreign('category_id')->references('id')->on('categories');
            $table->string('image_path');
            $table->string('code')->unique();
            $table->string('title')->unique();
            $table->text('description');
            $table->decimal('price');
            $table->decimal('price_old')->nullable();
            $table->integer('storage');
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('products_category_id_foreign');
        });

        Schema::dropIfExists('products');
    }
}
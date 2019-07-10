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
            $table->string('code', 50)->unique();
            $table->string('title', 50);
            $table->text('description')->nullable();
            $table->integer('price');
            $table->integer('price_old')->nullable();
            $table->integer('stock');
            $table->integer('status');
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        Schema::dropIfExists('products');

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}

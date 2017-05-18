<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_product', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('order_id')->unsigned()->index();
            $table->foreign('order_id')->references('id')->on('orders');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('user_id')->on('orders');
            $table->integer('product_id')->unsigned()->index();
            $table->foreign('product_id')->references('id')->on('products');
            $table->integer('quantity')->default(1);
            $table->decimal('price');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_product', function (Blueprint $table) {
            $table->dropForeign('order_product_order_id_foreign');
            $table->dropForeign('order_product_user_id_foreign');
            $table->dropForeign('order_product_product_id_foreign');
        });

        Schema::dropIfExists('order_product');
    }
}

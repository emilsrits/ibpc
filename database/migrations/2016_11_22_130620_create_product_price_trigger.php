<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductPriceTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER save_old_price BEFORE UPDATE ON `products` FOR EACH ROW BEGIN
            IF NEW.price <> OLD.price THEN
                SET NEW.price_old = OLD.price;
            END IF;
            IF NEW.price >= OLD.price_old THEN
                SET NEW.price_old = NULL;
            END IF;
        END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `save_old_price`');
    }
}

<?php

use Illuminate\Database\Seeder;

class ProductPropertyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('product_property')->truncate();
        DB::table('product_property')->insert([
            [
                'product_id' => 1,
                'property_id' => 1,
                'value' => 'Asus'
            ],
            [
                'product_id' => 1,
                'property_id' => 3,
                'value' => 'PCI Express 3.0'
            ],
            [
                'product_id' => 1,
                'property_id' => 4,
                'value' => 'AMD'
            ],
            [
                'product_id' => 1,
                'property_id' => 5,
                'value' => 'Radeon RX 470'
            ],
            [
                'product_id' => 1,
                'property_id' => 6,
                'value' => '1270 MHz in OC mode'
            ],
            [
                'product_id' => 1,
                'property_id' => 7,
                'value' => '6600 MHz'
            ],
            [
                'product_id' => 1,
                'property_id' => 8,
                'value' => '4GB'
            ],
            [
                'product_id' => 1,
                'property_id' => 9,
                'value' => '256-Bit'
            ],
            [
                'product_id' => 1,
                'property_id' => 10,
                'value' => 'GDDR5'
            ]
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

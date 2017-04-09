<?php

use Illuminate\Database\Seeder;

class ProductSpecificationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('product_specification')->truncate();
        // Product-Specification table seeder
        DB::table('product_specification')->insert([
            [
                'product_id' => 1,
                'specification_id' => 1,
                'attribute' => 'Brand',
                'value' => 'Asus'
            ],
            [
                'product_id' => 1,
                'specification_id' => 2,
                'attribute' => 'Interface',
                'value' => 'PCI Express 3.0'
            ],
            [
                'product_id' => 1,
                'specification_id' => 3,
                'attribute' => 'Chipset Manufacturer',
                'value' => 'AMD'
            ],
            [
                'product_id' => 1,
                'specification_id' => 3,
                'attribute' => 'GPU',
                'value' => 'Radeon RX 470'
            ],
            [
                'product_id' => 1,
                'specification_id' => 3,
                'attribute' => 'Core Clock',
                'value' => '1270 MHz in OC mode'
            ],
            [
                'product_id' => 1,
                'specification_id' => 4,
                'attribute' => 'Effective Memory Clock',
                'value' => '6600 MHz'
            ],
            [
                'product_id' => 1,
                'specification_id' => 4,
                'attribute' => 'Memory Size',
                'value' => '4GB'
            ],
            [
                'product_id' => 1,
                'specification_id' => 4,
                'attribute' => 'Memory Interface',
                'value' => '256-Bit'
            ],
            [
                'product_id' => 1,
                'specification_id' => 4,
                'attribute' => 'Memory Type',
                'value' => 'GDDR5'
            ]
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

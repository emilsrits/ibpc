<?php

use Illuminate\Database\Seeder;

class CategoryProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('category_product')->truncate();
        // Product-Specification table seeder
        DB::table('category_product')->insert([
            [
                'category_id' => 7,
                'product_id' => 1
            ],
            [
                'category_id' => 7,
                'product_id' => 2
            ],
            [
                'category_id' => 7,
                'product_id' => 3
            ],
            [
                'category_id' => 7,
                'product_id' => 4
            ],
            [
                'category_id' => 7,
                'product_id' => 5
            ],
            [
                'category_id' => 7,
                'product_id' => 6
            ],
            [
                'category_id' => 7,
                'product_id' => 7
            ],
            [
                'category_id' => 7,
                'product_id' => 8
            ],
            [
                'category_id' => 7,
                'product_id' => 9
            ],
            [
                'category_id' => 4,
                'product_id' => 10
            ],
            [
                'category_id' => 4,
                'product_id' => 11
            ],
            [
                'category_id' => 4,
                'product_id' => 12
            ],
            [
                'category_id' => 4,
                'product_id' => 13
            ],
            [
                'category_id' => 4,
                'product_id' => 14
            ]
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

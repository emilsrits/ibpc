<?php

use Illuminate\Database\Seeder;

class CategorySpecificationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('category_specification')->truncate();
        // Category-Specification table seeder
        DB::table('category_specification')->insert([
            [
                'category_id' => 4,
                'specification_id' => 1
            ],
            [
                'category_id' => 4,
                'specification_id' => 2
            ],
            [
                'category_id' => 4,
                'specification_id' => 3
            ],
            [
                'category_id' => 4,
                'specification_id' => 4
            ],
            [
                'category_id' => 4,
                'specification_id' => 5
            ],
            [
                'category_id' => 4,
                'specification_id' => 6
            ]
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

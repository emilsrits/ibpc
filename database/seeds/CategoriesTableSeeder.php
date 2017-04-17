<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('categories')->truncate();
        // Categories table seeder
        DB::table('categories')->insert([
            [
                'title' => 'CPUs / Processors'
            ],
            [
                'title' => 'Motherboards'
            ],
            [
                'title' => 'Memory'
            ],
            [
                'title' => 'Video Cards'
            ],
            [
                'title' => 'Computer Cases'
            ],
            [
                'title' => 'Power Supplies'
            ],
            [
                'title' => 'Fans & PC Cooling'
            ],
            [
                'title' => 'SSDs'
            ],
            [
                'title' => 'CD / DVD / Blu-Ray Burners & Media'
            ],
            [
                'title' => 'Sound Cards'
            ]
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
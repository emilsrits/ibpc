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
	            'title' => 'Video Cards'
            ]
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
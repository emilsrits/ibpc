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
        $category = new \App\Category([
            'title' => 'CPUs / Processors',
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Category([
            'title' => 'Motherboards',
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Category([
            'title' => 'Memory',
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Category([
            'title' => 'Video Cards',
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Category([
            'title' => 'Computer Cases',
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Category([
            'title' => 'Power Supplies',
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Category([
            'title' => 'Fans & PC Cooling',
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Category([
            'title' => 'SSDs',
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Category([
            'title' => 'CD / DVD / Blu-Ray Burners & Media',
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Category([
            'title' => 'Sound Cards',
            'status' => 1
        ]);
        $category->save();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
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
            'title' => 'Core Components',
            'parent' => 1,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Category([
            'title' => 'Cases & Cooling',
            'parent' => 1,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Category([
            'title' => 'Storage Devices',
            'parent' => 1,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Category([
            'title' => 'CPUs / Processors',
            'parent_id' => 1,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Category([
            'title' => 'Motherboards',
            'parent_id' => 1,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Category([
            'title' => 'Memory',
            'parent_id' => 1,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Category([
            'title' => 'Video Cards',
            'parent_id' => 1,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Category([
            'title' => 'Computer Cases',
            'parent_id' => 2,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Category([
            'title' => 'Power Supplies',
            'parent_id' => 1,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Category([
            'title' => 'Fans & PC Cooling',
            'parent_id' => 2,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Category([
            'title' => 'SSDs',
            'parent_id' => 3,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Category([
            'title' => 'HDDs',
            'parent_id' => 3,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Category([
            'title' => 'CD / DVD / Blu-Ray Burners & Media',
            'parent_id' => 3,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Category([
            'title' => 'Sound Cards',
            'parent_id' => 1,
            'status' => 1
        ]);
        $category->save();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
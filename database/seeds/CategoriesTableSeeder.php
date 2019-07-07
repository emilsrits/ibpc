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
        $category = new \App\Models\Category([
            'title' => 'Core Components',
            'slug' => 'core-components',
            'top_level' => 1,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Models\Category([
            'title' => 'Cases & Cooling',
            'slug' => 'cases-cooling',
            'top_level' => 1,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Models\Category([
            'title' => 'Storage Devices',
            'slug' => 'storage-devices',
            'top_level' => 1,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Models\Category([
            'title' => 'CPUs / Processors',
            'slug' => 'cpus-processors',
            'top_level' => 0,
            'parent_id' => 1,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Models\Category([
            'title' => 'Motherboards',
            'slug' => 'motherboards',
            'top_level' => 0,
            'parent_id' => 1,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Models\Category([
            'title' => 'Memory',
            'slug' => 'memory',
            'top_level' => 0,
            'parent_id' => 1,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Models\Category([
            'title' => 'Video Cards',
            'slug' => 'video-cards',
            'top_level' => 0,
            'parent_id' => 1,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Models\Category([
            'title' => 'Computer Cases',
            'slug' => 'computer-cases',
            'top_level' => 0,
            'parent_id' => 2,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Models\Category([
            'title' => 'Power Supplies',
            'slug' => 'power-supplies',
            'top_level' => 0,
            'parent_id' => 1,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Models\Category([
            'title' => 'Fans & PC Cooling',
            'slug' => 'fans-pc-cooling',
            'top_level' => 0,
            'parent_id' => 2,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Models\Category([
            'title' => 'SSDs',
            'slug' => 'ssds',
            'top_level' => 0,
            'parent_id' => 3,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Models\Category([
            'title' => 'HDDs',
            'slug' => 'hdds',
            'top_level' => 0,
            'parent_id' => 3,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Models\Category([
            'title' => 'CD / DVD / Blu-Ray Burners & Media',
            'slug' => 'cd-dvd-blu-ray-burners-media',
            'top_level' => 0,
            'parent_id' => 3,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Models\Category([
            'title' => 'Sound Cards',
            'slug' => 'sound-cards',
            'top_level' => 0,
            'parent_id' => 1,
            'status' => 1
        ]);
        $category->save();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
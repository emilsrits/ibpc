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
            'parent' => 1,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Models\Category([
            'title' => 'Cases & Cooling',
            'slug' => 'cases-cooling',
            'parent' => 1,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Models\Category([
            'title' => 'Storage Devices',
            'slug' => 'storage-devices',
            'parent' => 1,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Models\Category([
            'title' => 'CPUs / Processors',
            'slug' => 'cpus-processors',
            'parent' => 0,
            'parent_id' => 1,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Models\Category([
            'title' => 'Motherboards',
            'slug' => 'motherboards',
            'parent' => 0,
            'parent_id' => 1,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Models\Category([
            'title' => 'Memory',
            'slug' => 'memory',
            'parent' => 0,
            'parent_id' => 1,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Models\Category([
            'title' => 'Video Cards',
            'slug' => 'video-cards',
            'parent' => 0,
            'parent_id' => 1,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Models\Category([
            'title' => 'Computer Cases',
            'slug' => 'computer-cases',
            'parent' => 0,
            'parent_id' => 2,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Models\Category([
            'title' => 'Power Supplies',
            'slug' => 'power-supplies',
            'parent' => 0,
            'parent_id' => 1,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Models\Category([
            'title' => 'Fans & PC Cooling',
            'slug' => 'fans-pc-cooling',
            'parent' => 0,
            'parent_id' => 2,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Models\Category([
            'title' => 'SSDs',
            'slug' => 'ssds',
            'parent' => 0,
            'parent_id' => 3,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Models\Category([
            'title' => 'HDDs',
            'slug' => 'hdds',
            'parent' => 0,
            'parent_id' => 3,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Models\Category([
            'title' => 'CD / DVD / Blu-Ray Burners & Media',
            'slug' => 'cd-dvd-blu-ray-burners-media',
            'parent' => 0,
            'parent_id' => 3,
            'status' => 1
        ]);
        $category->save();

        $category = new \App\Models\Category([
            'title' => 'Sound Cards',
            'slug' => 'sound-cards',
            'parent' => 0,
            'parent_id' => 1,
            'status' => 1
        ]);
        $category->save();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
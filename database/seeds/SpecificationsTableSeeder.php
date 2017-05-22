<?php

use Illuminate\Database\Seeder;

class SpecificationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('specifications')->truncate();
        // Specification table seeder
        $specification = new \App\Specification([
            'slug' => 'model',
            'name' => 'Model'
        ]);
        $specification->save(); // 1

        $specification = new \App\Specification([
            'slug' => 'interface',
            'name' => 'Interface'
        ]);
        $specification->save(); // 2

        $specification = new \App\Specification([
            'slug' => 'chipset',
            'name' => 'Chipset'
        ]);
        $specification->save(); // 3

        $specification = new \App\Specification([
            'slug' => 'memory',
            'name' => 'Memory'
        ]);
        $specification->save(); // 4

        $specification = new \App\Specification([
            'slug' => 'ports',
            'name' => 'Ports'
        ]);
        $specification->save(); // 5

        $specification = new \App\Specification([
            'slug' => 'gpu details',
            'name' => 'Details'
        ]);
        $specification->save(); // 6

        $specification = new \App\Specification([
            'slug' => 'gpu dimensions',
            'name' => 'Form Factor & Dimensions'
        ]);
        $specification->save(); // 7

        $specification = new \App\Specification([
            'slug' => 'cpu model',
            'name' => 'Model'
        ]);
        $specification->save(); // 8

        $specification = new \App\Specification([
            'slug' => 'cpu socket type',
            'name' => 'CPU Socket Type'
        ]);
        $specification->save(); // 9

        $specification = new \App\Specification([
            'slug' => 'cpu details',
            'name' => 'Details'
        ]);
        $specification->save(); // 10

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

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
            'slug' => 'Model',
            'name' => 'Model'
        ]);
        $specification->save();

        $specification = new \App\Specification([
            'slug' => 'Interface',
            'name' => 'Interface'
        ]);
        $specification->save();

        $specification = new \App\Specification([
            'slug' => 'Chipset',
            'name' => 'Chipset'
        ]);
        $specification->save();

        $specification = new \App\Specification([
            'slug' => 'Memory',
            'name' => 'Memory'
        ]);
        $specification->save();

        $specification = new \App\Specification([
            'slug' => 'Ports',
            'name' => 'Ports'
        ]);
        $specification->save();

        $specification = new \App\Specification([
            'slug' => 'Details',
            'name' => 'Details'
        ]);
        $specification->save();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

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

        $specification = new \App\Specification([
            'slug' => 'mb supported cpu',
            'name' => 'Supported CPU'
        ]);
        $specification->save(); // 11

        $specification = new \App\Specification([
            'slug' => 'mb chipset',
            'name' => 'Chipsets'
        ]);
        $specification->save(); // 12

        $specification = new \App\Specification([
            'slug' => 'mb memory',
            'name' => 'Memory'
        ]);
        $specification->save(); // 13

        $specification = new \App\Specification([
            'slug' => 'mb expansion slots',
            'name' => 'Expansion Slots'
        ]);
        $specification->save(); // 14

        $specification = new \App\Specification([
            'slug' => 'mb storage',
            'name' => 'Storage Devices'
        ]);
        $specification->save(); // 15

        $specification = new \App\Specification([
            'slug' => 'mb video',
            'name' => 'Onboard Video'
        ]);
        $specification->save(); // 16

        $specification = new \App\Specification([
            'slug' => 'mb audio',
            'name' => 'Onboard Audio'
        ]);
        $specification->save(); // 17

        $specification = new \App\Specification([
            'slug' => 'mb lan',
            'name' => 'Onboard LAN'
        ]);
        $specification->save(); // 18

        $specification = new \App\Specification([
            'slug' => 'mb ports',
            'name' => 'Rear Panel Ports'
        ]);
        $specification->save(); // 19

        $specification = new \App\Specification([
            'slug' => 'mb physical',
            'name' => 'Physical Spec'
        ]);
        $specification->save(); // 20

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

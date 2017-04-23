<?php

use Illuminate\Database\Seeder;

class AttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('attributes')->truncate();
        // Specification table seeder
        $attribute = new \App\Attribute([
            'specification_id' => 1,
            'name' => 'Brand'
        ]);
        $attribute->save();

        $attribute = new \App\Attribute([
            'specification_id' => 2,
            'name' => 'Interface'
        ]);
        $attribute->save();

        $attribute = new \App\Attribute([
            'specification_id' => 3,
            'name' => 'Chipset Manufacturer'
        ]);
        $attribute->save();

        $attribute = new \App\Attribute([
            'specification_id' => 3,
            'name' => 'GPU'
        ]);
        $attribute->save();

        $attribute = new \App\Attribute([
            'specification_id' => 3,
            'name' => 'Core Clock'
        ]);
        $attribute->save();

        $attribute = new \App\Attribute([
            'specification_id' => 4,
            'name' => 'Effective Memory Clock'
        ]);
        $attribute->save();

        $attribute = new \App\Attribute([
            'specification_id' => 4,
            'name' => 'Memory Size'
        ]);
        $attribute->save();

        $attribute = new \App\Attribute([
            'specification_id' => 4,
            'name' => 'Memory Interface'
        ]);
        $attribute->save();

        $attribute = new \App\Attribute([
            'specification_id' => 4,
            'name' => 'Memory Type'
        ]);
        $attribute->save();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

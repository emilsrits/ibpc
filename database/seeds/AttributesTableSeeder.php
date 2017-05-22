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
        $attribute->save(); // 1

        $attribute = new \App\Attribute([
            'specification_id' => 1,
            'name' => 'Model'
        ]);
        $attribute->save(); // 2

        $attribute = new \App\Attribute([
            'specification_id' => 2,
            'name' => 'Interface'
        ]);
        $attribute->save(); // 3

        $attribute = new \App\Attribute([
            'specification_id' => 3,
            'name' => 'Chipset Manufacturer'
        ]);
        $attribute->save(); // 4

        $attribute = new \App\Attribute([
            'specification_id' => 3,
            'name' => 'GPU'
        ]);
        $attribute->save(); // 5

        $attribute = new \App\Attribute([
            'specification_id' => 3,
            'name' => 'Core Clock'
        ]);
        $attribute->save(); // 6

        $attribute = new \App\Attribute([
            'specification_id' => 4,
            'name' => 'Effective Memory Clock'
        ]);
        $attribute->save(); // 7

        $attribute = new \App\Attribute([
            'specification_id' => 4,
            'name' => 'Memory Size'
        ]);
        $attribute->save(); // 8

        $attribute = new \App\Attribute([
            'specification_id' => 4,
            'name' => 'Memory Interface'
        ]);
        $attribute->save(); // 9

        $attribute = new \App\Attribute([
            'specification_id' => 4,
            'name' => 'Memory Type'
        ]);
        $attribute->save(); // 10

        $attribute = new \App\Attribute([
            'specification_id' => 5,
            'name' => 'HDMI'
        ]);
        $attribute->save(); // 11

        $attribute = new \App\Attribute([
            'specification_id' => 5,
            'name' => 'DisplayPort'
        ]);
        $attribute->save(); // 12

        $attribute = new \App\Attribute([
            'specification_id' => 5,
            'name' => 'DVI'
        ]);
        $attribute->save(); // 13

        $attribute = new \App\Attribute([
            'specification_id' => 6,
            'name' => 'Max Resolution'
        ]);
        $attribute->save(); // 14

        $attribute = new \App\Attribute([
            'specification_id' => 6,
            'name' => 'CrossFireX Support'
        ]);
        $attribute->save(); // 15

        $attribute = new \App\Attribute([
            'specification_id' => 6,
            'name' => 'SLI Support'
        ]);
        $attribute->save(); // 16

        $attribute = new \App\Attribute([
            'specification_id' => 6,
            'name' => 'Cooler'
        ]);
        $attribute->save(); // 17

        $attribute = new \App\Attribute([
            'specification_id' => 6,
            'name' => 'Power Connector'
        ]);
        $attribute->save(); // 18

        $attribute = new \App\Attribute([
            'specification_id' => 9,
            'name' => 'CPU Socket Type'
        ]);
        $attribute->save(); // 19

        $attribute = new \App\Attribute([
            'specification_id' => 3,
            'name' => 'Boost Clock'
        ]);
        $attribute->save(); // 20

        $attribute = new \App\Attribute([
            'specification_id' => 3,
            'name' => 'CUDA Cores'
        ]);
        $attribute->save(); // 21

        $attribute = new \App\Attribute([
            'specification_id' => 3,
            'name' => 'Stream Processors'
        ]);
        $attribute->save(); // 22

        $attribute = new \App\Attribute([
            'specification_id' => 8,
            'name' => 'Brand'
        ]);
        $attribute->save(); // 23

        $attribute = new \App\Attribute([
            'specification_id' => 8,
            'name' => 'Model'
        ]);
        $attribute->save(); // 24

        $attribute = new \App\Attribute([
            'specification_id' => 8,
            'name' => 'Processor Type'
        ]);
        $attribute->save(); // 25

        $attribute = new \App\Attribute([
            'specification_id' => 8,
            'name' => 'Series'
        ]);
        $attribute->save(); // 26

        $attribute = new \App\Attribute([
            'specification_id' => 7,
            'name' => 'Max GPU Length'
        ]);
        $attribute->save(); // 27

        $attribute = new \App\Attribute([
            'specification_id' => 7,
            'name' => 'Card Dimensions (L x H)'
        ]);
        $attribute->save(); // 28

        $attribute = new \App\Attribute([
            'specification_id' => 7,
            'name' => 'Slot Width'
        ]);
        $attribute->save(); // 29

        $attribute = new \App\Attribute([
            'specification_id' => 10,
            'name' => 'Core Name'
        ]);
        $attribute->save(); // 30

        $attribute = new \App\Attribute([
            'specification_id' => 10,
            'name' => '# of Cores'
        ]);
        $attribute->save(); // 31

        $attribute = new \App\Attribute([
            'specification_id' => 10,
            'name' => '# of Threads'
        ]);
        $attribute->save(); // 32

        $attribute = new \App\Attribute([
            'specification_id' => 10,
            'name' => 'Operating Frequency'
        ]);
        $attribute->save(); // 33

        $attribute = new \App\Attribute([
            'specification_id' => 10,
            'name' => 'Max Turbo Frequency'
        ]);
        $attribute->save(); // 34

        $attribute = new \App\Attribute([
            'specification_id' => 10,
            'name' => 'L2 Cache'
        ]);
        $attribute->save(); // 35

        $attribute = new \App\Attribute([
            'specification_id' => 10,
            'name' => 'L3 Cache'
        ]);
        $attribute->save(); // 36

        $attribute = new \App\Attribute([
            'specification_id' => 10,
            'name' => 'Manufacturing Tech'
        ]);
        $attribute->save(); // 37

        $attribute = new \App\Attribute([
            'specification_id' => 10,
            'name' => '64-Bit Support'
        ]);
        $attribute->save(); // 38

        $attribute = new \App\Attribute([
            'specification_id' => 10,
            'name' => 'Thermal Design Power'
        ]);
        $attribute->save(); // 39

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

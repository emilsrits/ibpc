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
        // Attributes table seeder
        $attribute = new \App\Models\Attribute([
            'specification_id' => 1,
            'name' => 'Brand'
        ]);
        $attribute->save(); // 1

        $attribute = new \App\Models\Attribute([
            'specification_id' => 1,
            'name' => 'Model'
        ]);
        $attribute->save(); // 2

        $attribute = new \App\Models\Attribute([
            'specification_id' => 2,
            'name' => 'Interface'
        ]);
        $attribute->save(); // 3

        $attribute = new \App\Models\Attribute([
            'specification_id' => 3,
            'name' => 'Chipset Manufacturer'
        ]);
        $attribute->save(); // 4

        $attribute = new \App\Models\Attribute([
            'specification_id' => 3,
            'name' => 'GPU'
        ]);
        $attribute->save(); // 5

        $attribute = new \App\Models\Attribute([
            'specification_id' => 3,
            'name' => 'Core Clock'
        ]);
        $attribute->save(); // 6

        $attribute = new \App\Models\Attribute([
            'specification_id' => 4,
            'name' => 'Effective Memory Clock'
        ]);
        $attribute->save(); // 7

        $attribute = new \App\Models\Attribute([
            'specification_id' => 4,
            'name' => 'Memory Size'
        ]);
        $attribute->save(); // 8

        $attribute = new \App\Models\Attribute([
            'specification_id' => 4,
            'name' => 'Memory Interface'
        ]);
        $attribute->save(); // 9

        $attribute = new \App\Models\Attribute([
            'specification_id' => 4,
            'name' => 'Memory Type'
        ]);
        $attribute->save(); // 10

        $attribute = new \App\Models\Attribute([
            'specification_id' => 5,
            'name' => 'HDMI'
        ]);
        $attribute->save(); // 11

        $attribute = new \App\Models\Attribute([
            'specification_id' => 5,
            'name' => 'DisplayPort'
        ]);
        $attribute->save(); // 12

        $attribute = new \App\Models\Attribute([
            'specification_id' => 5,
            'name' => 'DVI'
        ]);
        $attribute->save(); // 13

        $attribute = new \App\Models\Attribute([
            'specification_id' => 6,
            'name' => 'Max Resolution'
        ]);
        $attribute->save(); // 14

        $attribute = new \App\Models\Attribute([
            'specification_id' => 6,
            'name' => 'CrossFireX Support'
        ]);
        $attribute->save(); // 15

        $attribute = new \App\Models\Attribute([
            'specification_id' => 6,
            'name' => 'SLI Support'
        ]);
        $attribute->save(); // 16

        $attribute = new \App\Models\Attribute([
            'specification_id' => 6,
            'name' => 'Cooler'
        ]);
        $attribute->save(); // 17

        $attribute = new \App\Models\Attribute([
            'specification_id' => 6,
            'name' => 'Power Connector'
        ]);
        $attribute->save(); // 18

        $attribute = new \App\Models\Attribute([
            'specification_id' => 9,
            'name' => 'CPU Socket Type'
        ]);
        $attribute->save(); // 19

        $attribute = new \App\Models\Attribute([
            'specification_id' => 3,
            'name' => 'Boost Clock'
        ]);
        $attribute->save(); // 20

        $attribute = new \App\Models\Attribute([
            'specification_id' => 3,
            'name' => 'CUDA Cores'
        ]);
        $attribute->save(); // 21

        $attribute = new \App\Models\Attribute([
            'specification_id' => 3,
            'name' => 'Stream Processors'
        ]);
        $attribute->save(); // 22

        $attribute = new \App\Models\Attribute([
            'specification_id' => 8,
            'name' => 'Brand'
        ]);
        $attribute->save(); // 23

        $attribute = new \App\Models\Attribute([
            'specification_id' => 8,
            'name' => 'Model'
        ]);
        $attribute->save(); // 24

        $attribute = new \App\Models\Attribute([
            'specification_id' => 8,
            'name' => 'Processor Type'
        ]);
        $attribute->save(); // 25

        $attribute = new \App\Models\Attribute([
            'specification_id' => 8,
            'name' => 'Series'
        ]);
        $attribute->save(); // 26

        $attribute = new \App\Models\Attribute([
            'specification_id' => 7,
            'name' => 'Max GPU Length'
        ]);
        $attribute->save(); // 27

        $attribute = new \App\Models\Attribute([
            'specification_id' => 7,
            'name' => 'Card Dimensions (L x H)'
        ]);
        $attribute->save(); // 28

        $attribute = new \App\Models\Attribute([
            'specification_id' => 7,
            'name' => 'Slot Width'
        ]);
        $attribute->save(); // 29

        $attribute = new \App\Models\Attribute([
            'specification_id' => 10,
            'name' => 'Core Name'
        ]);
        $attribute->save(); // 30

        $attribute = new \App\Models\Attribute([
            'specification_id' => 10,
            'name' => '# of Cores'
        ]);
        $attribute->save(); // 31

        $attribute = new \App\Models\Attribute([
            'specification_id' => 10,
            'name' => '# of Threads'
        ]);
        $attribute->save(); // 32

        $attribute = new \App\Models\Attribute([
            'specification_id' => 10,
            'name' => 'Operating Frequency'
        ]);
        $attribute->save(); // 33

        $attribute = new \App\Models\Attribute([
            'specification_id' => 10,
            'name' => 'Max Turbo Frequency'
        ]);
        $attribute->save(); // 34

        $attribute = new \App\Models\Attribute([
            'specification_id' => 10,
            'name' => 'L2 Cache'
        ]);
        $attribute->save(); // 35

        $attribute = new \App\Models\Attribute([
            'specification_id' => 10,
            'name' => 'L3 Cache'
        ]);
        $attribute->save(); // 36

        $attribute = new \App\Models\Attribute([
            'specification_id' => 10,
            'name' => 'Manufacturing Tech'
        ]);
        $attribute->save(); // 37

        $attribute = new \App\Models\Attribute([
            'specification_id' => 10,
            'name' => '64-Bit Support'
        ]);
        $attribute->save(); // 38

        $attribute = new \App\Models\Attribute([
            'specification_id' => 10,
            'name' => 'Hyper-Threading Support'
        ]);
        $attribute->save(); // 39

        $attribute = new \App\Models\Attribute([
            'specification_id' => 10,
            'name' => 'Integrated Graphics'
        ]);
        $attribute->save(); // 40

        $attribute = new \App\Models\Attribute([
            'specification_id' => 10,
            'name' => 'Graphics Base Frequency'
        ]);
        $attribute->save(); // 41

        $attribute = new \App\Models\Attribute([
            'specification_id' => 10,
            'name' => 'Graphics Max Dynamic Frequency'
        ]);
        $attribute->save(); // 42

        $attribute = new \App\Models\Attribute([
            'specification_id' => 10,
            'name' => 'PCI Express Revision'
        ]);
        $attribute->save(); // 43

        $attribute = new \App\Models\Attribute([
            'specification_id' => 10,
            'name' => 'Max Number of PCI Express Lanes'
        ]);
        $attribute->save(); // 44

        $attribute = new \App\Models\Attribute([
            'specification_id' => 10,
            'name' => 'Thermal Design Power'
        ]);
        $attribute->save(); // 45

        $attribute = new \App\Models\Attribute([
            'specification_id' => 10,
            'name' => 'Cooling Device'
        ]);
        $attribute->save(); // 46

        $attribute = new \App\Models\Attribute([
            'specification_id' => 11,
            'name' => 'CPU Socket Type'
        ]);
        $attribute->save(); // 47

        $attribute = new \App\Models\Attribute([
            'specification_id' => 11,
            'name' => 'CPU Type'
        ]);
        $attribute->save(); // 48

        $attribute = new \App\Models\Attribute([
            'specification_id' => 12,
            'name' => 'Chipset'
        ]);
        $attribute->save(); // 49

        $attribute = new \App\Models\Attribute([
            'specification_id' => 16,
            'name' => 'Onboard Video Chipset'
        ]);
        $attribute->save(); // 50

        $attribute = new \App\Models\Attribute([
            'specification_id' => 13,
            'name' => 'Number of Memory Slots'
        ]);
        $attribute->save(); // 51

        $attribute = new \App\Models\Attribute([
            'specification_id' => 13,
            'name' => 'Memory Standard'
        ]);
        $attribute->save(); // 52

        $attribute = new \App\Models\Attribute([
            'specification_id' => 13,
            'name' => 'Maximum Memory Supported'
        ]);
        $attribute->save(); // 53

        $attribute = new \App\Models\Attribute([
            'specification_id' => 13,
            'name' => 'Channel Supported'
        ]);
        $attribute->save(); // 54

        $attribute = new \App\Models\Attribute([
            'specification_id' => 14,
            'name' => 'PCI Express x1'
        ]);
        $attribute->save(); // 55

        $attribute = new \App\Models\Attribute([
            'specification_id' => 14,
            'name' => 'PCI Express 2.0 x16'
        ]);
        $attribute->save(); // 56

        $attribute = new \App\Models\Attribute([
            'specification_id' => 14,
            'name' => 'PCI Express 3.0 x16'
        ]);
        $attribute->save(); // 57

        $attribute = new \App\Models\Attribute([
            'specification_id' => 15,
            'name' => 'SATA 1/2'
        ]);
        $attribute->save(); // 58

        $attribute = new \App\Models\Attribute([
            'specification_id' => 15,
            'name' => 'SATA 3'
        ]);
        $attribute->save(); // 59

        $attribute = new \App\Models\Attribute([
            'specification_id' => 15,
            'name' => 'SATA RAID'
        ]);
        $attribute->save(); // 60

        $attribute = new \App\Models\Attribute([
            'specification_id' => 17,
            'name' => 'Audio Chipset'
        ]);
        $attribute->save(); // 61

        $attribute = new \App\Models\Attribute([
            'specification_id' => 17,
            'name' => 'Audio Channels'
        ]);
        $attribute->save(); // 62

        $attribute = new \App\Models\Attribute([
            'specification_id' => 18,
            'name' => 'LAN Chipset'
        ]);
        $attribute->save(); // 63

        $attribute = new \App\Models\Attribute([
            'specification_id' => 18,
            'name' => 'Max LAN Speed'
        ]);
        $attribute->save(); // 64

        $attribute = new \App\Models\Attribute([
            'specification_id' => 18,
            'name' => 'Wireless LAN'
        ]);
        $attribute->save(); // 65

        $attribute = new \App\Models\Attribute([
            'specification_id' => 18,
            'name' => 'Bluetooth'
        ]);
        $attribute->save(); // 66

        $attribute = new \App\Models\Attribute([
            'specification_id' => 19,
            'name' => 'PS/2'
        ]);
        $attribute->save(); // 67

        $attribute = new \App\Models\Attribute([
            'specification_id' => 19,
            'name' => 'Video Ports'
        ]);
        $attribute->save(); // 68

        $attribute = new \App\Models\Attribute([
            'specification_id' => 19,
            'name' => 'HDMI'
        ]);
        $attribute->save(); // 69

        $attribute = new \App\Models\Attribute([
            'specification_id' => 19,
            'name' => 'RJ45'
        ]);
        $attribute->save(); // 70

        $attribute = new \App\Models\Attribute([
            'specification_id' => 19,
            'name' => 'DisplayPort'
        ]);
        $attribute->save(); // 71

        $attribute = new \App\Models\Attribute([
            'specification_id' => 19,
            'name' => 'USB 3.1'
        ]);
        $attribute->save(); // 72

        $attribute = new \App\Models\Attribute([
            'specification_id' => 19,
            'name' => 'USB 3.0'
        ]);
        $attribute->save(); // 73

        $attribute = new \App\Models\Attribute([
            'specification_id' => 19,
            'name' => 'USB 1.1/2.0'
        ]);
        $attribute->save(); // 74

        $attribute = new \App\Models\Attribute([
            'specification_id' => 19,
            'name' => 'S/PDIF Out'
        ]);
        $attribute->save(); // 75

        $attribute = new \App\Models\Attribute([
            'specification_id' => 19,
            'name' => 'Audio Ports'
        ]);
        $attribute->save(); // 76

        $attribute = new \App\Models\Attribute([
            'specification_id' => 19,
            'name' => 'Antenna Connectors'
        ]);
        $attribute->save(); // 77

        $attribute = new \App\Models\Attribute([
            'specification_id' => 20,
            'name' => 'Form Factor'
        ]);
        $attribute->save(); // 78

        $attribute = new \App\Models\Attribute([
            'specification_id' => 20,
            'name' => 'Dimensions (W x L)'
        ]);
        $attribute->save(); // 79

        $attribute = new \App\Models\Attribute([
            'specification_id' => 20,
            'name' => 'Power Pin'
        ]);
        $attribute->save(); // 80

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

<?php

use Illuminate\Database\Seeder;

class PropertiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('properties')->truncate();
        // Properties table seeder
        $property = new \App\Models\Property([
            'specification_id' => 1,
            'name' => 'Brand'
        ]);
        $property->save(); // 1

        $property = new \App\Models\Property([
            'specification_id' => 1,
            'name' => 'Model'
        ]);
        $property->save(); // 2

        $property = new \App\Models\Property([
            'specification_id' => 2,
            'name' => 'Interface'
        ]);
        $property->save(); // 3

        $property = new \App\Models\Property([
            'specification_id' => 3,
            'name' => 'Chipset Manufacturer'
        ]);
        $property->save(); // 4

        $property = new \App\Models\Property([
            'specification_id' => 3,
            'name' => 'GPU'
        ]);
        $property->save(); // 5

        $property = new \App\Models\Property([
            'specification_id' => 3,
            'name' => 'Core Clock'
        ]);
        $property->save(); // 6

        $property = new \App\Models\Property([
            'specification_id' => 4,
            'name' => 'Effective Memory Clock'
        ]);
        $property->save(); // 7

        $property = new \App\Models\Property([
            'specification_id' => 4,
            'name' => 'Memory Size'
        ]);
        $property->save(); // 8

        $property = new \App\Models\Property([
            'specification_id' => 4,
            'name' => 'Memory Interface'
        ]);
        $property->save(); // 9

        $property = new \App\Models\Property([
            'specification_id' => 4,
            'name' => 'Memory Type'
        ]);
        $property->save(); // 10

        $property = new \App\Models\Property([
            'specification_id' => 5,
            'name' => 'HDMI'
        ]);
        $property->save(); // 11

        $property = new \App\Models\Property([
            'specification_id' => 5,
            'name' => 'DisplayPort'
        ]);
        $property->save(); // 12

        $property = new \App\Models\Property([
            'specification_id' => 5,
            'name' => 'DVI'
        ]);
        $property->save(); // 13

        $property = new \App\Models\Property([
            'specification_id' => 6,
            'name' => 'Max Resolution'
        ]);
        $property->save(); // 14

        $property = new \App\Models\Property([
            'specification_id' => 6,
            'name' => 'CrossFireX Support'
        ]);
        $property->save(); // 15

        $property = new \App\Models\Property([
            'specification_id' => 6,
            'name' => 'SLI Support'
        ]);
        $property->save(); // 16

        $property = new \App\Models\Property([
            'specification_id' => 6,
            'name' => 'Cooler'
        ]);
        $property->save(); // 17

        $property = new \App\Models\Property([
            'specification_id' => 6,
            'name' => 'Power Connector'
        ]);
        $property->save(); // 18

        $property = new \App\Models\Property([
            'specification_id' => 9,
            'name' => 'CPU Socket Type'
        ]);
        $property->save(); // 19

        $property = new \App\Models\Property([
            'specification_id' => 3,
            'name' => 'Boost Clock'
        ]);
        $property->save(); // 20

        $property = new \App\Models\Property([
            'specification_id' => 3,
            'name' => 'CUDA Cores'
        ]);
        $property->save(); // 21

        $property = new \App\Models\Property([
            'specification_id' => 3,
            'name' => 'Stream Processors'
        ]);
        $property->save(); // 22

        $property = new \App\Models\Property([
            'specification_id' => 8,
            'name' => 'Brand'
        ]);
        $property->save(); // 23

        $property = new \App\Models\Property([
            'specification_id' => 8,
            'name' => 'Model'
        ]);
        $property->save(); // 24

        $property = new \App\Models\Property([
            'specification_id' => 8,
            'name' => 'Processor Type'
        ]);
        $property->save(); // 25

        $property = new \App\Models\Property([
            'specification_id' => 8,
            'name' => 'Series'
        ]);
        $property->save(); // 26

        $property = new \App\Models\Property([
            'specification_id' => 7,
            'name' => 'Max GPU Length'
        ]);
        $property->save(); // 27

        $property = new \App\Models\Property([
            'specification_id' => 7,
            'name' => 'Card Dimensions (L x H)'
        ]);
        $property->save(); // 28

        $property = new \App\Models\Property([
            'specification_id' => 7,
            'name' => 'Slot Width'
        ]);
        $property->save(); // 29

        $property = new \App\Models\Property([
            'specification_id' => 10,
            'name' => 'Core Name'
        ]);
        $property->save(); // 30

        $property = new \App\Models\Property([
            'specification_id' => 10,
            'name' => '# of Cores'
        ]);
        $property->save(); // 31

        $property = new \App\Models\Property([
            'specification_id' => 10,
            'name' => '# of Threads'
        ]);
        $property->save(); // 32

        $property = new \App\Models\Property([
            'specification_id' => 10,
            'name' => 'Operating Frequency'
        ]);
        $property->save(); // 33

        $property = new \App\Models\Property([
            'specification_id' => 10,
            'name' => 'Max Turbo Frequency'
        ]);
        $property->save(); // 34

        $property = new \App\Models\Property([
            'specification_id' => 10,
            'name' => 'L2 Cache'
        ]);
        $property->save(); // 35

        $property = new \App\Models\Property([
            'specification_id' => 10,
            'name' => 'L3 Cache'
        ]);
        $property->save(); // 36

        $property = new \App\Models\Property([
            'specification_id' => 10,
            'name' => 'Manufacturing Tech'
        ]);
        $property->save(); // 37

        $property = new \App\Models\Property([
            'specification_id' => 10,
            'name' => '64-Bit Support'
        ]);
        $property->save(); // 38

        $property = new \App\Models\Property([
            'specification_id' => 10,
            'name' => 'Hyper-Threading Support'
        ]);
        $property->save(); // 39

        $property = new \App\Models\Property([
            'specification_id' => 10,
            'name' => 'Integrated Graphics'
        ]);
        $property->save(); // 40

        $property = new \App\Models\Property([
            'specification_id' => 10,
            'name' => 'Graphics Base Frequency'
        ]);
        $property->save(); // 41

        $property = new \App\Models\Property([
            'specification_id' => 10,
            'name' => 'Graphics Max Dynamic Frequency'
        ]);
        $property->save(); // 42

        $property = new \App\Models\Property([
            'specification_id' => 10,
            'name' => 'PCI Express Revision'
        ]);
        $property->save(); // 43

        $property = new \App\Models\Property([
            'specification_id' => 10,
            'name' => 'Max Number of PCI Express Lanes'
        ]);
        $property->save(); // 44

        $property = new \App\Models\Property([
            'specification_id' => 10,
            'name' => 'Thermal Design Power'
        ]);
        $property->save(); // 45

        $property = new \App\Models\Property([
            'specification_id' => 10,
            'name' => 'Cooling Device'
        ]);
        $property->save(); // 46

        $property = new \App\Models\Property([
            'specification_id' => 11,
            'name' => 'CPU Socket Type'
        ]);
        $property->save(); // 47

        $property = new \App\Models\Property([
            'specification_id' => 11,
            'name' => 'CPU Type'
        ]);
        $property->save(); // 48

        $property = new \App\Models\Property([
            'specification_id' => 12,
            'name' => 'Chipset'
        ]);
        $property->save(); // 49

        $property = new \App\Models\Property([
            'specification_id' => 16,
            'name' => 'Onboard Video Chipset'
        ]);
        $property->save(); // 50

        $property = new \App\Models\Property([
            'specification_id' => 13,
            'name' => 'Number of Memory Slots'
        ]);
        $property->save(); // 51

        $property = new \App\Models\Property([
            'specification_id' => 13,
            'name' => 'Memory Standard'
        ]);
        $property->save(); // 52

        $property = new \App\Models\Property([
            'specification_id' => 13,
            'name' => 'Maximum Memory Supported'
        ]);
        $property->save(); // 53

        $property = new \App\Models\Property([
            'specification_id' => 13,
            'name' => 'Channel Supported'
        ]);
        $property->save(); // 54

        $property = new \App\Models\Property([
            'specification_id' => 14,
            'name' => 'PCI Express x1'
        ]);
        $property->save(); // 55

        $property = new \App\Models\Property([
            'specification_id' => 14,
            'name' => 'PCI Express 2.0 x16'
        ]);
        $property->save(); // 56

        $property = new \App\Models\Property([
            'specification_id' => 14,
            'name' => 'PCI Express 3.0 x16'
        ]);
        $property->save(); // 57

        $property = new \App\Models\Property([
            'specification_id' => 15,
            'name' => 'SATA 1/2'
        ]);
        $property->save(); // 58

        $property = new \App\Models\Property([
            'specification_id' => 15,
            'name' => 'SATA 3'
        ]);
        $property->save(); // 59

        $property = new \App\Models\Property([
            'specification_id' => 15,
            'name' => 'SATA RAID'
        ]);
        $property->save(); // 60

        $property = new \App\Models\Property([
            'specification_id' => 17,
            'name' => 'Audio Chipset'
        ]);
        $property->save(); // 61

        $property = new \App\Models\Property([
            'specification_id' => 17,
            'name' => 'Audio Channels'
        ]);
        $property->save(); // 62

        $property = new \App\Models\Property([
            'specification_id' => 18,
            'name' => 'LAN Chipset'
        ]);
        $property->save(); // 63

        $property = new \App\Models\Property([
            'specification_id' => 18,
            'name' => 'Max LAN Speed'
        ]);
        $property->save(); // 64

        $property = new \App\Models\Property([
            'specification_id' => 18,
            'name' => 'Wireless LAN'
        ]);
        $property->save(); // 65

        $property = new \App\Models\Property([
            'specification_id' => 18,
            'name' => 'Bluetooth'
        ]);
        $property->save(); // 66

        $property = new \App\Models\Property([
            'specification_id' => 19,
            'name' => 'PS/2'
        ]);
        $property->save(); // 67

        $property = new \App\Models\Property([
            'specification_id' => 19,
            'name' => 'Video Ports'
        ]);
        $property->save(); // 68

        $property = new \App\Models\Property([
            'specification_id' => 19,
            'name' => 'HDMI'
        ]);
        $property->save(); // 69

        $property = new \App\Models\Property([
            'specification_id' => 19,
            'name' => 'RJ45'
        ]);
        $property->save(); // 70

        $property = new \App\Models\Property([
            'specification_id' => 19,
            'name' => 'DisplayPort'
        ]);
        $property->save(); // 71

        $property = new \App\Models\Property([
            'specification_id' => 19,
            'name' => 'USB 3.1'
        ]);
        $property->save(); // 72

        $property = new \App\Models\Property([
            'specification_id' => 19,
            'name' => 'USB 3.0'
        ]);
        $property->save(); // 73

        $property = new \App\Models\Property([
            'specification_id' => 19,
            'name' => 'USB 1.1/2.0'
        ]);
        $property->save(); // 74

        $property = new \App\Models\Property([
            'specification_id' => 19,
            'name' => 'S/PDIF Out'
        ]);
        $property->save(); // 75

        $property = new \App\Models\Property([
            'specification_id' => 19,
            'name' => 'Audio Ports'
        ]);
        $property->save(); // 76

        $property = new \App\Models\Property([
            'specification_id' => 19,
            'name' => 'Antenna Connectors'
        ]);
        $property->save(); // 77

        $property = new \App\Models\Property([
            'specification_id' => 20,
            'name' => 'Form Factor'
        ]);
        $property->save(); // 78

        $property = new \App\Models\Property([
            'specification_id' => 20,
            'name' => 'Dimensions (W x L)'
        ]);
        $property->save(); // 79

        $property = new \App\Models\Property([
            'specification_id' => 20,
            'name' => 'Power Pin'
        ]);
        $property->save(); // 80

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

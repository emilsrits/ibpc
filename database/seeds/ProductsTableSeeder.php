<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

    	DB::table('products')->truncate();
        $product = new \App\Models\Product([
        	'code' => 'STRIX-RX470-O4G-GAMING',
        	'title' => 'ASUS RX 470 4GB STRIX OC',
        	'description' => 'Dedicated graphics card',
        	'price' => 12550,
            'price_old' => 13057,
        	'stock' => 10,
        	'status' => 1
        ]);
        $product->save(); // 1

        $product = new \App\Models\Product([
        	'code' => 'GTX-1060-GAMING-X-6G',
        	'title' => 'MSI GTX 1060 6GB GAMING X',
        	'description' => 'Dedicated graphics card',
        	'price' => 22090,
            'price_old' => 27683,
        	'stock' => 5,
        	'status' => 1
        ]);
        $product->save(); // 2

        $product = new \App\Models\Product([
        	'code' => 'DUAL-RX480-O4G',
        	'title' => 'ASUS RX 480 4GB Dual-fan OC',
        	'description' => 'Dedicated graphics card',
        	'price' => 11046,
        	'stock' => 6,
        	'status' => 1
        ]);
        $product->save(); // 3

        $product = new \App\Models\Product([
            'code' => 'GTX-1050-Ti-GAMING-X-4G',
            'title' => 'MSI GTX 1050 Ti 4GB GAMING X',
            'description' => 'Dedicated graphics card',
            'price' => 13094,
            'stock' => 2,
            'status' => 1
        ]);
        $product->save(); // 4

        $product = new \App\Models\Product([
            'code' => 'STRIX-GTX1080-O8G-GAMING',
            'title' => 'ASUS GTX 1080 8GB ROG STRIX OC',
            'description' => 'Dedicated graphics card',
            'price' => 44021,
            'price_old' => 48058,
            'stock' => 6,
            'status' => 1
        ]);
        $product->save(); // 5

        $product = new \App\Models\Product([
            'code' => 'GTX-1060-3GT-OC',
            'title' => 'MSI GTX 1060 3GB OC',
            'description' => 'Dedicated graphics card',
            'price' => 23062,
            'price_old' => 24087,
            'stock' => 3,
            'status' => 1
        ]);
        $product->save(); // 6

        $product = new \App\Models\Product([
            'code' => 'GV-RX460WF2OC-4GD',
            'title' => 'GIGABYTE RX 460 4GB WINDFORCE OC',
            'description' => 'Dedicated graphics card',
            'price' => 12042,
            'price_old' => 15654,
            'stock' => 3,
            'status' => 1
        ]);
        $product->save(); // 7

        $product = new \App\Models\Product([
            'code' => 'SAPPHIRE-FX-4G',
            'title' => 'SAPPHIRE R9 FURY X 4GB HBM',
            'description' => 'Dedicated graphics card',
            'price' => 40089,
            'price_old' => 45064,
            'stock' => 1,
            'status' => 1
        ]);
        $product->save(); // 8

        $product = new \App\Models\Product([
            'code' => 'SAPPHIRE-N+-4G',
            'title' => 'SAPPHIRE NITRO+ RX 470 4GB',
            'description' => 'Dedicated graphics card',
            'price' => 21521,
            'price_old' => 23863,
            'stock' => 5,
            'status' => 1
        ]);
        $product->save(); // 9

        $product = new \App\Models\Product([
            'code' => 'CORE-I5-6600K',
            'title' => 'Intel® Core™ i5-6600K 3.5GHz 6MB LGA1151',
            'price' => 23000,
            'stock' => 6,
            'status' => 1
        ]);
        $product->save(); // 10

        $product = new \App\Models\Product([
            'code' => 'CORE-I5-7600K',
            'title' => 'Intel® Core™ i5-7600K 3.8 GHz 6M LGA1151',
            'price' => 24000,
            'stock' => 3,
            'status' => 1
        ]);
        $product->save(); // 11

        $product = new \App\Models\Product([
            'code' => 'CORE-I5-7700K',
            'title' => 'Intel® Core™ i7-7700K 4.2 GHz 8M LGA1151',
            'price' => 31042,
            'price_old' => 35058,
            'stock' => 7,
            'status' => 1
        ]);
        $product->save(); // 12

        $product = new \App\Models\Product([
            'code' => 'RYZEN-7-1800X',
            'title' => 'AMD Ryzen 7 1800X',
            'price' => 45065,
            'price_old' => 47231,
            'stock' => 6,
            'status' => 1
        ]);
        $product->save(); // 13

        $product = new \App\Models\Product([
            'code' => 'RYZEN-5-1600',
            'title' => 'AMD Ryzen 5 1600',
            'price' => 12089,
            'price_old' => 14093,
            'stock' => 6,
            'status' => 1
        ]);
        $product->save(); // 14

        $product = new \App\Models\Product([
            'code' => 'STRIX-Z270E-GAMING',
            'title' => 'ASUS STRIX Z270E GAMING',
            'price' => 13046,
            'price_old' => 16031,
            'stock' => 4,
            'status' => 1
        ]);
        $product->save(); // 15

        factory(\App\Models\Product::class, 85)->create()->each(function ($p) {
            $p->categories()->attach(rand(1, 14));
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

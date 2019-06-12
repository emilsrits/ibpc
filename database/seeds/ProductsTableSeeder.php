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
        // Product table seeder
        $product = new \App\Product([
        	'image_path' => '/storage/images/products/7/000001.jpg',
        	'code' => 'STRIX-RX470-O4G-GAMING',
        	'title' => 'ASUS RX 470 4GB STRIX OC',
        	'description' => 'Dedicated graphics card',
        	'price' => 195.50,
            'price_old' => 220.57,
        	'stock' => 10,
        	'status' => 1
        ]);
        $product->save(); // 1

        $product = new \App\Product([
        	'image_path' => '/storage/images/products/7/000002.jpg',
        	'code' => 'GTX-1060-GAMING-X-6G',
        	'title' => 'MSI GTX 1060 6GB GAMING X',
        	'description' => 'Dedicated graphics card',
        	'price' => 280.90,
            'price_old' => 298.83,
        	'stock' => 5,
        	'status' => 1
        ]);
        $product->save(); // 2

        $product = new \App\Product([
        	'image_path' => '/storage/images/products/7/000003.jpg',
        	'code' => 'DUAL-RX480-O4G',
        	'title' => 'ASUS RX 480 4GB Dual-fan OC',
        	'description' => 'Dedicated graphics card',
        	'price' => 210.46,
        	'stock' => 6,
        	'status' => 1
        ]);
        $product->save(); // 3

        $product = new \App\Product([
            'image_path' => '/storage/images/products/7/000004.jpg',
            'code' => 'GTX-1050-Ti-GAMING-X-4G',
            'title' => 'MSI GTX 1050 Ti 4GB GAMING X',
            'description' => 'Dedicated graphics card',
            'price' => 165.94,
            'stock' => 2,
            'status' => 1
        ]);
        $product->save(); // 4

        $product = new \App\Product([
            'image_path' => '/storage/images/products/7/000005.jpg',
            'code' => 'STRIX-GTX1080-O8G-GAMING',
            'title' => 'ASUS GTX 1080 8GB ROG STRIX OC',
            'description' => 'Dedicated graphics card',
            'price' => 730.21,
            'price_old' => 764.58,
            'stock' => 6,
            'status' => 1
        ]);
        $product->save(); // 5

        $product = new \App\Product([
            'image_path' => '/storage/images/products/7/000006.jpg',
            'code' => 'GTX-1060-3GT-OC',
            'title' => 'MSI GTX 1060 3GB OC',
            'description' => 'Dedicated graphics card',
            'price' => 268.62,
            'price_old' => 279.87,
            'stock' => 3,
            'status' => 1
        ]);
        $product->save(); // 6

        $product = new \App\Product([
            'image_path' => '/storage/images/products/7/000007.jpg',
            'code' => 'GV-RX460WF2OC-4GD',
            'title' => 'GIGABYTE RX 460 4GB WINDFORCE OC',
            'description' => 'Dedicated graphics card',
            'price' => 145.42,
            'price_old' => 156.54,
            'stock' => 3,
            'status' => 1
        ]);
        $product->save(); // 7

        $product = new \App\Product([
            'image_path' => '/storage/images/products/7/000008.jpg',
            'code' => 'SAPPHIRE-FX-4G',
            'title' => 'SAPPHIRE R9 FURY X 4GB HBM',
            'description' => 'Dedicated graphics card',
            'price' => 730.89,
            'price_old' => 742.64,
            'stock' => 1,
            'status' => 1
        ]);
        $product->save(); // 8

        $product = new \App\Product([
            'image_path' => '/storage/images/products/7/000009.jpg',
            'code' => 'SAPPHIRE-N+-4G',
            'title' => 'SAPPHIRE NITRO+ RX 470 4GB',
            'description' => 'Dedicated graphics card',
            'price' => 215.21,
            'price_old' => 238.63,
            'stock' => 5,
            'status' => 1
        ]);
        $product->save(); // 9

        $product = new \App\Product([
            'image_path' => '/storage/images/products/4/000010.jpg',
            'code' => 'CORE-I5-6600K',
            'title' => 'Intel® Core™ i5-6600K 3.5GHz 6MB LGA1151',
            'price' => 250.00,
            'stock' => 6,
            'status' => 1
        ]);
        $product->save(); // 10

        $product = new \App\Product([
            'image_path' => '/storage/images/products/4/000011.jpg',
            'code' => 'CORE-I5-7600K',
            'title' => 'Intel® Core™ i5-7600K 3.8 GHz 6M LGA1151',
            'price' => 255.00,
            'stock' => 3,
            'status' => 1
        ]);
        $product->save(); // 11

        $product = new \App\Product([
            'image_path' => '/storage/images/products/4/000012.jpg',
            'code' => 'CORE-I5-7700K',
            'title' => 'Intel® Core™ i7-7700K 4.2 GHz 8M LGA1151',
            'price' => 356.42,
            'price_old' => 361.58,
            'stock' => 7,
            'status' => 1
        ]);
        $product->save(); // 12

        $product = new \App\Product([
            'image_path' => '/storage/images/products/4/000013.jpg',
            'code' => 'RYZEN-7-1800X',
            'title' => 'AMD Ryzen 7 1800X',
            'price' => 450.65,
            'price_old' => 472.31,
            'stock' => 6,
            'status' => 1
        ]);
        $product->save(); // 13

        $product = new \App\Product([
            'image_path' => '/storage/images/products/4/000014.jpg',
            'code' => 'RYZEN-5-1600',
            'title' => 'AMD Ryzen 5 1600',
            'price' => 221.89,
            'price_old' => 237.93,
            'stock' => 3,
            'status' => 1
        ]);
        $product->save(); // 14

        $product = new \App\Product([
            'image_path' => '/storage/images/products/5/000015.jpg',
            'code' => 'STRIX-Z270E-GAMING',
            'title' => 'ASUS STRIX Z270E GAMING',
            'price' => 186.46,
            'price_old' => 193.31,
            'stock' => 2,
            'status' => 1
        ]);
        $product->save(); // 15

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

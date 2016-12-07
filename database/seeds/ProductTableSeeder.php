<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
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
        	'category_id' => 1,
        	'image_path' => '/images/products/1/000001.jpg',
        	'code' => 'STRIX-RX470-O4G-GAMING',
        	'title' => 'ASUS RX 470 4GB STRIX OC',
        	'description' => '
			   Brand: ASUS
			   Chipset Manufacturer: AMD
			   GPU: Radeon RX 470
        	',
        	'price' => 195.50,
            'price_old' => 220.57,
        	'storage' => 10,
        	'status' => 'available'
        ]);
        $product->save();

        $product = new \App\Product([
        	'category_id' => 1,
        	'image_path' => '/images/products/1/000002.jpg',
        	'code' => 'GTX-1060-GAMING-X-6G',
        	'title' => 'MSI GTX 1060 6GB GAMING X',
        	'description' => '
				Brand: MSI
				Chipset Manufacturer: NVIDIA
			   GPU: GeForce GTX 1060
        	',
        	'price' => 280.90,
            'price_old' => 298.83,
        	'storage' => 5,
        	'status' => 'available'
        ]);
        $product->save();

        $product = new \App\Product([
        	'category_id' => 1,
        	'image_path' => '/images/products/1/000003.jpg',
        	'code' => 'DUAL-RX480-O4G',
        	'title' => 'ASUS RX 480 4GB Dual-fan OC',
        	'description' => '
				Brand: ASUS
				Chipset Manufacturer: AMD
				GPU: Radeon RX 480
        	',
        	'price' => 210.46,
        	'storage' => 0,
        	'status' => 'not available'
        ]);
        $product->save();

        $product = new \App\Product([
            'category_id' => 1,
            'image_path' => '/images/products/1/000004.jpg',
            'code' => 'GTX-1050-Ti-GAMING-X-4G',
            'title' => 'MSI GTX 1050 Ti 4GB GAMING X',
            'description' => '
               Brand: MSI
               Chipset Manufacturer: NVIDIA
               GPU: GeForce GTX 1050 TI
            ',
            'price' => 165.94,
            'storage' => 2,
            'status' => 'available'
        ]);
        $product->save();

        $product = new \App\Product([
            'category_id' => 1,
            'image_path' => '/images/products/1/000005.jpg',
            'code' => 'STRIX-GTX1080-O8G-GAMING',
            'title' => 'ASUS GTX 1080 8GB ROG STRIX OC',
            'description' => '
               Brand: ASUS
               Chipset Manufacturer: NVIDIA
               GPU: GeForce GTX 1080
            ',
            'price' => 730.21,
            'price_old' => 764.58,
            'storage' => 6,
            'status' => 'available'
        ]);
        $product->save();

        $product = new \App\Product([
            'category_id' => 1,
            'image_path' => '/images/products/1/000006.jpg',
            'code' => 'GTX-1060-3GT-OC',
            'title' => 'MSI GTX 1060 3GB OC',
            'description' => '
               Brand: MSI
               Chipset Manufacturer: NVIDIA
               GPU: GeForce GTX 1060
            ',
            'price' => 268.62,
            'price_old' => 279.87,
            'storage' => 3,
            'status' => 'available'
        ]);
        $product->save();

        $product = new \App\Product([
            'category_id' => 1,
            'image_path' => '/images/products/1/000007.jpg',
            'code' => 'GV-RX460WF2OC-4GD',
            'title' => 'GIGABYTE RX 460 4GB WINDFORCE OC',
            'description' => '
               Brand: GIGABYTE
               Chipset Manufacturer: AMD
               GPU: Radeon RX 460
            ',
            'price' => 145.42,
            'price_old' => 156.54,
            'storage' => 3,
            'status' => 'available'
        ]);
        $product->save();

        $product = new \App\Product([
            'category_id' => 1,
            'image_path' => '/images/products/1/000008.jpg',
            'code' => 'SAPPHIRE-FX-4G',
            'title' => 'SAPPHIRE R9 FURY X 4GB HBM',
            'description' => '
               Brand: SAPPHIRE
               Chipset Manufacturer: AMD
               GPU: Radeon R9 Fury X
            ',
            'price' => 730.89,
            'price_old' => 742.64,
            'storage' => 1,
            'status' => 'available'
        ]);
        $product->save();

        $product = new \App\Product([
            'category_id' => 1,
            'image_path' => '/images/products/1/000009.jpg',
            'code' => 'SAPPHIRE-N+-4G',
            'title' => 'SAPPHIRE NITRO+ RX 470 4GB',
            'description' => '
               Brand: SAPPHIRE
               Chipset Manufacturer: AMD
               GPU: Radeon RX 470
            ',
            'price' => 215.21,
            'price_old' => 238.63,
            'storage' => 0,
            'status' => 'not available'
        ]);
        $product->save();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

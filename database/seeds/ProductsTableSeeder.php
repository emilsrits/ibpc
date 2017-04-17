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
        	'image_path' => '/storage/images/products/4/000001.jpg',
        	'code' => 'STRIX-RX470-O4G-GAMING',
        	'title' => 'ASUS RX 470 4GB STRIX OC',
        	'description' => 'Gaming graphics card',
        	'price' => 195.50,
            'price_old' => 220.57,
        	'stock' => 10,
        	'status' => 1
        ]);
        $product->save();

        $product = new \App\Product([
        	'image_path' => '/storage/images/products/4/000002.jpg',
        	'code' => 'GTX-1060-GAMING-X-6G',
        	'title' => 'MSI GTX 1060 6GB GAMING X',
        	'description' => 'Gaming graphics card',
        	'price' => 280.90,
            'price_old' => 298.83,
        	'stock' => 5,
        	'status' => 1
        ]);
        $product->save();

        $product = new \App\Product([
        	'image_path' => '/storage/images/products/4/000003.jpg',
        	'code' => 'DUAL-RX480-O4G',
        	'title' => 'ASUS RX 480 4GB Dual-fan OC',
        	'description' => 'Gaming graphics card',
        	'price' => 210.46,
        	'stock' => 6,
        	'status' => 1
        ]);
        $product->save();

        $product = new \App\Product([
            'image_path' => '/storage/images/products/4/000004.jpg',
            'code' => 'GTX-1050-Ti-GAMING-X-4G',
            'title' => 'MSI GTX 1050 Ti 4GB GAMING X',
            'description' => 'Gaming graphics card',
            'price' => 165.94,
            'stock' => 2,
            'status' => 1
        ]);
        $product->save();

        $product = new \App\Product([
            'image_path' => '/storage/images/products/4/000005.jpg',
            'code' => 'STRIX-GTX1080-O8G-GAMING',
            'title' => 'ASUS GTX 1080 8GB ROG STRIX OC',
            'description' => 'Gaming graphics card',
            'price' => 730.21,
            'price_old' => 764.58,
            'stock' => 6,
            'status' => 1
        ]);
        $product->save();

        $product = new \App\Product([
            'image_path' => '/storage/images/products/4/000006.jpg',
            'code' => 'GTX-1060-3GT-OC',
            'title' => 'MSI GTX 1060 3GB OC',
            'description' => 'Gaming graphics card',
            'price' => 268.62,
            'price_old' => 279.87,
            'stock' => 3,
            'status' => 1
        ]);
        $product->save();

        $product = new \App\Product([
            'image_path' => '/storage/images/products/4/000007.jpg',
            'code' => 'GV-RX460WF2OC-4GD',
            'title' => 'GIGABYTE RX 460 4GB WINDFORCE OC',
            'description' => 'Gaming graphics card',
            'price' => 145.42,
            'price_old' => 156.54,
            'stock' => 3,
            'status' => 1
        ]);
        $product->save();

        $product = new \App\Product([
            'image_path' => '/storage/images/products/4/000008.jpg',
            'code' => 'SAPPHIRE-FX-4G',
            'title' => 'SAPPHIRE R9 FURY X 4GB HBM',
            'description' => 'Gaming graphics card',
            'price' => 730.89,
            'price_old' => 742.64,
            'stock' => 1,
            'status' => 1
        ]);
        $product->save();

        $product = new \App\Product([
            'image_path' => '/storage/images/products/4/000009.jpg',
            'code' => 'SAPPHIRE-N+-4G',
            'title' => 'SAPPHIRE NITRO+ RX 470 4GB',
            'description' => 'Gaming graphics card',
            'price' => 215.21,
            'price_old' => 238.63,
            'stock' => 5,
            'status' => 1
        ]);
        $product->save();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

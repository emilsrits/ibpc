<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

    	DB::table('roles')->truncate();
        // Adds user role types to roles table
        DB::table('roles')->insert([
            [
	            'name' => 'administrator',
	            'slug' => 'admin',
	            'description' => 'owner, has control over the entire site'
            ],
            [
            	'name' => 'moderator',
	            'slug' => 'mod',
	            'description' => 'has control over some parts of the site'
            ],
            [
            	'name' => 'supplier',
	            'slug' => 'sup',
	            'description' => 'manages its own products'
            ],
            [
            	'name' => 'buyer',
	            'slug' => 'user',
	            'description' => 'browses the shop and buys products'
            ]
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
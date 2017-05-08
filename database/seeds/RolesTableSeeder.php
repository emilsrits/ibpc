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
        $role = new \App\Role([
            'name' => 'administrator',
            'slug' => 'admin',
            'description' => 'owner, has control over the entire site'
        ]);
        $role->save();

        $role = new \App\Role([
            'name' => 'moderator',
            'slug' => 'mod',
            'description' => 'has control over some parts of the site'
        ]);
        $role->save();

        $role = new \App\Role([
            'name' => 'supplier',
            'slug' => 'sup',
            'description' => 'manages its own products'
        ]);
        $role->save();

        $role = new \App\Role([
            'name' => 'customer',
            'slug' => 'user',
            'description' => 'browses the shop and buys products'
        ]);
        $role->save();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
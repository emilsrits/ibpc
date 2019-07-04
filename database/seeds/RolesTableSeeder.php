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
        $role = new \App\Models\Role([
            'name' => 'administrator',
            'slug' => 'admin'
        ]);
        $role->save();

        $role = new \App\Models\Role([
            'name' => 'user',
            'slug' => 'user'
        ]);
        $role->save();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
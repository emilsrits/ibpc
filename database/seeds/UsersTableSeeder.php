<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('users')->truncate();
        // add users to the database
        DB::table('users')->insert([
            [
	            'name' => 'Emīls',
	            'surname' => 'Rīts',
	            'email' => 'admin@ibpc.dev',
	            'address' => 'Zirgu iela 2a',
	            'country' => 'Latvia',
	            'city' => 'Ikšķile',
	            'postcode' => 'LV-5052',
	            'password' => Hash::make('ibpcadmin')
            ]
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

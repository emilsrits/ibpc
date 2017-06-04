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
	            'name' => 'admin',
	            'surname' => 'admin',
	            'email' => 'admin@ibpc.dev',
	            'country' => 'LV',
	            'city' => 'Riga',
                'address' => 'Brivibas gatve 229',
	            'postcode' => 'LV-1050',
	            'password' => Hash::make('ibpcadmin')
            ]
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

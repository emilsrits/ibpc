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
	            'name' => 'Emils',
	            'surname' => 'Rits',
	            'email' => 'admin@ibpc.dev',
	            'address' => 'Brivibas gatve 229',
	            'country' => 'Latvia',
	            'city' => 'Riga',
	            'postcode' => 'LV-1050',
	            'password' => Hash::make('ibpcadmin')
            ]
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

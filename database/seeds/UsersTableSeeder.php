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
        $admin_email = config('constants.admin.email');
        $admin_password = config('constants.admin.password');
        if ($admin_email && $admin_password) {
            DB::table('users')->insert([
                [
                    'first_name' => 'admin',
                    'last_name' => 'admin',
                    'email' => $admin_email,
                    'password' => Hash::make($admin_password),
                    'country' => 'LV',
                    'city' => 'Test',
                    'address' => 'Example',
                    'postcode' => 'EG-1234'
                ]
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

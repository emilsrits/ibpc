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
        $admin_email = env('ADMIN_EMAIL');
        $admin_password = env('ADMIN_PASSWORD');
        if ($admin_email && $admin_password) {
            DB::table('users')->insert([
                [
                    'name' => 'admin',
                    'surname' => 'admin',
                    'email' => env('ADMIN_EMAIL'),
                    'password' => Hash::make(env('ADMIN_PASSWORD'))
                ]
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

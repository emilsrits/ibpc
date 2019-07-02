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
                    'name' => 'admin',
                    'surname' => 'admin',
                    'email' => $admin_email,
                    'password' => Hash::make($admin_password)
                ]
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}

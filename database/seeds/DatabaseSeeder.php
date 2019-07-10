<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(RoleUserTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(CategoryProductTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(SpecificationsTableSeeder::class);
        $this->call(CategorySpecificationTableSeeder::class);
        $this->call(PropertiesTableSeeder::class);
        $this->call(ProductPropertyTableSeeder::class);
    }
}

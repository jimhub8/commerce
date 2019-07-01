<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(CategoryTableSeeder::class);
        $this->call(SubCatTableSeeder::class);
        // $this->call(MenuTableSeeder::class);
        // $this->call(UserTableSeeder::class);
        // $this->call(BrandTableSeeder::class);
        // $this->call(ProductTableSeeder::class);
    }
}

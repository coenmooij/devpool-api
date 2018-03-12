<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(TechnologySeeder::class);
        $this->call(DeveloperSeeder::class);
        $this->call(UserSeeder::class);
    }
}

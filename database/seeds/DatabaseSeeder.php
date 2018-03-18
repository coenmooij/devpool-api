<?php

use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(TechnologySeeder::class);
        $this->call(DeveloperSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(FormSeeder::class);
        $this->call(CommentSeeder::class);
    }
}

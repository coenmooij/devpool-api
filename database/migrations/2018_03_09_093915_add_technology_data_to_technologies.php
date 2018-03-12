<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;

final class AddTechnologyDataToTechnologies extends Migration
{
    public function up(): void
    {
        (new TechnologySeeder())->run();
    }

    public function down(): void
    {
        // Irreversible migration
    }
}

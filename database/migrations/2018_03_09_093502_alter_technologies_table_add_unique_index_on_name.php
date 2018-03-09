<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class AlterTechnologiesTableAddUniqueIndexOnName extends Migration
{
    public function up(): void
    {
        Schema::table(
            'technologies',
            function (Blueprint $table) {
                $table->unique(['name']);
            }
        );
    }

    public function down(): void
    {
        Schema::table(
            'technologies',
            function (Blueprint $table) {
                $table->dropUnique(['name']);
            }
        );
    }
}

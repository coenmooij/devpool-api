<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

final class AlterDevelopersTableAddSalary extends Migration
{
    public function up(): void
    {
        Schema::table(
            'developers',
            function (Blueprint $table) {
                $table->string('salary')->nullable();
            }
        );
    }

    public function down(): void
    {
        Schema::table(
            'developers',
            function (Blueprint $table) {
                $table->dropColumn('salary');
            }
        );
    }
}

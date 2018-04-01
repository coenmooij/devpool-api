<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

final class AlterCommentsTableRemoveType extends Migration
{
    public function up(): void
    {
        Schema::table(
            'comments',
            function (Blueprint $table) {
                $table->dropColumn('type');
            }
        );
    }

    public function down(): void
    {
        Schema::table(
            'comments',
            function (Blueprint $table) {
                $table->integer('type')->unsigned();
            }
        );
    }
}

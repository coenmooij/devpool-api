<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterDevelopersTableExtendUserTable extends Migration
{
    public function up(): void
    {
        Schema::table(
            'developers',
            function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->dropUnique(['user_id']);
                $table->dropColumn('user_id');
                $table->foreign(['id'])->references('id')->on('users')->onDelete('cascade');
            }
        );
    }

    public function down(): void
    {
        Schema::table(
            'developers',
            function (Blueprint $table) {
                $table->dropForeign(['id']);
                $table->integer('user_id')->unsigned()->unique();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
        );
    }
}

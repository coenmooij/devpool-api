<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateUsersTable extends Migration
{
    public function up(): void
    {
        Schema::create(
            'users',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('email')->unique();
                $table->string('password', 60);
                $table->string('salt')->unique();
                $table->string('first_name');
                $table->string('last_name');
                $table->string('token')->nullable();
                $table->dateTime('token_expires')->nullable();
                $table->timestamps();
                $table->index(['token']);
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}

<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateDevelopersTable extends Migration
{
    public function up(): void
    {
        Schema::create(
            'developers',
            function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned()->unique();
                $table->string('speciality')->nullable();
                $table->string('seniority')->nullable();
                $table->integer('pipeline_status')->unsigned()->default(0);
                $table->string('country')->nullable();
                $table->string('phone')->nullable();
                $table->date('birth_date')->nullable();
                $table->boolean('priority')->default(false);
                $table->timestamps();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('developers');
    }
}

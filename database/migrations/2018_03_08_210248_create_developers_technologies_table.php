<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateDevelopersTechnologiesTable extends Migration
{
    public function up(): void
    {
        Schema::create(
            'developers_technologies',
            function (Blueprint $table) {
                $table->increments('id');
                $table->integer('developer_id')->unsigned();
                $table->integer('technology_id')->unsigned();
                $table->timestamps();

                $table->foreign('developer_id')->references('id')->on('developers')->onDelete('cascade');
                $table->foreign('technology_id')->references('id')->on('technologies')->onDelete('cascade');
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('developers_technologies');
    }
}

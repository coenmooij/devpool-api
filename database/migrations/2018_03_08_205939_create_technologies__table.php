<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateTechnologiesTable extends Migration
{
    public function up(): void
    {
        Schema::create(
            'technologies',
            function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('type');
                $table->integer('parent_id')->unsigned()->nullable();
                $table->timestamps();
                $table->foreign('parent_id')->references('id')->on('technologies')->onDelete('cascade');
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('technologies');
    }
}

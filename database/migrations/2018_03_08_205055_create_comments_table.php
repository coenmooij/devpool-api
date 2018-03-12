<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateCommentsTable extends Migration
{
    public function up(): void
    {
        Schema::create(
            'comments',
            function (Blueprint $table) {
                $table->increments('id');
                $table->text('message');
                $table->integer('type')->unsigned();
                $table->integer('user_id')->unsigned();
                $table->integer('author_id')->unsigned();
                $table->timestamps();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('author_id')->references('id')->on('users');
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
}

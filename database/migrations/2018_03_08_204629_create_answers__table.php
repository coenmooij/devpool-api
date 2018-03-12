<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateAnswersTable extends Migration
{
    public function up(): void
    {
        Schema::create(
            'answers',
            function (Blueprint $table) {
                $table->increments('id');
                $table->integer('developer_id')->unsigned();
                $table->integer('question_id')->unsigned();
                $table->string('value')->nullable();
                $table->timestamps();
                $table->foreign('developer_id')->references('id')->on('developers')->onDelete('cascade');
                $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
}

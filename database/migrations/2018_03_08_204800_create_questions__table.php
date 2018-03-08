<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateQuestionsTable extends Migration
{
    public function up(): void
    {
        Schema::create(
            'questions',
            function (Blueprint $table) {
                $table->increments('id');
                $table->integer('form_id')->unsigned();
                $table->integer('order')->unsigned();
                $table->string('value');
                $table->timestamps();
                $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
}

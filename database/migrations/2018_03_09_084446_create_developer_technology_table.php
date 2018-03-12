<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateDeveloperTechnologyTable extends Migration
{
    public function up(): void
    {
        $this->down();
        Schema::create(
            'developer_technology',
            function (Blueprint $table) {
                $table->integer('developer_id')->unsigned();
                $table->integer('technology_id')->unsigned();

                $table->foreign('developer_id')->references('id')->on('developers')->onDelete('cascade');
                $table->foreign('technology_id')->references('id')->on('technologies')->onDelete('cascade');

                $table->primary(['developer_id', 'technology_id']);
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('developer_technology');
    }
}

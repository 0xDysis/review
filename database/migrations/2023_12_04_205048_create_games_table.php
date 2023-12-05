<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('genre')->nullable(); // The 'genre' field
            $table->integer('publication_year')->nullable(); // The 'publication_year' field
            $table->float('average_score')->nullable(); // The 'average_score' field
            $table->integer('number_of_reviews')->nullable(); // The 'number_of_reviews' field
            $table->string('cover_image')->nullable(); // The 'cover_image' field
            $table->text('summary')->nullable(); // Add the 'summary' field
            $table->text('storyline')->nullable(); // Add the 'storyline' field
            // Add other fields as needed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};



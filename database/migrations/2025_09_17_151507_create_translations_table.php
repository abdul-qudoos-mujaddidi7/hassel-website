<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->string('model_type'); // e.g., 'News', 'Publication', 'TrainingProgram'
            $table->unsignedBigInteger('model_id'); // ID of the related record
            $table->string('field_name'); // e.g., 'title', 'content', 'description'
            $table->enum('language', ['en', 'pashto', 'farsi'])->default('en');
            $table->longText('content'); // the translated text
            $table->timestamps();

            // Indexes for better performance
            $table->index(['model_type', 'model_id']);
            $table->index(['model_type', 'model_id', 'language']);

            // Ensure unique translation per model/field/language combination
            $table->unique(['model_type', 'model_id', 'field_name', 'language']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};

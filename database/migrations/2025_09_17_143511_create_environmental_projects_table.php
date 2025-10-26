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
        Schema::create('environmental_projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description');
            $table->string('cover_image')->nullable();
            $table->string('thumbnail_image')->nullable();
            $table->string('project_type')->nullable(); // e.g., 'conservation', 'reforestation', 'water_management'
            $table->string('location')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('budget', 15, 2)->nullable();
            $table->string('impact_level')->nullable(); // low, medium, high, critical
            $table->longText('objectives')->nullable();
            $table->longText('methodology')->nullable();
            $table->longText('expected_outcomes')->nullable();
            $table->json('partner_organizations')->nullable();
            $table->json('impact_metrics')->nullable(); // array of metrics like trees planted, water saved, etc.
            $table->string('funding_source')->nullable();
            $table->enum('status', ['draft', 'published', 'ongoing', 'completed', 'cancelled'])->default('draft');
            $table->json('farsi_translations')->nullable();
            $table->json('pashto_translations')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('environmental_projects');
    }
};

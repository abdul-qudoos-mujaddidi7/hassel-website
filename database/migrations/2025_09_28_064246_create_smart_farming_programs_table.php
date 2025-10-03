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
        Schema::create('smart_farming_programs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('short_description')->nullable();
            $table->string('farming_type')->nullable(); // drip_irrigation, greenhouse, precision_agriculture, organic, climate_resilient, soil_health
            $table->json('target_crops')->nullable(); // vegetables, fruits, cereals, legumes, spices, medicinal
            $table->integer('sustainability_level')->nullable(); // 1-100 percentage
            $table->text('implementation_guide')->nullable();
            $table->text('sustainability_impact')->nullable();
            $table->string('duration')->nullable(); // e.g., '3 months', '6 weeks'
            $table->string('location')->nullable();
            $table->date('application_deadline')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('thumbnail_image')->nullable();
            $table->enum('status', ['draft', 'published', 'ongoing', 'completed', 'cancelled'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('smart_farming_programs');
    }
};

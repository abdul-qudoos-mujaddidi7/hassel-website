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
        Schema::create('seed_supply_programs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('short_description')->nullable();
            $table->string('input_type')->nullable(); // seeds, fertilizers, pesticides, tools, equipment, distribution
            $table->json('target_crops')->nullable(); // cereals, vegetables, fruits, pulses, oilseeds, spices, cash_crops
            $table->string('quality_grade')->nullable(); // A, B, C, Premium, Standard
            $table->string('price_range')->nullable(); // e.g., '$10-50 per kg', 'Free for farmers'
            $table->string('availability')->nullable(); // In Stock, Limited, Out of Stock, Coming Soon
            $table->string('shelf_life')->nullable(); // e.g., '2 years', '6 months'
            $table->json('distribution_centers')->nullable(); // Array of distribution center locations
            $table->text('usage_instructions')->nullable();
            $table->text('technical_specifications')->nullable();
            $table->string('supplier')->nullable();
            $table->string('contact_info')->nullable();
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
        Schema::dropIfExists('seed_supply_programs');
    }
};

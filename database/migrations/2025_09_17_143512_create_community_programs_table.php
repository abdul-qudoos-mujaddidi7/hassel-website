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
        Schema::create('community_programs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description');
            $table->enum('target_group', ['women', 'youth', 'cooperatives', 'farmers', 'all'])->default('all');
            $table->string('program_type')->nullable(); // e.g., 'capacity_building', 'leadership', 'entrepreneurship'
            $table->string('location')->nullable();
            $table->json('partner_organizations')->nullable(); // array of partner names
            $table->enum('status', ['draft', 'published', 'ongoing', 'completed', 'archived'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_programs');
    }
};

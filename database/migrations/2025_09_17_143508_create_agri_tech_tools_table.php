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
        Schema::create('agri_tech_tools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->longText('description');
            $table->string('tool_type')->nullable(); // e.g., 'mobile_app', 'web_tool', 'desktop_software'
            $table->json('features')->nullable(); // array of features
            $table->string('download_link')->nullable();
            $table->string('platform')->nullable(); // e.g., 'Android', 'iOS', 'Web', 'Windows'
            $table->string('version')->nullable();
            $table->enum('status', ['draft', 'published', 'archived', 'maintenance'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agri_tech_tools');
    }
};

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
        // Publications table
        Schema::table('publications', function (Blueprint $table) {
            $table->json('farsi_translations')->nullable()->after('description');
            $table->json('pashto_translations')->nullable()->after('farsi_translations');
        });

        // Success Stories table
        Schema::table('success_stories', function (Blueprint $table) {
            $table->json('farsi_translations')->nullable()->after('story');
            $table->json('pashto_translations')->nullable()->after('farsi_translations');
        });

        // Job Announcements table
        Schema::table('job_announcements', function (Blueprint $table) {
            $table->json('farsi_translations')->nullable()->after('location');
            $table->json('pashto_translations')->nullable()->after('farsi_translations');
        });

        // Training Programs table
        Schema::table('training_programs', function (Blueprint $table) {
            $table->json('farsi_translations')->nullable()->after('instructor');
            $table->json('pashto_translations')->nullable()->after('farsi_translations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('publications', function (Blueprint $table) {
            $table->dropColumn(['farsi_translations', 'pashto_translations']);
        });

        Schema::table('success_stories', function (Blueprint $table) {
            $table->dropColumn(['farsi_translations', 'pashto_translations']);
        });

        Schema::table('job_announcements', function (Blueprint $table) {
            $table->dropColumn(['farsi_translations', 'pashto_translations']);
        });

        Schema::table('training_programs', function (Blueprint $table) {
            $table->dropColumn(['farsi_translations', 'pashto_translations']);
        });

        Schema::table('environmental_projects', function (Blueprint $table) {
            $table->dropColumn(['farsi_translations', 'pashto_translations']);
        });
    }
};

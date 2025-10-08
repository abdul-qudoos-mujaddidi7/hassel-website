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
        // Change JSON columns to LONGTEXT for all tables to handle larger content
        $tables = ['news', 'publications', 'success_stories', 'job_announcements', 'training_programs', 'environmental_projects'];
        
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $table) {
                    $table->longText('farsi_translations')->nullable()->change();
                    $table->longText('pashto_translations')->nullable()->change();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = ['news', 'publications', 'success_stories', 'job_announcements', 'training_programs', 'environmental_projects'];
        
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $table) {
                    $table->json('farsi_translations')->nullable()->change();
                    $table->json('pashto_translations')->nullable()->change();
                });
            }
        }
    }
};
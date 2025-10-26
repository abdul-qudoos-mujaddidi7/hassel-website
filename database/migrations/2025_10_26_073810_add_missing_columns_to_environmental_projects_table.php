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
        Schema::table('environmental_projects', function (Blueprint $table) {
            // Add missing columns
            if (!Schema::hasColumn('environmental_projects', 'cover_image')) {
                $table->string('cover_image')->nullable()->after('description');
            }
            if (!Schema::hasColumn('environmental_projects', 'thumbnail_image')) {
                $table->string('thumbnail_image')->nullable()->after('cover_image');
            }
            if (!Schema::hasColumn('environmental_projects', 'start_date')) {
                $table->date('start_date')->nullable()->after('location');
            }
            if (!Schema::hasColumn('environmental_projects', 'end_date')) {
                $table->date('end_date')->nullable()->after('start_date');
            }
            if (!Schema::hasColumn('environmental_projects', 'budget')) {
                $table->decimal('budget', 15, 2)->nullable()->after('end_date');
            }
            if (!Schema::hasColumn('environmental_projects', 'impact_level')) {
                $table->string('impact_level')->nullable()->after('budget');
            }
            if (!Schema::hasColumn('environmental_projects', 'objectives')) {
                $table->longText('objectives')->nullable()->after('impact_level');
            }
            if (!Schema::hasColumn('environmental_projects', 'methodology')) {
                $table->longText('methodology')->nullable()->after('objectives');
            }
            if (!Schema::hasColumn('environmental_projects', 'expected_outcomes')) {
                $table->longText('expected_outcomes')->nullable()->after('methodology');
            }
            if (!Schema::hasColumn('environmental_projects', 'partner_organizations')) {
                $table->json('partner_organizations')->nullable()->after('expected_outcomes');
            }
            if (!Schema::hasColumn('environmental_projects', 'farsi_translations')) {
                $table->json('farsi_translations')->nullable()->after('status');
            }
            if (!Schema::hasColumn('environmental_projects', 'pashto_translations')) {
                $table->json('pashto_translations')->nullable()->after('farsi_translations');
            }
            
            // Update status enum to match model
            if (Schema::hasColumn('environmental_projects', 'status')) {
                $table->enum('status', ['draft', 'published', 'ongoing', 'completed', 'cancelled'])->default('draft')->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('environmental_projects', function (Blueprint $table) {
            // Drop added columns
            $columns = [
                'cover_image',
                'thumbnail_image',
                'start_date',
                'end_date',
                'budget',
                'impact_level',
                'objectives',
                'methodology',
                'expected_outcomes',
                'partner_organizations',
                'farsi_translations',
                'pashto_translations',
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('environmental_projects', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};

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
        Schema::table('agri_tech_tools', function (Blueprint $table) {
            // Add missing columns
            if (!Schema::hasColumn('agri_tech_tools', 'short_description')) {
                $table->text('short_description')->nullable()->after('description');
            }
            if (!Schema::hasColumn('agri_tech_tools', 'cover_image')) {
                $table->string('cover_image')->nullable()->after('description');
            }
            if (!Schema::hasColumn('agri_tech_tools', 'thumbnail_image')) {
                $table->string('thumbnail_image')->nullable()->after('cover_image');
            }
            if (!Schema::hasColumn('agri_tech_tools', 'specifications')) {
                $table->longText('specifications')->nullable()->after('features');
            }
            if (!Schema::hasColumn('agri_tech_tools', 'usage_instructions')) {
                $table->longText('usage_instructions')->nullable()->after('specifications');
            }
            if (!Schema::hasColumn('agri_tech_tools', 'maintenance_requirements')) {
                $table->longText('maintenance_requirements')->nullable()->after('usage_instructions');
            }
            if (!Schema::hasColumn('agri_tech_tools', 'technology_level')) {
                $table->string('technology_level')->nullable()->after('maintenance_requirements');
            }
            if (!Schema::hasColumn('agri_tech_tools', 'availability')) {
                $table->string('availability')->nullable()->after('technology_level');
            }
            if (!Schema::hasColumn('agri_tech_tools', 'price_range')) {
                $table->string('price_range')->nullable()->after('availability');
            }
            if (!Schema::hasColumn('agri_tech_tools', 'supplier')) {
                $table->string('supplier')->nullable()->after('price_range');
            }
            if (!Schema::hasColumn('agri_tech_tools', 'contact_info')) {
                $table->text('contact_info')->nullable()->after('supplier');
            }
            
            // Update status enum to match model
            if (Schema::hasColumn('agri_tech_tools', 'status')) {
                $table->enum('status', ['draft', 'published', 'archived'])->default('draft')->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agri_tech_tools', function (Blueprint $table) {
            // Drop added columns
            $columns = [
                'short_description',
                'cover_image',
                'thumbnail_image',
                'specifications',
                'usage_instructions',
                'maintenance_requirements',
                'technology_level',
                'availability',
                'price_range',
                'supplier',
                'contact_info',
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('agri_tech_tools', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};

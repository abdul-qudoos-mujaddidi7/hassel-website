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
        Schema::table('beneficiaries_stats', function (Blueprint $table) {
            // Add indexes for better query performance
            $table->index('stat_type');
            $table->index('year');
            $table->index(['stat_type', 'year']);
            $table->index('created_at');

            // Add unique constraint to prevent duplicate stats for same type and year
            $table->unique(['stat_type', 'year'], 'unique_stat_type_year');

            // NOTE: Portable check constraints are not supported across all drivers in Laravel's Schema builder.
            // If you need a DB-level check, use a raw statement per driver. For portability, we skip it here.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('beneficiaries_stats', function (Blueprint $table) {
            // Drop indexes
            $table->dropIndex(['stat_type']);
            $table->dropIndex(['year']);
            $table->dropIndex(['stat_type', 'year']);
            $table->dropIndex(['created_at']);

            // Drop unique constraint
            $table->dropUnique('unique_stat_type_year');

            // Drop check constraint
            $table->dropCheck('check_positive_value');
        });
    }
};



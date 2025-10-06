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
            // Add additional fields for better data management
            $table->string('unit')->default('count')->after('value'); // e.g., 'count', 'percentage', 'currency'
            $table->boolean('is_active')->default(true)->after('year');
            $table->string('source')->nullable()->after('is_active'); // Data source reference
            $table->json('metadata')->nullable()->after('source'); // Additional structured data
            $table->timestamp('last_updated_at')->nullable()->after('updated_at');
            
            // Add soft deletes
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('beneficiaries_stats', function (Blueprint $table) {
            $table->dropColumn([
                'unit',
                'is_active',
                'source',
                'metadata',
                'last_updated_at',
                'deleted_at'
            ]);
        });
    }
};



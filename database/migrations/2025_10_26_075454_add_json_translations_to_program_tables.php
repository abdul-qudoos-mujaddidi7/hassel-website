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
        $tables = [
            'training_programs',
            'smart_farming_programs',
            'seed_supply_programs',
            'market_access_programs',
            'community_programs',
            'agri_tech_tools'
        ];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                    if (!Schema::hasColumn($tableName, 'farsi_translations')) {
                        $table->json('farsi_translations')->nullable()->after('status');
                    }
                    if (!Schema::hasColumn($tableName, 'pashto_translations')) {
                        $table->json('pashto_translations')->nullable()->after('farsi_translations');
                    }
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'training_programs',
            'smart_farming_programs',
            'seed_supply_programs',
            'market_access_programs',
            'community_programs',
            'agri_tech_tools'
        ];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                    $columns = ['farsi_translations', 'pashto_translations'];
                    foreach ($columns as $column) {
                        if (Schema::hasColumn($tableName, $column)) {
                            $table->dropColumn($column);
                        }
                    }
                });
            }
        }
    }
};

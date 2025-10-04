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
            $table->enum('stat_type', [
                'beneficiaries', 
                'total_beneficiaries', 
                'male_beneficiaries', 
                'female_beneficiaries', 
                'programs_completed', 
                'provinces_reached', 
                'cooperatives_formed', 
                'projects', 
                'staff', 
                'partners'
            ])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('beneficiaries_stats', function (Blueprint $table) {
            $table->string('stat_type')->change();
        });
    }
};

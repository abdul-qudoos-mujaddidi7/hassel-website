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
        Schema::create('beneficiaries_stats', function (Blueprint $table) {
            $table->id();
            $table->string('stat_type'); // e.g., 'beneficiaries', 'projects', 'staff', 'partners'
            $table->bigInteger('value');
            $table->text('description')->nullable();
            $table->year('year')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiaries_stats');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    $tables = [
      'training_programs',
      'agri_tech_tools',
      'market_access_programs',
      'environmental_projects',
      'community_programs',
    ];

    foreach ($tables as $table) {
      Schema::table($table, function (Blueprint $table) {
        if (!Schema::hasColumn($table->getTable(), 'cover_image')) {
          $table->string('cover_image')->nullable()->after('id');
        }
        if (!Schema::hasColumn($table->getTable(), 'thumbnail_image')) {
          $table->string('thumbnail_image')->nullable()->after('cover_image');
        }
      });
    }
  }

  public function down(): void
  {
    $tables = [
      'training_programs',
      'agri_tech_tools',
      'market_access_programs',
      'environmental_projects',
      'community_programs',
    ];

    foreach ($tables as $table) {
      Schema::table($table, function (Blueprint $table) {
        if (Schema::hasColumn($table->getTable(), 'thumbnail_image')) {
          $table->dropColumn('thumbnail_image');
        }
        if (Schema::hasColumn($table->getTable(), 'cover_image')) {
          $table->dropColumn('cover_image');
        }
      });
    }
  }
};

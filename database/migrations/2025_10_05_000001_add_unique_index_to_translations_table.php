<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    if (Schema::hasTable('translations')) {
      Schema::table('translations', function (Blueprint $table) {
        // Create unique index (let the migration fail only on duplicate existing data)
        $table->unique([
          'model_type',
          'model_id',
          'field_name',
          'language',
        ], 'translations_model_field_lang_unique');
      });
    }
  }

  public function down(): void
  {
    if (Schema::hasTable('translations')) {
      Schema::table('translations', function (Blueprint $table) {
        try {
          $table->dropUnique('translations_model_field_lang_unique');
        } catch (\Throwable $e) {
          // ignore if index doesn't exist
        }
      });
    }
  }
};

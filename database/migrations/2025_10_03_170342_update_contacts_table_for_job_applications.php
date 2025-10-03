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
        Schema::table('contacts', function (Blueprint $table) {
            // Update subject column to use enum with different contact types
            $table->dropColumn('subject');
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->enum('subject', [
                'job_application',
                'technical_support',
                'partnership',
                'project_discussion',
                'general_inquiry',
                'media_inquiry',
                'other'
            ])->after('phone');

            // Add job application specific fields
            $table->string('job_title')->nullable()->after('subject');
            $table->unsignedBigInteger('job_id')->nullable()->after('job_title');
            $table->string('location')->nullable()->after('job_id');
            $table->string('cv_file_path')->nullable()->after('location');
            $table->text('cover_letter')->nullable()->after('cv_file_path');

            // Add foreign key constraint for job_id
            $table->foreign('job_id')->references('id')->on('job_announcements')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['job_id']);

            // Drop added columns
            $table->dropColumn([
                'subject',
                'job_title',
                'job_id',
                'location',
                'cv_file_path',
                'cover_letter'
            ]);
        });

        // Restore original subject column
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('subject')->after('phone');
        });
    }
};

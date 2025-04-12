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
        Schema::create('performance_new_reviews', function (Blueprint $table) {

           $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('reviewer_id');
            $table->date('review_date');

            // Employee Information
            $table->text('employee_number')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('department')->nullable();
            $table->string('employer')->nullable();
            $table->string('employee_name')->nullable();
            $table->string('review_attachment')->nullable();
            $table->string('status')->nullable();
            $table->string('stage')->nullable();
            $table->string('count')->nullable();
            // Ratings
            $ratings = [
                'knowledge_skill_rating',
                'industry_knowledge_rating',
                'knowledge_effectively_rating',
                'work_accuracy_rating',
                'attention_to_detail_rating',
                'work_standards_rating',
                'workload_management_rating',
                'problem_solving_rating',
                'work_efficiency_rating',
                'communication_clarity_rating',
                'listening_skills_rating',
                'feedback_sharing_rating',
                'team_contribution_rating',
                'cooperation_rating',
                'work_environment_rating',
                'attendance_rating',
                'punctuality_rating',
                'absence_notification_rating',
                'adaptability_rating',
                'decision_making_rating',
                'innovation_rating',
                'customer_service_rating',
                'issue_resolution_rating',
                'customer_satisfaction_rating',
                'leadership_skills_rating',
                'team_guidance_rating',
                'decision_responsibility_rating'
            ];

            foreach ($ratings as $rating) {
                $table->smallInteger($rating)->nullable()->check(function (Blueprint $table) use ($rating) {
                    return "$rating BETWEEN 1 AND 5";
                });
            }
            // Comments & Attachments
            $table->text('review_description')->nullable();
            $table->text('strengths')->nullable();
            $table->text('improvement_areas')->nullable();
            $table->text('improvement_plan')->nullable();
            $table->text('employee_comments')->nullable();
            $table->text('final_rating_approval')->nullable();
            $table->text('performance_review_attachment')->nullable();

            // Metadata
            $table->decimal('overall_rating', 3, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_new_reviews');
    }
};

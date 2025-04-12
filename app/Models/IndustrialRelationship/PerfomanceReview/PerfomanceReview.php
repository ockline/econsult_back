<?php

namespace App\Models\IndustrialRelationship\PerfomanceReview;

use Str;
use Illuminate\Database\Eloquent\Model;

class PerfomanceReview extends Model
{


    protected $table = 'performance_new_reviews';

    public $timestamps = true;

    protected $fillable = [
        'employee_id',
        'reviewer_id',
        'review_date',
        'employee_number',
        'first_name',
        'middle_name',
        'last_name',
        'department',
        'employer',
        'review_description',
        'strengths',
        'improvement_areas',
        'improvement_plan',
        'employee_comments',
        'final_rating_approval',
        'performance_review_attachment',
        'overall_rating',
        'employee_name',
        'review_attachment',
        'status',
        'stage',
        'count',
        'created_at',
        'updated_at',
 'knowledge_skill_rating', 'industry_knowledge_rating', 'knowledge_effectively_rating',
            'work_accuracy_rating', 'attention_to_detail_rating', 'work_standards_rating',
            'workload_management_rating', 'problem_solving_rating', 'work_efficiency_rating',
            'communication_clarity_rating', 'listening_skills_rating', 'feedback_sharing_rating',
            'team_contribution_rating', 'cooperation_rating', 'work_environment_rating',
            'attendance_rating', 'punctuality_rating', 'absence_notification_rating',
            'adaptability_rating', 'decision_making_rating', 'innovation_rating',
            'customer_service_rating', 'issue_resolution_rating', 'customer_satisfaction_rating',
            'leadership_skills_rating', 'team_guidance_rating', 'decision_responsibility_rating'
    ];

    // Add rating fields dynamically
    protected $casts = [
        'overall_rating' => 'decimal:2',
    ];

    // public static function boot()
    // {
    //     parent::boot();
    //     static::creating(function ($model) {
    //         $model->id = (string) \Str::uuid();
    //     });
    // }

    protected $guarded = [];
}

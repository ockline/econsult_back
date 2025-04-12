<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EMPLOYEE PERFORMANCE REVIEW FORM</title>
    <style>
        body {
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 14px;
            margin: 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td, th {
            padding: 6px;
            border: 1px solid #ccc;
            vertical-align: top;
        }

        .section-title {
            margin-top: 30px;
            margin-bottom: 10px;
            font-weight: bold;
            font-size: 16px;
            text-decoration: underline;
        }

        .no-border td {
            border: none;
            padding: 4px;
        }

        .comment-box {
            height: 60px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
            padding: 6px;
        }

        .signature-section {
            margin-top: 40px;
        }

        .signature-block {
            width: 45%;
            display: inline-block;
            vertical-align: top;
        }

        .text-bold {
            font-weight: bold;
        }

        .center {
            text-align: center;
        }
    </style>
</head>
<body>

@php
    $ratingMap = [
        5 => 'Excellent',
        4 => 'Good',
        3 => 'Satisfactory',
        2 => 'Needs Improvement',
        1 => 'Poor'
    ];
@endphp

<h2 class="center">EMPLOYEE PERFORMANCE REVIEW FORM</h2>

<div class="section-title">Employee Information</div>
<table class="border">
    <tr><td>Name:</td><td>{{ $data->employee_name ?? '__________________' }}</td></tr>
    <tr><td>Employee ID:</td><td>{{ $data->employee_id ?? '__________________' }}</td></tr>
    <tr><td>Department:</td><td>{{ $data->department ?? '__________________' }}</td></tr>
    <tr><td>Position:</td><td>{{ $data->job_title ?? '__________________' }}</td></tr>
    <tr><td>Review Period:</td><td>{{ $data->review_date ?? '__________________' }}</td></tr>
    <tr><td>Reviewer’s Name:</td><td>{{ $data->reviewer_name ?? '__________________' }}</td></tr>
    <tr><td>Reviewer’s Position:</td><td>{{ $data->reviewer_position ?? '__________________' }}</td></tr>
    <tr><td>Date of Review:</td><td>{{ $data->review_date ?? '__________________' }}</td></tr>
</table>

<div class="section-title">PERFORMANCE ASSESSMENT</div>
<p>(Use the following scale: 5-Excellent, 4-Good, 3-Satisfactory, 2-Needs Improvement, 1-Poor)</p>

<table>
    <thead>
        <tr>
            <th>Category</th>
            <th>Criteria</th>
            <th>Rating</th>
        </tr>
    </thead>
    <tbody>
        <tr><td rowspan="3">Job Knowledge & Skills</td><td>Demonstrates necessary skills and expertise</td><td>{{ $ratingMap[$data->knowledge_skill_rating ?? 0] ?? '' }}</td></tr>
        <tr><td>Keeps up-to-date with industry knowledge</td><td>{{ $ratingMap[$data->industry_knowledge_rating ?? 0] ?? '' }}</td></tr>
        <tr><td>Applies knowledge effectively</td><td>{{ $ratingMap[$data->knowledge_effectively_rating ?? 0] ?? '' }}</td></tr>

        <tr><td rowspan="3">Productivity & Efficiency</td><td>Manages workload effectively</td><td>{{ $ratingMap[$data->workload_management_rating ?? 0] ?? '' }}</td></tr>
        <tr><td>Problem-solving ability</td><td>{{ $ratingMap[$data->problem_solving_rating ?? 0] ?? '' }}</td></tr>
        <tr><td>Works efficiently</td><td>{{ $ratingMap[$data->work_efficiency_rating ?? 0] ?? '' }}</td></tr>

        <tr><td rowspan="3">Communication Skills</td><td>Communicates clearly</td><td>{{ $ratingMap[$data->communication_clarity_rating ?? 0] ?? '' }}</td></tr>
        <tr><td>Listens actively</td><td>{{ $ratingMap[$data->listening_skills_rating ?? 0] ?? '' }}</td></tr>
        <tr><td>Shares feedback</td><td>{{ $ratingMap[$data->feedback_sharing_rating ?? 0] ?? '' }}</td></tr>

        <tr><td rowspan="3">Teamwork & Collaboration</td><td>Team contribution</td><td>{{ $ratingMap[$data->team_contribution_rating ?? 0] ?? '' }}</td></tr>
        <tr><td>Cooperation</td><td>{{ $ratingMap[$data->cooperation_rating ?? 0] ?? '' }}</td></tr>
        <tr><td>Positive work environment</td><td>{{ $ratingMap[$data->work_environment_rating ?? 0] ?? '' }}</td></tr>

        <tr><td rowspan="3">Attendance & Punctuality</td><td>Attendance</td><td>{{ $ratingMap[$data->attendance_rating ?? 0] ?? '' }}</td></tr>
        <tr><td>Punctuality</td><td>{{ $ratingMap[$data->punctuality_rating ?? 0] ?? '' }}</td></tr>
        <tr><td>Absence notification</td><td>{{ $ratingMap[$data->absence_notification_rating ?? 0] ?? '' }}</td></tr>

        <tr><td rowspan="3">Adaptability & Problem-Solving</td><td>Adjusts to changes</td><td>{{ $ratingMap[$data->adaptability_rating ?? 0] ?? '' }}</td></tr>
        <tr><td>Decision-making</td><td>{{ $ratingMap[$data->decision_making_rating ?? 0] ?? '' }}</td></tr>
        <tr><td>Innovative thinking</td><td>{{ $ratingMap[$data->innovation_rating ?? 0] ?? '' }}</td></tr>

        <tr><td rowspan="3">Customer Service</td><td>Service delivery</td><td>{{ $ratingMap[$data->customer_service_rating ?? 0] ?? '' }}</td></tr>
        <tr><td>Issue resolution</td><td>{{ $ratingMap[$data->issue_resolution_rating ?? 0] ?? '' }}</td></tr>
        <tr><td>Client satisfaction</td><td>{{ $ratingMap[$data->customer_satisfaction_rating ?? 0] ?? '' }}</td></tr>

        <tr><td rowspan="3">Leadership & Initiative</td><td>Leadership skills</td><td>{{ $ratingMap[$data->leadership_skills_rating ?? 0] ?? '' }}</td></tr>
        <tr><td>Guides team</td><td>{{ $ratingMap[$data->team_guidance_rating ?? 0] ?? '' }}</td></tr>
        <tr><td>Decision responsibility</td><td>{{ $ratingMap[$data->decision_responsibility_rating ?? 0] ?? '' }}</td></tr>

        <tr>
            <td colspan="2" class="text-bold">Overall Rating</td>
            <td class="text-bold">{{ $ratingMap[$data->overall_rating ?? 0] ?? '' }}</td>
        </tr>
    </tbody>
</table>

<div class="section-title">STRENGTHS & AREAS FOR IMPROVEMENT</div>
<p><strong>Strengths:</strong></p>
<div class="comment-box">{{ $data->strengths ?? '' }}</div>
<p><strong>Areas for Improvement:</strong></p>
<div class="comment-box">{{ $data->improvement_areas ?? '' }}</div>

<div class="section-title">GOALS & DEVELOPMENT PLAN</div>
<div class="comment-box">{{ $data->improvement_plan ?? '' }}</div>

<div class="section-title">EMPLOYEE COMMENTS</div>
<div class="comment-box">{{ $data->employee_comments ?? '' }}</div>

<div class="section-title">FINAL RATING & APPROVAL</div>
<table class="no-border">
    <tr>
        <td><strong>Overall Performance Rating (Average Score):</strong></td>
        <td>{{ $ratingMap[$data->final_rating_approval ?? 0] ?? '' }}</td>
    </tr>
</table>

<div class="signature-section">
    <div class="signature-block">
        <p>Reviewer’s Signature: ___________________</p>
        <p>Date: ___________________</p>
    </div>
    <div class="signature-block">
        <p>Employee’s Signature: ___________________</p>
        <p>Date: ___________________</p>
    </div>
</div>

<p style="margin-top: 30px; font-style: italic;">
    *Completion of this form does not guarantee any salary increase, promotion, or employment continuation.
</p>

</body>
</html>

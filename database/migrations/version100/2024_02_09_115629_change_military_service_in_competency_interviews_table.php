<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // Add temporary columns with the desired type for the remaining boolean columns
        Schema::table('competency_interviews', function (Blueprint $table) {
            $table->smallInteger('temp_relative_inside')->comment('1 - yes, 2 - No');
            $table->smallInteger('temp_chronic_disease')->comment('1 - yes, 2 - No');
            $table->smallInteger('temp_pregnant')->comment('if 0 - No, else Yes');
            $table->smallInteger('temp_employed_before')->comment('1 - yes, 2 - No');
            $table->smallInteger('temp_reference_check')->comment('1 - yes, 2 - No');
            $table->smallInteger('temp_social_insuarance_status')->comment('1 - yes, 2 - No');
            $table->smallInteger('temp_work_site')->comment('1 - yes, 2 - No');
            $table->smallInteger('temp_reallocation_place')->comment('1 - yes, 2 - No');
            // $table->smallInteger('temp_recruiter_recommendations')->comment('1 - Accepted, 2 - Not Accepted, 3 - Waiting List');
            $table->smallInteger('temp_downloaded')->comment('1 - yes, 2 - No');
            $table->smallInteger('temp_uploaded')->comment('1 - yes, 2 - No');
        });

        // Update the temporary columns with the values from the original columns
        DB::statement('
            UPDATE competency_interviews SET
                temp_relative_inside = CASE WHEN relative_inside THEN 1 ELSE 0 END,
                temp_chronic_disease = CASE WHEN chronic_disease THEN 1 ELSE 0 END,
                temp_pregnant = CASE WHEN pregnant THEN 1 ELSE 0 END,
                temp_employed_before = CASE WHEN employed_before THEN 1 ELSE 0 END,
                temp_reference_check = CASE WHEN reference_check THEN 1 ELSE 0 END,
                temp_social_insuarance_status = CASE WHEN social_insuarance_status THEN 1 ELSE 0 END,
                temp_work_site = CASE WHEN work_site THEN 1 ELSE 0 END,
                temp_reallocation_place = CASE WHEN reallocation_place THEN 1 ELSE 0 END,
                 temp_downloaded = CASE WHEN downloaded THEN 1 ELSE 0 END,
                temp_uploaded = CASE WHEN uploaded THEN 1 ELSE 0 END
        ');

        // Remove the original columns
        Schema::table('competency_interviews', function (Blueprint $table) {
            $table->dropColumn([
                'relative_inside',
                'chronic_disease',
                'pregnant',
                'employed_before',
                'reference_check',
                'social_insuarance_status',
                'work_site',
                'reallocation_place',
                // 'recruiter_recommendations',
                'downloaded',
                'uploaded',
            ]);
        });

        // Rename the temporary columns to the original column names
        Schema::table('competency_interviews', function (Blueprint $table) {
            $table->renameColumn('temp_relative_inside', 'relative_inside')->comment('1 - yes, 2 - No');
            $table->renameColumn('temp_chronic_disease', 'chronic_disease')->comment('1 - yes, 2 - No');
            $table->renameColumn('temp_pregnant', 'pregnant')->comment('if 0 - No, else Yes');
            $table->renameColumn('temp_employed_before', 'employed_before')->comment('1 - yes, 2 - No');
            $table->renameColumn('temp_reference_check', 'reference_check')->comment('1 - yes, 2 - No');
            $table->renameColumn('temp_social_insuarance_status', 'social_insuarance_status')->comment('1 - yes, 2 - No');
            $table->renameColumn('temp_work_site', 'work_site')->comment('1 - yes, 2 - No');
            $table->renameColumn('temp_reallocation_place', 'reallocation_place')->comment('1 - yes, 2 - No');
            // $table->renameColumn('temp_recruiter_recommendations', 'recruiter_recommendations')->comment('1 - Accepted, 2 - Not Accepted, 3 - Waiting List');
            $table->renameColumn('temp_downloaded', 'downloaded')->comment('1 - yes, 2 - No');
            $table->renameColumn('temp_uploaded', 'uploaded')->comment('1 - yes, 2 - No');
        });
    }

    public function down(): void
    {
        // Add temporary columns with the BOOLEAN type for the original boolean columns
        Schema::table('competency_interviews', function (Blueprint $table) {
            $table->boolean('temp_relative_inside')->comment('1 - yes, 2 - No');
            $table->boolean('temp_chronic_disease')->comment('1 - yes, 2 - No');
            $table->boolean('temp_pregnant')->comment('if 0 - No, else Yes');
            $table->boolean('temp_employed_before')->comment('1 - yes, 2 - No');
            $table->boolean('temp_reference_check')->comment('1 - yes, 2 - No');
            $table->boolean('temp_social_insuarance_status')->comment('1 - yes, 2 - No');
            $table->boolean('temp_work_site')->comment('1 - yes, 2 - No');
            $table->boolean('temp_reallocation_place')->comment('1 - yes, 2 - No');
            // $table->boolean('temp_recruiter_recommendations')->comment('1 - Accepted, 2 - Not Accepted, 3 - Waiting List');
            $table->boolean('temp_downloaded')->comment('1 - yes, 2 - No');
            $table->boolean('temp_uploaded')->comment('1 - yes, 2 - No');
        });

        // Update the temporary columns with the values from the original columns
        DB::statement('UPDATE competency_interviews SET
            temp_relative_inside = CASE WHEN relative_inside = 1 THEN true ELSE false END,
            temp_chronic_disease = CASE WHEN chronic_disease = 1 THEN true ELSE false END,
            temp_pregnant = CASE WHEN pregnant = 1 THEN true ELSE false END,
            temp_employed_before = CASE WHEN employed_before = 1 THEN true ELSE false END,
            temp_reference_check = CASE WHEN reference_check = 1 THEN true ELSE false END,
            temp_social_insuarance_status = CASE WHEN social_insuarance_status = 1 THEN true ELSE false END,
            temp_work_site = CASE WHEN work_site = 1 THEN true ELSE false END,
            temp_reallocation_place = CASE WHEN reallocation_place = 1 THEN true ELSE false END,
            temp_downloaded = CASE WHEN downloaded = 1 THEN true ELSE false END,
            temp_uploaded = CASE WHEN uploaded = 1 THEN true ELSE false END'
        );

        // Remove the original columns
        Schema::table('competency_interviews', function (Blueprint $table) {
            $table->dropColumn([
                'relative_inside',
                'chronic_disease',
                'pregnant',
                'employed_before',
                'reference_check',
                'social_insuarance_status',
                'work_site',
                'reallocation_place',
                // 'recruiter_recommendations',
                'downloaded',
                'uploaded',
            ]);
        });

        // Rename the temporary columns to the original column names
        Schema::table('competency_interviews', function (Blueprint $table) {
            $table->renameColumn('temp_relative_inside', 'relative_inside')->comment('1 - yes, 2 - No');
            $table->renameColumn('temp_chronic_disease', 'chronic_disease')->comment('1 - yes, 2 - No');
            $table->renameColumn('temp_pregnant', 'pregnant')->comment('if 0 - No, else Yes');
            $table->renameColumn('temp_employed_before', 'employed_before')->comment('1 - yes, 2 - No');
            $table->renameColumn('temp_reference_check', 'reference_check')->comment('1 - yes, 2 - No');
            $table->renameColumn('temp_social_insuarance_status', 'social_insuarance_status')->comment('1 - yes, 2 - No');
            $table->renameColumn('temp_work_site', 'work_site')->comment('1 - yes, 2 - No');
            $table->renameColumn('temp_reallocation_place', 'reallocation_place')->comment('1 - yes, 2 - No');
            // $table->renameColumn('temp_recruiter_recommendations', 'recruiter_recommendations')->comment('1 - Accepted, 2 - Not Accepted, 3 - Waiting List');
            $table->renameColumn('temp_downloaded', 'downloaded')->comment('1 - yes, 2 - No');
            $table->renameColumn('temp_uploaded', 'uploaded')->comment('1 - yes, 2 - No');
        });
    }
};

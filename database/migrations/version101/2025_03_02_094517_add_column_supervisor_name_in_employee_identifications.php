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
        Schema::table('employee_identifications', function (Blueprint $table) {
             $table->integer('id_type')->nullable();
             $table->integer('new_job_title_id')->nullable();
            $table->integer('new_department_id')->nullable();
            $table->string('effective_date')->nullable();
            $table->string('supervisor_name')->nullable();
            $table->boolean('safety_induction')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_number')->nullable();
            $table->string('manager_name')->nullable();
            $table->string('approval_date')->nullable();
            $table->text('signature')->nullable();
            $table->string('training_hr_manager')->nullable();
            $table->string('course_study')->nullable();
            $table->string('institution_name')->nullable();
            $table->string('security_officer')->nullable();
            $table->string('host_name')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('organization')->nullable();
            $table->string('position')->nullable();
            $table->string('email_address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('contact_person')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_identifications', function (Blueprint $table) {
            $table->dropColumn('id_type');
            $table->dropColumn('new_job_title_id');
            $table->dropColumn('new_department_id');
            $table->dropColumn('effective_date');
            $table->dropColumn('supervisor_name');
            $table->dropColumn('safety_induction');
            $table->dropColumn('emergency_contact_name');
            $table->dropColumn('emergency_contact_number');
            $table->dropColumn('manager_name');
            $table->dropColumn('approval_date');
            $table->dropColumn('signature');
            $table->dropColumn('training_hr_manager');
            $table->dropColumn('course_study');
            $table->dropColumn('institution_name');
            $table->dropColumn('security_officer');
            $table->dropColumn('host_name');
            $table->dropColumn('contact_number');
            $table->dropColumn('organization');
            $table->dropColumn('position');
            $table->dropColumn('email_address');
            $table->dropColumn('phone_number');
            $table->dropColumn('contact_person');

        });
    }
};

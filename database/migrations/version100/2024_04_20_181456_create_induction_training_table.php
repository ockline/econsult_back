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
        Schema::create('induction_trainings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('social_record_id')->unsigned();
            $table->unsignedBigInteger('employer_id')->nullable()->after('job_title_id');
            $table->string('employer_address');
            $table->string('contact_personal');
            $table->bigInteger('job_title_id')->nullable()->comment('position applied');
            $table->string('personal_contacts');
            $table->string('personal_designation')->nullable();
            $table->string('firstname');
            $table->string('middlename');
            $table->string('lastname');
            $table->bigInteger('department_id');
            $table->string('reporting_to')->nullable();
            $table->text('business')->nullable();
            $table->date('employment_date');
            $table->text('establishment')->nullable();
            $table->string('roles_key')->nullable();
            $table->text('employee_remuneration')->nullable();
            $table->text('employment_condition')->nullable();
            $table->text('environment')->nullable();
            $table->text('apropos_training')->nullable();
            $table->text('health_safety')->nullable();
            $table->text('conduct_follow_up')->nullable();
            $table->text('comments')->nullable();
            $table->text('notes')->nullable();
            $table->bigInteger('conducted_by')->nullable()->comment('employee or staff number');
            $table->date('conducted_date')->nullable();
            $table->string('declaration')->nullable()->comment('will be used when will be full automation');
            $table->integer('downloaded')->nullable()->comment('1 - yes, 2- No');
            $table->integer('uploaded')->nullable()->comment('1 - yes, 2- No');
            $table->date('uploaded_date')->nullable();
            $table->integer('stage')->nullable()->comment('0 - partial completed(This will be when other detail filled except  uploaded signed documents), 1 - Completed');
            $table->integer('progressive_stage')->nullable()->comment('1 - Employee details, 2 - Supportive Document, 3 - Social Record, 4 - Induction training, 5 - Contarct, 6 - Person ID , 7 - Employee Registration Completed');
            $table->integer('status')->nullable()->comment('0 - submitted, 1 - initiated, 2 - pending, 3 - Approved, 4 - rejected');
            $table->foreign('job_title_id')->references('id')->on('job_title')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('employer_id')->references('id')->on('employers')->onDelete('RESTRICT')->onUpdate('CASCADE');

            $table->foreign('department_id')->references('id')->on('departments')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('induction_trainings');
    }
};

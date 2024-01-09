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
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employer_id')->unsigned();
            $table->bigInteger('employee_no')->unique()->nullable();
            $table->bigInteger('interview_number')->unique()->nullable()->comment('position applied');
            $table->bigInteger('job_title_id')->unsigned()->comment('position applied');
            $table->bigInteger('cost_center_id')->unsigned();
            $table->bigInteger('cost_number')->unsigned()->comment('job code');
            $table->string('employee_name');
            $table->string('name_language')->nullable();
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');
            $table->integer('package_id')->unsigned();
            $table->integer('department_id')->unsigned();
            $table->integer('national_id')->unsigned()->index('national_id');
            $table->integer('passport_id')->nullable()->comment('For forigner');
            $table->integer('military_service')->comment('1 -Completed, 2- Didnt Attend');
            $table->integer('marital_status')->comment('1 - married, 2 - Single, 3 - divorced');
            $table->string('spause_name')->nullable();
            $table->integer('gender')->comment('1 - Male, 2- Female');
            $table->string('telephone_home');
            $table->string('telephone_office');
            $table->string('mobile_number');
            $table->string('email');
            $table->date('dob');
            $table->integer('nationality_id')->unsigned();
            $table->string('driving_licence');
            $table->string('place_issued');
            $table->integer('chronic_disease')->comment('1 - yes, 2 - No');
            $table->text('chronic_remark')->nullable();
            $table->integer('surgery_operation ')->comment('1 - yes, 2- No');
            $table->text('surgery_remark')->nullable();
            $table->integer('employed_before')->comment('1 - yes, 2- No');
            $table->date('from_date')->nullable()->comment('if yes');
            $table->date('to_date')->nullable()->comment('if yes');
            $table->string('position')->nullable();
            $table->integer('relative_working')->comment('1 - yes(Do you have any relative working for This company?), 2 - No');
            $table->string('relative_name')->nullable()->comment('Relative name it depend on the last column');
            $table->integer('former_department')->nullable()->comment('if have have employeed before');
            $table->date('transfer_change')->nullable();
            $table->text('transfer_reasons')->nullable();
            $table->integer('bank_id')->unsigned();
            $table->integer('account_number')->comment('Bank account number');
            $table->integer('bank_branch_id')->nullable();
            $table->integer('account_name')->comment('Bank account name');
            $table->integer('nssf')->comment('Membership for NAtional Social security fund');
            $table->integer('wcf')->comment('Membership for Workers Compensation fund');
            $table->integer('tin')->comment('Membership for Tax Identification number');
            $table->integer('nhif')->comment('Membership for NAtional health insuarance fund');
            // $table->integer('education_history_id')->unsigned();
            $table->string('company_name')->nullable()->comment('Former updated employer ');
            $table->date('employer_from_date')->nullable();
            $table->date('employer_to_date')->nullable();
            $table->text('readiness_employee')->nullable()->comment('i.	When would you be able to start work, if you were offered a position?');
            $table->integer('downloaded')->nullable()->comment('1 - yes, 2- No');
            $table->integer('uploaded')->nullable()->comment('1 - yes, 2- No');
            $table->date('uploaded_date')->nullable();
            $table->integer('stage')->nullable()->comment('0 - partial completed(This will be when other detail filled except  uploaded signed documents), 1 - Completed');
            $table->integer('progressive_stage')->nullable()->comment('1 - Employee details, 2 - Supportive Document, 3 - Social Record, 4 - Induction training 5 - Contarct, 6 - Person ID , 7 - Employee Registration Completed');
            $table->integer('status')->nullable()->comment('0 - submitted, 1 - initiated, 2 - pending, 3 - Approved, 4 - rejected');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('job_title_id')->references('id')->on('job_title')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('employer_id')->references('id')->on('employers')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('cost_center_id')->references('id')->on('cost_centers')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('nationality_id')->references('id')->on('countries')->onUpdate('CASCADE')->onDelete('RESTRICT');
            // $table->foreign('education_history_id')->references('id')->on('education_histories')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};

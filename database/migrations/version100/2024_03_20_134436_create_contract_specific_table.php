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
        Schema::create('contract_specific', function (Blueprint $table) {
  $table->id();
            $table->string('name', 191)->nullable();
            $table->unsignedBigInteger('employee_id')->unsigned();
            $table->string('employer_name');
            $table->string('employee_name');
            $table->bigInteger('job_title_id')->nullable()->comment('position applied');
            $table->unsignedBigInteger('reg_number');
            $table->integer('department_id');
            $table->unsignedBigInteger('nssf_number');
            $table->string('phone_number');
            $table->string('email');
            $table->string('residence_place');
            $table->string('bank_name');
            $table->unsignedBigInteger('bank_account_no');
            $table->string('bank_account_name');
            $table->date('dob');
            $table->text('gender');
            $table->string('supervisor')->nullable();
            $table->string('place_recruitment');
            $table->text('work_station')->nullable();
            $table->date('start_date');
            $table->date('expected_end_date');
            $table->float('monthly_salary', 2);
            $table->float('basic_salary', 2)->nullable();
            // Change the column type from text to double precision
            $table->text('house_allowance')->nullable();
            $table->text('meal_allowance')->nullable();
            $table->text('transport_allowance')->nullable();
            $table->text('risk_bush_allowance')->nullable();
            $table->string('normal_working')->nullable()->comment('default day');
            $table->string('ordinary_working');
            $table->text('working_from')->nullable();
            $table->text('working_to')->nullable();
            $table->text('saturday_from')->nullable();
            $table->text('saturday_to')->nullable();
            $table->string('night_shift');
            $table->text('night_working_from')->nullable();
            $table->text('night_working_to')->nullable();
            $table->text('night_shift_hours')->nullable();
            $table->integer('downloaded')->nullable()->comment('1 - yes, 2- No');
            $table->integer('uploaded')->nullable()->comment('1 - yes, 2- No');
            $table->date('uploaded_date')->nullable();
            $table->integer('stage')->nullable()->comment('0 - partial completed(This will be when other detail filled except  uploaded signed documents), 1 - Completed');
            $table->integer('progressive_stage')->nullable()->comment('1 - Employee details, 2 - Supportive Document, 3 - Social Record, 4 - Induction training, 5 - Contarct, 6 - Person ID , 7 - Employee Registration Completed');
            $table->integer('status')->nullable()->comment('0 - submitted, 1 - initiated, 2 - pending, 3 - Approved, 4 - rejected');
            $table->foreign('job_title_id')->references('id')->on('job_title')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('department_id')->references('id')->on('departments')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('employee_id')->references('id')->on('employees')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract_specific');
    }
};

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
        Schema::create('contract_fixed', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191)->nullable();
            $table->unsignedBigInteger('employee_id')->unsigned();
            $table->string('employer_name');
            $table->string('employee_name');
            $table->bigInteger('job_title_id')->nullable()->comment('position applied');
            $table->string('phone_number');
            $table->string('email');
            $table->date('dob');
            $table->text('job_profile')->nullable();
            $table->string('reporting_to');
            $table->string('staff_classfication');
            $table->string('place_recruitment');
            $table->text('work_station')->nullable();
            $table->date('commencement_date');
            $table->date('end_commencement_date');
            $table->string('probation_period');
            $table->float('remuneration', 2);
            $table->float('basic_salary', 2)->nullable();
            $table->float('house_allowance', 2);
            $table->float('meal_allowance', 2);
            $table->float('transport_allowance', 2);
            $table->float('risk_bush_allowance', 2);
            $table->string('normal_working')->nullable();
            $table->string('ordinary_working');
            $table->text('working_from')->nullable();
            $table->text('working_to')->nullable();
            $table->text('saturday_from')->nullable();
            $table->text('saturday_to')->nullable();
            $table->text('covered_statutory')->nullable();
            $table->integer('downloaded')->nullable()->comment('1 - yes, 2- No');
            $table->integer('uploaded')->nullable()->comment('1 - yes, 2- No');
            $table->date('uploaded_date')->nullable();
            $table->integer('stage')->nullable()->comment('0 - partial completed(This will be when other detail filled except  uploaded signed documents), 1 - Completed');
            $table->integer('progressive_stage')->nullable()->comment('1 - Employee details, 2 - Supportive Document, 3 - Social Record, 4 - Induction training, 5 - Contarct, 6 - Person ID , 7 - Employee Registration Completed');
            $table->integer('status')->nullable()->comment('0 - submitted, 1 - initiated, 2 - pending, 3 - Approved, 4 - rejected');
            $table->foreign('job_title_id')->references('id')->on('job_title')->onUpdate('CASCADE')->onDelete('RESTRICT');
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
        Schema::dropIfExists('contract_fixed');
    }
};

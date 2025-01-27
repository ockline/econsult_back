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
        Schema::create('attendance_monthly', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employee_id');
            $table->bigInteger('employer_id')->nullable();
            $table->string('employee_name');
            $table->bigInteger('old_id')->nullable();
            $table->string('firstname')->nullable();
            $table->string('middlename')->nullable();
            $table->string('lastname')->nullable();
            $table->string('shift')->nullable();
            $table->text('package_name')->nullable();
            $table->text('title')->nullable();
            $table->string('department')->nullable();
            $table->string('join_date')->nullable();
            $table->string('location')->nullable();
            $table->string('contract_type')->nullable();
            $table->integer('remaining_day')->nullable();
            $table->string('deductions')->nullable();
            $table->string('night_shift_days')->nullable();
            $table->integer('fulfilment')->nullable();
            $table->integer('actual_working_days')->nullable();
            $table->integer('annual_leave')->nullable();
            $table->integer('unpaid_leave')->nullable();
            $table->integer('sick_leave_fully')->nullable();
            $table->integer('sick_leave_half')->nullable();
            $table->integer('sick_leave_unpaid')->nullable();
            $table->integer('absent_days')->nullable();
            $table->string('mission')->nullable();
            $table->integer('maternity_leave')->nullable();
            $table->integer('compassionate_leave')->nullable();
            $table->integer('paternity_leave')->nullable();
            $table->integer('ot_hours')->nullable();
            $table->integer('missing_day_prev_month')->nullable();
            $table->integer('total_paid_working_day')->nullable();
            $table->integer('total_ot_before')->nullable()->comment('total ot hours before 18:00');
            $table->integer('total_ot_after')->nullable()->comment('total ot hours after 18:00');
            $table->integer('actual_working_hours_inc')->nullable()->comment('Actual working hours include OT');
            $table->integer('actual_working_hours_exc')->nullable()->comment('Actual working hours exclude OT');
            $table->integer('missing_ot')->nullable()->comment('Missing OT for Normal days from previous Month(s)');
            $table->integer('total_weekdays_overtime')->nullable();
            $table->integer('missing_sunday_ot')->nullable()->comment('Missing sunday OT  from previous Month(s)');
            $table->integer('sundays_overtime')->nullable();
            $table->integer('missing_holiday_ot')->nullable()->comment('Missing Official Holidays OT  from previous Month(s)');
            $table->integer('public_holiday_ot')->nullable()->comment(' Public Holidays Overtime');
            $table->integer('multiplier')->nullable();
            $table->integer('sunday')->nullable()->comment('');
            $table->integer('public_holiday')->nullable();
             $table->text('remarks')->nullable();
            $table->text('refund_day_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_monthly');
    }
};

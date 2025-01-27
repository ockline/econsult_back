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
        Schema::create('performance_assessments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('capacity_id');
            $table->bigInteger('sequence');
            $table->text('illness_cause');
            $table->text('illness_degree');
            $table->string('occupation_illness')->nullable()->comment('yes or no');
            $table->text('occupation_justification')->nullable()->comment('If yes , please justify ');
            $table->text('possible_nature_illness')->nullable()->comment('What is the possible nature of the illness/injury? ');
            $table->text('permanent_alternative_activity')->nullable()->comment('If existing illness is permanent, what are the alternative activity we may provide to patient without affect his/her health?');
            $table->text('total_recovery_activity')->nullable()->comment('If existing illness is temporary, when do we expect the partied may totally recovery');
            $table->text('suggested_task')->nullable()->comment('What are the Suggested task may patient work during recovery period?');
            $table->text('measure_taken')->nullable()->comment('What are the precaution/ measures to be taken by employer/ supervisor during recovery period of patient?');
            $table->text('assessor_recommendation')->nullable()->comment('What are the recommendation of doctor to employer for this patient');
            $table->string('assessor_name')->nullable();
            $table->text('assessor_designation')->nullable();
            $table->string('assessmnet_date')->nullable();
            $table->text('assessor_signature')->nullable();
            $table->text('assessment_signed_attchment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_assessments');
    }
};

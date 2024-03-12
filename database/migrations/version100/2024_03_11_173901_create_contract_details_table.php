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
        Schema::create('contract_details', function (Blueprint $table) {
            $table->id();
            $table->integer('contract_id')->unsigned();
            $table->unsignedBigInteger('employee_id')->unsigned();
            $table->unsignedBigInteger('employer_id')->unsigned();
            $table->bigInteger('job_title_id')->nullable()->comment('position applied');
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');
            $table->integer('gender')->comment('1 - Male, 2- Female');
            $table->string('phone_number');
            $table->string('email');
            $table->date('dob');
            $table->integer('age');
            $table->string('postal_address');
            $table->string('residence_place');
            $table->string('permanent_residence');
            $table->string('place_recruitment');
            $table->text('work_station')->nullable();
            $table->date('date_employed');
            $table->string('fullname_next1');
            $table->string('residence1');
            $table->string('phone_number1');
            $table->integer('relationship1')->nullable();
            $table->string('fullname_next2');
            $table->string('residence2');
            $table->string('phone_number2');
            $table->integer('relationship2')->nullable();
            $table->integer('downloaded')->nullable()->comment('1 - yes, 2- No');
            $table->integer('uploaded')->nullable()->comment('1 - yes, 2- No');
            $table->date('uploaded_date')->nullable();
            $table->integer('stage')->nullable()->comment('0 - partial completed(This will be when other detail filled except  uploaded signed documents), 1 - Completed');
            $table->integer('progressive_stage')->nullable()->comment('1 - Employee details, 2 - Supportive Document, 3 - Social Record, 4 - Induction training 5 - Contarct, 6 - Person ID , 7 - Employee Registration Completed');
            $table->integer('status')->nullable()->comment('0 - submitted, 1 - initiated, 2 - pending, 3 - Approved, 4 - rejected');
            $table->foreign('contract_id')->references('id')->on('contracts')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('job_title_id')->references('id')->on('job_title')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('employee_id')->references('id')->on('employees')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('employer_id')->references('id')->on('employers')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract_details');
    }
};

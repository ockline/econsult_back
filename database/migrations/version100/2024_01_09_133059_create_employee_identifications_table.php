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
        Schema::create('employee_identifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('personal_type');
            $table->integer('employer_id')->unsigned();
            $table->bigInteger('employee_id')->unique()->nullable();
            $table->string('transfer_from')->nullable()->comment('if have trasfered');
            $table->integer('site_pass_type')->comment('1- permanent, 2- Temporary');
            $table->string('from_date')->comment('if is temporary')->nullable();
            $table->string('end_date')->comment('if is temporary')->nullable();
            $table->integer('department_id')->unsigned();
            $table->integer('section_id')->unsigned();
            $table->integer('downloaded')->nullable()->comment('1 - yes, 2- No');
            $table->integer('national_id_uploaded')->nullable()->comment('1 - yes, 2- No');
            $table->integer('practical_uploaded')->nullable()->comment('1 - yes, 2- No');
            $table->integer('technical_uploaded')->nullable()->comment('1 - yes, 2- No');
            $table->integer('driving_licence_uploaded')->nullable()->comment('1 - yes, 2- No');
            $table->date('uploaded_date')->nullable();
            $table->integer('stage')->nullable()->comment('0 - partial completed(This will be when other detail filled except  uploaded signed documents), 1 - Completed');
            $table->integer('progressive_stage')->nullable()->comment('1 - Employee details, 2 - Supportive Document, 3 - Social Record, 4 - Induction training 5 - Contarct, 6 - Person ID , 7 - Employee Registration Completed');
            $table->integer('status')->nullable()->comment('0 - submitted, 1 - initiated, 2 - pending, 3 - Approved, 4 - rejected');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('employee_id')->references('id')->on('employees')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('employer_id')->references('id')->on('employers')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('department_id')->references('id')->on('departments')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('section_id')->references('id')->on('units')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_identifications');
    }
};

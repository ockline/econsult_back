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
        Schema::create('social_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employer_id')->unsigned();
            $table->bigInteger('employee_id')->unique()->nullable();
            $table->integer('district_id')->unsigned();
            $table->integer('department_id')->unsigned();
            $table->integer('section_id')->unsigned();
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');
            $table->integer('national_id')->unsigned();
            $table->date('expiration_date');
            $table->integer('passport_id')->nullable()->comment('For forigner');
            $table->integer('military_service')->comment('1 -Completed, 2- Didnt Attend');
            $table->integer('marital_status')->comment('1 - married, 2 - Single, 3 - divorced');
            $table->integer('children_no')->nullable();
            $table->integer('gender')->comment('1 - Male, 2- Female');
            $table->string('telephone_home');
            $table->string('mobile_number');
            $table->string('person_email');
            $table->string('employee_street')->nullable();
            $table->string('ward');
            $table->string('city');
            $table->string('postal_address');
            $table->integer('relative_working')->comment('1 - yes(Do you have any relative working for This company?), 2 - No');
            $table->string('relative_name')->nullable()->comment('Relative name it depend on the last column');
            $table->integer('tin')->comment('Membership for Tax Identification number');
            $table->text('readiness_employee')->nullable()->comment('i.	When would you be able to start work, if you were offered a position?');
            $table->integer('downloaded')->nullable()->comment('1 - yes, 2- No');
            $table->integer('uploaded')->nullable()->comment('1 - yes, 2- No');
            $table->date('uploaded_date')->nullable();
            $table->integer('stage')->nullable()->comment('0 - partial completed(This will be when other detail filled except  uploaded signed documents), 1 - Completed');
            $table->integer('progressive_stage')->nullable()->comment('1 - Employee details, 2 - Supportive Document, 3 - Social Record, 4 - Induction training 5 - Contarct, 6 - Person ID , 7 - Employee Registration Completed');
            $table->integer('status')->nullable()->comment('0 - submitted, 1 - initiated, 2 - pending, 3 - Approved, 4 - rejected');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('district_id')->references('id')->on('districts')->onUpdate('CASCADE')->onDelete('RESTRICT');
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
        Schema::dropIfExists('social_records');
    }
};

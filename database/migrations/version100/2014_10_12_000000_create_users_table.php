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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('samaccountname');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('firstname');
            $table->string('middlename');
            $table->string('lastname');
            $table->string('phone');
            $table->integer('gender_id')->comment('1 - Male, 2 - Female ');
            $table->date('dob');
            $table->integer('employer_id')->unsigned()->index('employer_id');
            $table->integer('department_id')->unsigned()->index('department_id');
            $table->integer('designation_id')->unsigned()->index('designation_id');
            $table->integer('section_id')->unsigned()->index('section_id');
            $table->integer('created_by')->comment('its user id');
            $table->date('last_login');
            $table->integer('active')->default(1);
            $table->integer('available')->default(1);
            $table->string('project_name')->nullable();
            $table->string('location_project')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

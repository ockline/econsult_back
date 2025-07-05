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

            Schema::create('disciplinary_appeals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('disciplinary_id')->nullable();
            $table->string('comments', 4000)->nullable()->comment('reason to initiate appeal');
            $table->integer('count')->nullable();
            $table->boolean('is_notice_appeal')->default(false);
            $table->date('appeal_date')->nullable();
            $table->boolean('is_employee_appeal')->default(false);
            $table->string('status')->nullable();
            $table->string('stage')->nullable();
            $table->unsignedBigInteger('initiated_by')->nullable();
            $table->dateTime('initiated_date')->nullable();
            $table->string('source')->nullable();
            $table->string('appeal_outcome')->nullable()->comment('Appeal Dismissed or Appeal Allowed if  dismissed it means we continue with hearing');
            $table->timestamps(); // created_at and updated_at
            $table->softDeletes(); // deleted_at
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->dateTime('modified_date')->nullable();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disciplinary_appeals');
    }
};

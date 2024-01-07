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
        Schema::create('audits', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned()->index('user_id');
            $table->integer('event')->unsigned();
            $table->integer('auditable_id')->unsigned()->index('auditable_id');
            $table->integer('auditable_type');
            $table->text('old_values')->nullable();
            $table->text('new_values')->nullable();
            $table->text('url');
            $table->string('ip_address');
            $table->string('user_agent');
            $table->string('user_type');
            $table->string('tags')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->integer('deleted_by')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audits');
    }
};
